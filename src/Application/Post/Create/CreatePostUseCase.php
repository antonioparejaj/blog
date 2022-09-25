<?php

namespace App\Application\Post\Create;

use App\Domain\Entity\Post;
use App\Domain\Shared\IdGenerator;
use AuthorRepository;
use PostRepository;
use Symfony\Component\Uid\Uuid;
use Exception;

class CreatePostUseCase
{
    private PostRepository $postRepository;
    private AuthorRepository $authorRepository;
    private IdGenerator $idGenerator;

    public function __construct(PostRepository $postRepository, AuthorRepository $authorRepository, IdGenerator $idGenerator)
    {
        $this->postRepository = $postRepository;
        $this->authorRepository = $authorRepository;
        $this->idGenerator = $idGenerator;
    }

    public function execute(CreatePostCommand $command): CreatePostResponse
    {
        $id = (int)$this->generatePostId();
        $author = $this->authorRepository->findOneById($command->getAuthorId());
        if($author == null){
            //$post = new Post($id, $command->getTitle(), $command->getBody(), new Author($command->getAuthorId())); TODO: crear nuevo autor
        } else {
            $post = new Post($id, $command->getTitle(), $command->getBody(), $author);
        }

        try {
            $this->postRepository->save($post);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return new CreatePostResponse($post);
    }

    private function generatePostId(): Uuid
    {
        $maxAttempts = 5;
        $attempts = 0;

        $id = $this->idGenerator->generate();

        while ($attempts < $maxAttempts && !is_null($this->postRepository->findOneById((int)$id))) {

            $id = $this->idGenerator->generate();

            $attempts++;
            if ($attempts >= $maxAttempts) {
                // throw new IdGenerationAttemptsExceeded($maxAttempts);
            }
        }

        return $id;
    }
}