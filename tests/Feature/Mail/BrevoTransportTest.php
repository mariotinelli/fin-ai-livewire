<?php

declare(strict_types = 1);

use App\Mail\BrevoTransport;
use Brevo\Brevo;
use Brevo\Exceptions\BrevoApiException;
use Brevo\Exceptions\BrevoException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\RawMessage;

/** @return array{BrevoTransport, MockHandler} */
function brevoTransportWithResponse(Response | ConnectException $response): array
{
    $handler = new MockHandler([$response]);
    $client  = new Brevo(apiKey: 'test-api-key', options: [
        'client'     => new Client(['handler' => HandlerStack::create($handler)]),
        'maxRetries' => 0,
    ]);

    return [new BrevoTransport('test-api-key', $client), $handler];
}

it('identifies the transport without exposing credentials', function (): void {
    expect((string) new BrevoTransport('secret'))->toBe('brevo');
});

it('serializes stream message bodies before contacting Brevo', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{"messageId":"stream-body"}'));
    $html                  = fopen('php://temp', 'r+');
    $text                  = fopen('php://temp', 'r+');
    fwrite($html, '<p>Olá, mensagem</p>');
    fwrite($text, 'Olá, mensagem');
    rewind($html);
    rewind($text);

    try {
        $email = new Email()->from('sender@example.test')->to('recipient@example.test')->subject('Teste')->html($html)->text($text);
        $transport->send($email);
        $payload = json_decode((string) $handler->getLastRequest()->getBody(), true, flags: JSON_THROW_ON_ERROR);

        expect($payload['htmlContent'])->toBe('<p>Olá, mensagem</p>');
        expect($payload['textContent'])->toBe('Olá, mensagem');
    } finally {
        fclose($html);
        fclose($text);
    }
});

it('preserves sender recipients reply-to subject and both bodies in the API request', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{"messageId":"<test@brevo>"}'));
    $email                 = new Email()
        ->from(new Address('sender@example.com', 'Remetente'))
        ->to(new Address('to@example.com', 'Destino'), 'other@example.com')
        ->cc(new Address('cc@example.com', 'Cópia'), 'other-cc@example.com')
        ->bcc(new Address('bcc@example.com', 'Oculto'), 'other-bcc@example.com')
        ->replyTo(new Address('reply@example.com', 'Respostas'))
        ->subject('Relatório')->html('<p>Olá</p>')->text('Olá');

    $transport->send($email);

    $request = $handler->getLastRequest();
    expect($request->getMethod())->toBe('POST');
    expect((string) $request->getUri())->toBe('https://api.brevo.com/v3/smtp/email');
    expect($request->getHeaderLine('api-key'))->toBe('test-api-key');
    expect(json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR))->toEqual([
        'sender'      => ['name' => 'Remetente', 'email' => 'sender@example.com'],
        'to'          => [['email' => 'to@example.com', 'name' => 'Destino'], ['email' => 'other@example.com']],
        'cc'          => [['email' => 'cc@example.com', 'name' => 'Cópia'], ['email' => 'other-cc@example.com']],
        'bcc'         => [['email' => 'bcc@example.com', 'name' => 'Oculto'], ['email' => 'other-bcc@example.com']],
        'replyTo'     => ['email' => 'reply@example.com', 'name' => 'Respostas'],
        'subject'     => 'Relatório',
        'htmlContent' => '<p>Olá</p>',
        'textContent' => 'Olá',
    ]);
});

it('omits absent optional fields and supports unnamed addresses', function (string $body): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $email                 = new Email()->from('sender@example.com')->to('to@example.com')->replyTo('reply@example.com')->subject('Subject');
    $email->$body('Content');

    $transport->send($email);

    expect(json_decode((string) $handler->getLastRequest()->getBody(), true, flags: JSON_THROW_ON_ERROR))->toEqual([
        'sender'          => ['email' => 'sender@example.com'],
        'to'              => [['email' => 'to@example.com']],
        'replyTo'         => ['email' => 'reply@example.com'],
        'subject'         => 'Subject',
        $body . 'Content' => 'Content',
    ]);
})->with(['text', 'html']);

it('transfers multiple binary string stream and file attachments without changing bytes or names', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $stream                = fopen('php://temp', 'w+b');
    $file                  = tmpfile();
    fwrite($stream, "\x00\xffstream");
    fwrite($file, "\x00\xfffile");
    $path = stream_get_meta_data($file)['uri'];

    try {
        $email = new Email()->from('sender@example.com')->to('to@example.com')->text('Body')
            ->attach("\x00\xffstring", 'relatório.pdf', 'application/pdf')
            ->attach($stream, 'stream.txt')
            ->attachFromPath($path, 'file.txt')
            ->attach('', 'empty.txt');

        $transport->send($email);

        $payload = json_decode((string) $handler->getLastRequest()->getBody(), true, flags: JSON_THROW_ON_ERROR);
        expect($payload['attachment'])->toBe([
            ['content' => 'AP9zdHJpbmc=', 'name' => 'relatório.pdf'],
            ['content' => 'AP9zdHJlYW0=', 'name' => 'stream.txt'],
            ['content' => 'AP9maWxl', 'name' => 'file.txt'],
            ['content' => '', 'name' => 'empty.txt'],
        ]);
    } finally {
        fclose($stream);
        fclose($file);
    }
});

