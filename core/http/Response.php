<?php

namespace Core\Http;

use Core\http\Redirect;

class Response
{
    private string $content;
    private int $status;
    private array $headers;

    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    // Установить содержимое ответа
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    // Получить содержимое ответа
    public function getContent(): string
    {
        return $this->content;
    }

    // Установить код состояния HTTP
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    // Получить код состояния HTTP
    public function getStatus(): int
    {
        return $this->status;
    }

    // Установить заголовки
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    // Получить заголовки
    public function getHeaders(): array
    {
        return $this->headers;
    }

    // Отправить заголовки
    private function sendHeaders(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }

    // Отправить содержимое ответа
    public function send(): void
    {
        $this->sendHeaders();
        echo $this->content;
    }

    public static function redirect(string $uri)
    {
        $redirect = new Redirect();
        $redirect->to($uri);
    }
}
