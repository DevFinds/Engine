<?php


namespace Source\Models;

class Post
{
    public function __construct(

        private int $id,
        private string $type,
        private string $generated_at,
        private string $generated_by,
        private string $period_start,
        private string $period_end
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function image(): string
    {
        return $this->image;
    }
}
