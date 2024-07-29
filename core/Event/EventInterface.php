<?php


namespace Core\Event;

interface EventInterface
{
    public function getName(): string;
    public function getPayload(): array;
}
