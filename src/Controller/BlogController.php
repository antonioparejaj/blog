<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(): Response
    {
        /*$json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        return $this->json(json_decode($json));*/

        $posts = $this->getPostsQH->execute();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
