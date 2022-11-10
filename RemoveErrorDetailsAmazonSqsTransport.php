<?php

declare(strict_types=1);

namespace App\Messenger\Transport;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\ErrorDetailsStamp;
use Symfony\Component\Messenger\Transport\TransportInterface;

final class RemoveErrorDetailsAmazonSqsTransport implements TransportInterface
{
    public function __construct(private TransportInterface $inner)
    {
    }

    /**
     * @inheritDoc
     */
    public function get(): iterable
    {
        return $this->inner->get();
    }

    /**
     * @inheritDoc
     */
    public function ack(Envelope $envelope): void
    {
        $this->inner->ack($envelope);
    }

    /**
     * @inheritDoc
     */
    public function reject(Envelope $envelope): void
    {
        $this->inner->reject($envelope);
    }

    /**
     * @inheritDoc
     */
    public function send(Envelope $envelope): Envelope
    {
        return $this->inner->send($envelope->withoutAll(ErrorDetailsStamp::class));
    }
}
