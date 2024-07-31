<?php


namespace Source\Events;

use Core\Event\EventInterface;

class LinkNavigationEvent implements EventInterface
{
    private string $name;
    private array $payload;

    public function __construct()
    {
        $this->name = 'link.navigation';
        $this->payload = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
