<?php

use App\Domain\Entity\Post;

interface PostRepository
{
    public function save(Post $post): void;
    public function findAll(): array;
    public function findOneById(int $id): ?Post;
}