<?php

namespace App\Infrastructure\Post;

use App\Domain\Entity\Author;
use App\Domain\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PostRepository;
use App\Infrastructure\Author\AuthorJsonplaceholderRepository;
use AuthorRepository;

class PostJsonplaceholderRepository extends ServiceEntityRepository implements PostRepository
{
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->authorRepository = new AuthorJsonplaceholderRepository();
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function save(Post $post): void
    {
        $this->add($post, true);
    }

    public function findAll(): array
    {
        $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $postArray = [];
        foreach(json_decode($json) as $postElement)
        {
            $post = new Post($postElement->id, $postElement->title, $postElement->body, new Author(1,'alex','aaa','678','aaaa'));
            $postArray[] = $post;
        }
        return $postArray;
    }

    public function findOneById(int $id): ?Post
    {
        $url = "https://jsonplaceholder.typicode.com/posts/".$id;
        $json = json_decode(file_get_contents($url));
        if(empty($json))
        {
            return null;
        }
        return new Post($json->id, $json->title, $json->body, $this->authorRepository->findOneById($json->userId)); //TODO: devolver objeto Post
    }
}
