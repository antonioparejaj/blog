<?php

namespace App\Application\Post;

use App\Domain\Entity\Post;

class GetAllPostsResponse
{
    private array $posts;

    /**
     * @param Post $post
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return Post
     */
    public function getPosts(): array
    {
        return $this->posts;
    }
}
