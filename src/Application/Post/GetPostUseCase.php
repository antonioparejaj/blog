<?php

namespace App\Application\Post;

use PostRepository;

class GetPostUseCase
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $postId): GetPostResponse
    {
        $post = $this->postRepository->findOneById($postId);
        return new GetPostResponse($post);
    }
}