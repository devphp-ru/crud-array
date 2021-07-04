<?php
declare(strict_types=1);

namespace App\Post;

use App\Post\Domain\Body;
use App\Post\Domain\Post;
use App\Post\Domain\PostId;
use App\Post\Domain\PostStatus;
use PHPUnit\Framework\TestCase;

class PostServiceTest extends TestCase
{
    private PostService $postService;
    private array $data;

    protected function setUp(): void
    {
        $this->postService = new PostService(new PostRepository());
    }

    public function testCanGenerateId(): void
    {
        $id = 1;
        $this->assertEquals($id, $this->postService->generateId()->id());
    }

    public function testExceptionNoPost()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Пост с ID (11) не найден.');

        $id = 11;
        $this->postService->findById(PostId::fromInt($id));
    }

    public function testCreatePostDraft()
    {
        $title = 'title 1';
        $text = 'text 1';
        $body = Body::fromBody($title, $text);
        $post = Post::draft($body);
        $postId = $this->postService->generateId();
        $post->setId($postId);
        $this->postService->createPost($post);

        $this->postService->findById($postId);

        $this->assertEquals($postId, $this->postService->findbyId($postId)->getId());
        $this->assertEquals(PostStatus::STATUS_DRAFT, $post->getPostStatus()->name());
    }

    /**
     * @dataProvider  providerTestPost
     */
    public function testUpdatePost()
    {
        $row['id'] = '1';
        $row['title'] = 'new title';
        $row['text'] = 'new text';
        $row['status_id'] = '2';

        $post = Post::write($row);
        $this->postService->updatePost($post);

        $postId = PostId::fromInt((int)$row['id']);
        $onePost = $this->postService->findById($postId);

        $this->assertEquals($row['id'], $onePost->getId()->id());
        $this->assertEquals($row['title'], $onePost->getBody()->title());
        $this->assertEquals($row['text'], $onePost->getBody()->text());
        $this->assertEquals(PostStatus::STATUS_PUBLISHED, $onePost->getPostStatus()->name());
    }

    /**
     * @dataProvider  providerTestPost
     */
    public function testDeletePost()
    {
        $id = 1;
        $this->assertTrue($this->postService->deletePost($id));

        $this->expectException(\OutOfBoundsException::class);
        $this->expectExceptionMessage('Пост с ID (1) не найден.');

        $this->postService->findById(PostId::fromInt($id));
    }

    public function providerTestPost()
    {
        $this->data = [
            'id' => '1',
            'title' => 'title 1',
            'text' => 'text 1',
            'status_id' => '1'
        ];
    }
}
