<?php

use App\Domain\Entity\Author;

interface AuthorRepository
{
    public function findOneById(int $id): ?Author;
}