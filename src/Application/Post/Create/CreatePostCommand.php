<?php

namespace App\Application\Post\Create;


class CreatePostCommand
{
    private string $title;
    private string $body;
    private int $authorId;

    public function __construct(string $title, string $body, int $authorId)
    {
        $this->title = $title;
        $this->body = $body;
        $this->authorId = $authorId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}
