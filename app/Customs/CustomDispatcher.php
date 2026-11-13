<?php

declare(strict_types = 1);

namespace App\Customs;

use App\Support\QueueNames;
use Illuminate\Bus\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Queue\Attributes\Delay;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Illuminate\Queue\Attributes\ReadsQueueAttributes;
use InvalidArgumentException;
use UnitEnum;

class CustomDispatcher extends Dispatcher
{
    use ReadsQueueAttributes;

    private const string DELAY_ATTRIBUTE_CLASS = Delay::class;

    /** @var array<string> */
    private const array FORBIDDEN_QUEUES = ['default'];

    public function __construct(Container $app, Dispatcher $dispatcher)
    {
        parent::__construct($app, $dispatcher->queueResolver);
        $this->handlers = $dispatcher->handlers;
        $this->pipes    = $dispatcher->pipes;
    }

    public function dispatchToQueue(mixed $command): mixed
    {
        if (!is_object($command)) {
            throw new InvalidArgumentException('A fila não pode estar vazia. Você deve especificar uma fila nomeada.');
        }

        $queue = $this->resolveQueueName($command);

        if ($queue === null) {
            throw new InvalidArgumentException('A fila não pode estar vazia. Você deve especificar uma fila nomeada.');
        }

        if (!property_exists($command, 'queue')) {
            throw new InvalidArgumentException('O job deve declarar a propriedade queue ou usar Queueable.');
        }

        $command->queue = $queue;

        if (in_array($queue, self::FORBIDDEN_QUEUES, true)) {
            throw new InvalidArgumentException("A fila '{$queue}' não é permitida. Você deve especificar uma fila nomeada para todos os jobs.");
        }

        $command->queue = QueueNames::resolve($queue);

        return parent::dispatchToQueue($command);
    }

    protected function pushCommandToQueue(mixed $queue, mixed $command): mixed
    {
        if (!is_object($command)) {
            throw new InvalidArgumentException('Job ou conexão de fila inválidos.');
        }

        $queueName = $this->resolveQueueName($command);

        if ($queueName === null) {
            throw new InvalidArgumentException('A fila não pode estar vazia.');
        }

        $delay = $this->getAttributeValue($command, self::DELAY_ATTRIBUTE_CLASS, 'delay');

        if (isset($delay)) {
            if (!is_int($delay) && !$delay instanceof \DateInterval && !$delay instanceof \DateTimeInterface) {
                throw new InvalidArgumentException('Atraso de fila inválido.');
            }

            return $queue->later($delay, $command, queue: $queueName);
        }

        return $queue->push($command, queue: $queueName);
    }

    private function resolveQueueName(mixed $command): ?string
    {
        if (!is_object($command)) {
            return null;
        }

        $queue = $command->queue ?? null;

        if ($queue === null || $queue === '') {
            $queue = $this->getAttributeValue($command, QueueAttribute::class, 'queue');
        }

        if ($queue instanceof UnitEnum) {
            return $queue instanceof \BackedEnum ? (string) $queue->value : $queue->name;
        }

        if (!is_string($queue)) {
            return null;
        }

        $normalizedQueue = trim($queue);

        return $normalizedQueue === '' ? null : $normalizedQueue;
    }
}
