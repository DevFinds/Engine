<?php


namespace Core\Event;

use Core\Event\EventInterface;
use Core\Event\EventListenerInterface;

class EventManager
{
    private array $listeners = [];

    public function addListener(string $eventName, EventListenerInterface $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(EventInterface $event): void
    {
        $eventName = $event->getName();
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener->handle($event);
            }
        }
    }
}
