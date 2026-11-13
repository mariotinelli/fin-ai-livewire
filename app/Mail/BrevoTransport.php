<?php

declare(strict_types = 1);

namespace App\Mail;

use Brevo\Brevo;
use Brevo\TransactionalEmails\Requests\SendTransacEmailRequest;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestAttachmentItem;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestBccItem;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestCcItem;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestReplyTo;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestSender;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestToItem;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\MessageConverter;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\TextPart;

class BrevoTransport extends AbstractTransport
{
    private readonly Brevo $client;

    public function __construct(
        string $apiKey,
        ?Brevo $client = null,
    ) {
        parent::__construct();
        $this->client = $client ?? new Brevo($apiKey);
    }

    protected function doSend(SentMessage $message): void
    {
        $originalMessage = $message->getOriginalMessage();

        if (!$originalMessage instanceof Message) {
            throw new TransportException('A mensagem enviada para o transporte Brevo é inválida.');
        }

        $email = MessageConverter::toEmail($originalMessage);

        $request = new SendTransacEmailRequest([
            'sender'      => $this->buildSender($email->getFrom()),
            'to'          => $this->mapRecipients($email->getTo(), SendTransacEmailRequestToItem::class),
            'cc'          => $this->mapRecipients($email->getCc(), SendTransacEmailRequestCcItem::class),
            'bcc'         => $this->mapRecipients($email->getBcc(), SendTransacEmailRequestBccItem::class),
            'replyTo'     => $this->buildReplyTo($email->getReplyTo()),
            'subject'     => $email->getSubject(),
            'htmlContent' => $this->bodyString($email->getHtmlBody()),
            'textContent' => $this->bodyString($email->getTextBody()),
            'attachment'  => $this->mapAttachments($email->getAttachments()),
        ]);

        $this->client->transactionalEmails->sendTransacEmail($request);
    }

    public function __toString(): string
    {
        return 'brevo';
    }

    /**
     * Named attachments from strings, streams and files are sent as base64.
     * Brevo infers MIME types from filenames; its attachment API cannot preserve CID/disposition.
     *
     * @param array<DataPart> $attachments
     * @return array<SendTransacEmailRequestAttachmentItem>|null
     */
    private function mapAttachments(array $attachments): ?array
    {
        if ($attachments === []) {
            return null;
        }

        return array_map(static function (DataPart $attachment): SendTransacEmailRequestAttachmentItem {
            if ($attachment->getDisposition() === 'inline' || $attachment->hasContentId()) {
                throw new TransportException('O transporte Brevo não suporta anexos inline/CID.');
            }

            $name = $attachment->getFilename();

            if ($name === null || trim($name) === '') {
                throw new TransportException('Os anexos do transporte Brevo devem possuir nome.');
            }

            return new SendTransacEmailRequestAttachmentItem([
                'name'    => $name,
                'content' => base64_encode($attachment->getBody()),
            ]);
        }, $attachments);
    }

    /**
     * @param array<Address> $addresses
     */
    private function buildSender(array $addresses): SendTransacEmailRequestSender
    {
        if (count($addresses) !== 1) {
            throw new TransportException('O transporte Brevo exige exatamente um endereço From.');
        }

        $address = $addresses[0];

        return new SendTransacEmailRequestSender([
            'email' => $address->getAddress(),
            'name'  => $address->getName() ?: null,
        ]);
    }

    /**
     * @template TRecipient of SendTransacEmailRequestToItem|SendTransacEmailRequestCcItem|SendTransacEmailRequestBccItem
     * @param array<Address> $addresses
     * @param class-string<TRecipient> $recipientType
     *
     * @return list<TRecipient>|null
     */
    private function mapRecipients(array $addresses, string $recipientType): ?array
    {
        if ($addresses === []) {
            return null;
        }

        $recipients = [];

        foreach ($addresses as $address) {
            $recipients[] = new $recipientType([
                'email' => $address->getAddress(),
                'name'  => $address->getName() ?: null,
            ]);
        }

        return $recipients;
    }

    /**
     * @param array<Address> $addresses
     */
    private function buildReplyTo(array $addresses): ?SendTransacEmailRequestReplyTo
    {
        if ($addresses === []) {
            return null;
        }

        if (count($addresses) > 1) {
            throw new TransportException('O transporte Brevo suporta apenas um endereço Reply-To.');
        }

        $address = $addresses[0];

        return new SendTransacEmailRequestReplyTo([
            'email' => $address->getAddress(),
            'name'  => $address->getName() ?: null,
        ]);
    }

    /** @param resource|string|null $body */
    private function bodyString(mixed $body): ?string
    {
        return $body === null ? null : new TextPart($body)->getBody();
    }
}
