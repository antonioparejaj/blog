<?php

namespace App\Infrastructure\Author;

use App\Domain\Entity\Author;
use AuthorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AuthorJsonplaceholderRepository extends ServiceEntityRepository implements AuthorRepository
{
    public function __construct()
    {
        
    }

    public function findAll(): array
    {
        $json = file_get_contents('https://jsonplaceholder.typicode.com/users');
        return json_decode($json);
    }

    public function findOneById(int $id): ?Author
    {
        $url = "https://jsonplaceholder.typicode.com/users/".$id;
        $json = json_decode(file_get_contents($url));
        return new Author($json->id,$json->name,$json->email,$json->phone,$json->website);
    }
}
