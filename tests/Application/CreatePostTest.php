<?php

namespace App\Tests\Application\CreatePost;

use App\Application\Post\Create\CreatePostCommand;
use App\Application\Post\Create\CreatePostResponse;
use App\Application\Post\Create\CreatePostUseCase;
use App\Domain\Entity\Author;
use App\Infrastructure\Post\PostJsonplaceholderRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Domain\Shared\IdGenerator;
use App\Infrastructure\Author\AuthorJsonplaceholderRepository;

class CreatePostTest extends KernelTestCase
{
    /**
     * @return void
     * @throws Exception
     *
     */
    public function testCreatePost()
    {
        $idGenerator = new IdGenerator;
        $postRepository = new PostJsonplaceholderRepository();
        $authorRepository = new AuthorJsonplaceholderRepository();

        $createPostUseCase = new CreatePostUseCase($postRepository, $authorRepository, $idGenerator);

        $createPostCommand = new CreatePostCommand(
            'Post title for test',
            'Post body form test',
            1
        );

        $postResponse = $createPostUseCase->execute($createPostCommand);

        $this->assertInstanceOf(CreatePostResponse::class, $postResponse);
        $this->assertEquals($postResponse->getPost(), $postRepository->findOneById($postResponse->getPost()->getId()));
    }

    /**
     * @param array<string, string> $postData
     *
     * @return void
     * @throws Exception
     */
    public function testCreatePostInvalidData(array $postData)
    {
        $this->expectException(Exception::class);

        $idGenerator = new IdGenerator;
        $postRepository = new PostJsonplaceholderRepository();
        $authorRepository = new AuthorJsonplaceholderRepository();

        $createPostUseCase = new CreatePostUseCase($postRepository, $authorRepository, $idGenerator);

        $createPostCommand = new CreatePostCommand(
            $postData['title'] ?? '',
            $postData['content'] ?? '',
            $postData['authorId'] ?? null
        );

        $createPostUseCase->execute($createPostCommand);
    }
}