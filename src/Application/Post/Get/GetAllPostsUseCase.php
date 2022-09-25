<?php

namespace App\Application\Post\Get;

use PostRepository;

class GetAllPostsUseCase
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(): GetAllPostsResponse
    {
        $posts = $this->postRepository->findAll();
        return new GetAllPostsResponse($posts);
    }
}