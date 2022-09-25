<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(): JsonResponse
    {
        $json = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        return $this->json(json_decode($json));
    }
}
