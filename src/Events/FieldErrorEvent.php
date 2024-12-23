<?php


namespace Source\Events;

use Core\Event\EventInterface;

class FieldErrorEvent implements EventInterface
{
    private string $name;
    private array $payload;

    public function __construct(
        private string $error_type,
        private string $error_title,
        private string $error_message
    ) {
        $this->name = 'error';
        $this->payload = ['error_type' => $this->error_type, 'error_title' => $this->error_title, 'error_message' => $this->error_message];
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
