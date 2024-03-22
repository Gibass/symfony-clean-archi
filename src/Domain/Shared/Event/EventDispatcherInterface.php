<?php

namespace App\Domain\Shared\Event;

interface EventDispatcherInterface
{
    public function dispatch(EventInterface $event, string $eventName);
}
