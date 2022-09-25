<?php

use App\Domain\Entity\Post;
use Doctrine\Common\Collections\Collection;

interface PostRepository
{
    public function save(Post $post): void;
    public function findAll(): Collection;
    public function findOneById(int $id): ?Post;
}