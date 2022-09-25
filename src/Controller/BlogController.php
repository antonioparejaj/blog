<?php

namespace App\Controller;

use App\Application\Post\GetAllPostsUseCase;
use App\Application\Post\GetPostUseCase;
use App\Domain\Entity\Author;
use App\Domain\Entity\Post;
use App\Infrastructure\Post\PostJsonplaceholderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class BlogController extends AbstractController
{

    private GetPostUseCase $getPostUseCase;
    private GetAllPostsUseCase $getAllPostUseCase;

    public function __construct()
    {
        $this->getPostUseCase = new GetPostUseCase(new PostJsonplaceholderRepository());
        $this->getAllPostUseCase = new GetAllPostsUseCase(new PostJsonplaceholderRepository());
    }

    #[Route('/posts', name: 'posts')]
    public function index(): Response
    {
        /*$json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $postArray = [];
        foreach(json_decode($json) as $postElement)
        {
            $post = new Post($postElement->id, $postElement->title, $postElement->body, new Author(1,'alex','aaa','678','aaaa'));
            $postArray[] = $post;
        }
        return $this->render('blog/index.html.twig', ['posts' => $postArray]);*/
        $getAllPostsResponse = $this->getAllPostUseCase->execute();

        return $this->render('blog/index.html.twig', ['posts' => $getAllPostsResponse->getPosts()]);
    }

    #[Route('/posts/{postId}', name: 'post', methods:['GET', 'HEAD'])]
    public function getPostById(int $postId): Response
    {
        $getPostResponse = $this->getPostUseCase->execute($postId);
        return $this->render('post/post.html.twig', ['post' => $getPostResponse->getPost()]);
    }
}
