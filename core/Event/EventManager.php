<?php

namespace Core\Event;

use Core\Event\EventInterface;
use Core\Event\EventListenerInterface;

class EventManager
{
    private array $listeners = [];

    // Регистрируем слушателя для определенного события
    public function addListener(string $eventName, EventListenerInterface $listener): void
    {
        error_log('EventManager::addListener called for event: ' . $eventName);
        $this->listeners[$eventName][] = $listener;
    }

    // Убираем слушателя с определенного события
    public function removeListener(string $eventName, EventListenerInterface $listener): void
    {
        if (isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = array_filter($this->listeners[$eventName], function ($existingListener) use ($listener) {
                return $existingListener !== $listener;
            });
        }
    }

    // Получаем список слушателей для определенного события
    public function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }

    // Вбрасываем событие, оповещая всех слушателей
    public function dispatch(EventInterface $event): void
    {
        $eventName = $event->getName();
        error_log('EventManager::dispatch called for event: ' . $eventName);
        foreach ($this->getListeners($eventName) as $listener) {
            $listener->handle($event);
        }
    }
}
