<?php


namespace Source\Events;

use Core\Event\EventInterface;

class LogActionEvent implements EventInterface
{

    private string $name;
    private array $payload;

    public function __construct(array $payload)
    {
        $this->name = "log.action";
        $this->payload = $payload;
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
