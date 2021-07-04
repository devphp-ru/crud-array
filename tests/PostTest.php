<?php
declare(strict_types=1);

namespace App\Post\Domain;


use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testPostDraft()
    {
        $title = 'Название';
        $text = 'текст';
        $body = Body::fromBody($title, $text);
        $post = Post::draft($body);

        $this->assertEquals($title, $post->getBody()->title());
        $this->assertEquals($text, $post->getBody()->text());
        $this->assertEquals(PostStatus::STATUS_DRAFT, $post->getPostStatus()->name());
    }

    public function testPostWrite()
    {
        $row['id'] = '1';
        $row['title'] = 'Название 1';
        $row['text'] = 'Текст 1';
        $row['status_id'] = '1';

        $post = Post::write($row);

        $this->assertEquals($row['id'], $post->getId()->id());
        $this->assertEquals($row['title'], $post->getBody()->title());
        $this->assertEquals($row['text'], $post->getBody()->text());
        $this->assertEquals($row['status_id'], $post->getPostStatus()->statusId());
        $this->assertEquals(PostStatus::STATUS_DRAFT, $post->getPostStatus()->name());
    }
}
