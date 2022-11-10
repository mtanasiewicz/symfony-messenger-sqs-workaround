<?php

declare(strict_types=1);

namespace App\Messenger\Transport;

use Symfony\Component\Messenger\Bridge\AmazonSqs\Transport\AmazonSqsTransportFactory;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

final class AmazonSqsTransportFactoryDecorator implements TransportFactoryInterface
{
    public function __construct(private AmazonSqsTransportFactory $inner)
    {
    }

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        $sqsTransport = $this->inner->createTransport($dsn, $options, $serializer);

        return new RemoveErrorDetailsAmazonSqsTransport($sqsTransport);
    }

    public function supports(string $dsn, array $options): bool
    {
        return $this->inner->supports($dsn, $options);
    }
}