it('rejects unsupported attachments before contacting the provider', function (DataPart $attachment, string $error): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $email                 = new Email()->from('sender@example.com')->to('to@example.com')->text('Body')->addPart($attachment);

    expect(fn (): ?\Symfony\Component\Mailer\SentMessage => $transport->send($email))->toThrow(TransportException::class, $error);
    expect($handler->getLastRequest())->toBeNull();
})->with([
    'inline'     => [fn (): DataPart => new DataPart('image', 'image.png')->asInline(), 'inline/CID'],
    'cid'        => [fn (): DataPart => new DataPart('image', 'image.png')->setContentId('image@example.com'), 'inline/CID'],
    'unnamed'    => [fn (): DataPart => new DataPart('data'), 'possuir nome'],
    'blank name' => [fn (): DataPart => new DataPart('data', ' '), 'possuir nome'],
]);

it('fails without sending when an attachment file disappears before delivery', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $file                  = tmpfile();
    $path                  = stream_get_meta_data($file)['uri'];
    $email                 = new Email()->from('sender@example.com')->to('to@example.com')->text('Body')
        ->attachFromPath($path, 'file.txt');
    fclose($file);

    expect(fn (): ?\Symfony\Component\Mailer\SentMessage => $transport->send($email))->toThrow(InvalidArgumentException::class);
    expect($handler->getLastRequest())->toBeNull();
});

it('propagates provider failures to the caller for queue failure handling', function (int $status): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response($status, [], '{"message":"Provider rejected email"}'));
    $email                 = new Email()->from('sender@example.com')->to('to@example.com')->text('Body');

    try {
        $transport->send($email);
        test()->fail('Expected provider failure.');
    } catch (BrevoApiException $brevoApiException) {
        expect($brevoApiException->getCode())->toBe($status);
        expect($brevoApiException->getBody())->toBe('{"message":"Provider rejected email"}');
    }

    expect($handler->count())->toBe(0);
})->with([400, 401, 429, 500]);

it('propagates connection failures without reporting success', function (): void {
    $failure               = new ConnectException('Connection failed', new Request('POST', 'https://api.brevo.com/v3/smtp/email'));
    [$transport, $handler] = brevoTransportWithResponse($failure);

    expect(fn (): ?\Symfony\Component\Mailer\SentMessage => $transport->send(new Email()->from('sender@example.com')->to('to@example.com')->text('Body')))
        ->toThrow(BrevoException::class, 'Connection failed');
    expect($handler->count())->toBe(0);
});

it('rejects raw messages before contacting the provider', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $envelope              = new Envelope(new Address('sender@example.com'), [new Address('to@example.com')]);

    expect(fn (): ?\Symfony\Component\Mailer\SentMessage => $transport->send(new RawMessage('raw'), $envelope))->toThrow(TransportException::class, 'inválida');
    expect($handler->getLastRequest())->toBeNull();
});

it('converts a Symfony MIME message and preserves its attachments', function (): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $email                 = new Email()->from('sender@example.com')->to('to@example.com')->text('Body')->attach('data', 'file.txt');

    $transport->send(new Message($email->getHeaders(), $email->getBody()));

    $payload = json_decode((string) $handler->getLastRequest()->getBody(), true, flags: JSON_THROW_ON_ERROR);
    expect($payload['textContent'])->toBe('Body');
    expect($payload['attachment'])->toBe([['content' => 'ZGF0YQ==', 'name' => 'file.txt']]);
});

it('rejects address lists that the provider cannot preserve', function (Email $email, string $error): void {
    [$transport, $handler] = brevoTransportWithResponse(new Response(201, [], '{}'));
    $email->to('to@example.com')->text('Body');

    expect(fn (): ?\Symfony\Component\Mailer\SentMessage => $transport->send($email))->toThrow(TransportException::class, $error);
    expect($handler->getLastRequest())->toBeNull();
})->with([
    'no From'           => [fn (): Email => new Email()->sender('sender@example.com'), 'exatamente um endereço From'],
    'multiple From'     => [fn (): Email => new Email()->from('first@example.com', 'second@example.com')->sender('sender@example.com'), 'exatamente um endereço From'],
    'multiple Reply-To' => [fn (): Email => new Email()->from('sender@example.com')->replyTo('first@example.com', 'second@example.com'), 'apenas um endereço Reply-To'],
]);
