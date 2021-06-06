<?php

namespace App\Shared\Infrastructure\Messenger\Middleware;

use App\Shared\Domain\Bus\Event\DomainEventPublisher;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class DispatchEvents implements MiddlewareInterface
{
    private $eventBus;
    private $publisher;

    public function __construct(MessageBusInterface $eventBus, DomainEventPublisher $publisher)
    {
        $this->eventBus = $eventBus;
        $this->publisher = $publisher;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        foreach ($this->publisher->release() as $event) {
            $this->eventBus->dispatch($event);
        }

        return $envelope;
    }
}