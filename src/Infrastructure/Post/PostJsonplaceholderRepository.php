<?php

namespace App\Infrastructure;

use App\Domain\Entity\Author;
use App\Domain\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use PostRepository;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostJsonplaceholderRepository extends ServiceEntityRepository implements PostRepository
{
    public function __construct()
    {
        
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

    public function findAll(): Collection
    {
        $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        return $this->json(json_decode($json)); //TODO: devolver objeto Colection Post
    }

    public function findOneById(int $id): ?Post
    {
        $url = "https://jsonplaceholder.typicode.com/posts/".$id;
        $json = json_decode(file_get_contents($url));
        return new Post($json->id, $json->title, $json->body, new Author(1,'alex','aaa','678','aaaa')); //TODO: devolver objeto Post
    }
}
