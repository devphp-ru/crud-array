<?php
declare(strict_types=1);

namespace App\Post\Domain;

class Post
{
    private PostId $id;
    private Body $body;
    private PostStatus $postStatus;

    /**
     * @param Body $body
     * @return Post
     */
    public static function draft(Body $body): Post
    {
        return new self(
            $body,
            PostStatus::fromName(PostStatus::STATUS_DRAFT)
        );
    }

    /**
     * @param array $row
     * @return Post
     */
    public static function write(array $row): Post
    {
        $post = new self(
            Body::fromBody($row['title'], $row['text']),
            PostStatus::fromId((int)$row['status_id'])
        );
        $post->setId(PostId::fromInt((int)$row['id']));
        return $post;
    }

    /**
     * Post constructor.
     * @param Body $body
     * @param PostStatus $postStatus
     */
    private function __construct(Body $body, PostStatus $postStatus)
    {
        $this->setBody($body);
        $this->setPostStatus($postStatus);
    }

    /**
     * @return PostId
     */
    public function getId(): PostId
    {
        return $this->id;
    }

    /**
     * @param PostId $id
     */
    public function setId(PostId $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }

    /**
     * @param Body $body
     */
    private function setBody(Body $body): void
    {
        $this->body = $body;
    }

    /**
     * @return PostStatus
     */
    public function getPostStatus(): PostStatus
    {
        return $this->postStatus;
    }

    /**
     * @param PostStatus $postStatus
     */
    private function setPostStatus(PostStatus $postStatus): void
    {
        $this->postStatus = $postStatus;
    }
}
