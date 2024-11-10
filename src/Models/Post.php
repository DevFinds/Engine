<?php


namespace Source\Models;
class Post
{
	public function __construct(

        private int $id,
        private string $title,
        private string $description,
        private string $content,
        private string $author,
        private string $date,
        private string $image
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
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