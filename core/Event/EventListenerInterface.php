<?php


namespace Core\Event;
interface EventListenerInterface
{
    public function handle(EventInterface $event): void;
}
