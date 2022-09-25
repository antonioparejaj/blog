<?php

namespace App\Controller;

use App\Application\Post\Create\CreatePostCommand;
use App\Application\Post\Create\CreatePostUseCase;
use App\Application\Post\Get\GetAllPostsUseCase;
use App\Application\Post\Get\GetPostUseCase;
use App\Domain\Entity\Author;
use App\Domain\Entity\Post;
use App\Domain\Exception\InvalidPostDataException;
use App\Domain\Shared\IdGenerator;
use App\Infrastructure\Author\AuthorJsonplaceholderRepository;
use App\Infrastructure\Post\PostJsonplaceholderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{

    private GetPostUseCase $getPostUseCase;
    private GetAllPostsUseCase $getAllPostUseCase;
    private CreatePostUseCase $createPostUseCase;

    public function __construct()
    {
        $this->getPostUseCase = new GetPostUseCase(new PostJsonplaceholderRepository());
        $this->getAllPostUseCase = new GetAllPostsUseCase(new PostJsonplaceholderRepository());
        $this->createPostUseCase = new CreatePostUseCase(new PostJsonplaceholderRepository(), new AuthorJsonplaceholderRepository(), new IdGenerator());
    }

    #[Route('/posts', name: 'posts', methods:['GET'])]
    public function index(): Response
    {
        $getAllPostsResponse = $this->getAllPostUseCase->execute();

        return $this->render('blog/index.html.twig', ['posts' => $getAllPostsResponse->getPosts()]);
    }

    #[Route('/posts/{postId}', name: 'post', methods:['GET'])]
    public function getPostById(int $postId): Response
    {
        $getPostResponse = $this->getPostUseCase->execute($postId);
        return $this->render('post/post.html.twig', ['post' => $getPostResponse->getPost()]);
    }

    #[Route('/posts/create', name: 'createPost', methods:['POST'])]
    public function createPost(Request $request)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            /** @var string $title */
            $title = $form->get('title')->getData();

            /** @var string $body */
            $body = $form->get('body')->getData();

            /** @var int $authorId */
            $authorId = $form->get('authorId')->getData();

            $createPostCommand = new CreatePostCommand(
                $title, $body, $authorId
            );

            try {
                $post = $this->createPostUseCase->execute($createPostCommand);
            } catch (InvalidPostDataException $dataException) {
                $this->addFlash('error', $dataException->getMessage());
            }
        }
    }
}
