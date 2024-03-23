<?php

namespace App\Infrastructure\Event;

use App\Domain\Shared\Event\EventDispatcherInterface;
use App\Domain\Shared\Event\EventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyDispatcher;

readonly class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(private SymfonyDispatcher $dispatcher)
    {
    }

    public function dispatch(EventInterface $event, string $eventName): void
    {
        $this->dispatcher->dispatch($event, $eventName);
    }
}
