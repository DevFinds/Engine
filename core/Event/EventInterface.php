<?php

namespace Core\Event;

interface EventInterface
{
    public function getName(): string;  // Возвращает имя события
    public function getPayload(): array; // Возвращает полезные данные события
}
