<?php
declare(strict_types=1);

namespace App\Post;

use App\Post\Domain\Post;
use App\Post\Domain\PostId;

class PostService
{
    private RepositoryInterface $repository;

    /**
     * PostService constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PostId
     */
    public function generateId(): PostId
    {
        return PostId::fromInt($this->repository->generateId());
    }

    /**
     * @param PostId $id
     * @return Post
     */
    public function findById(PostId $id): Post
    {
        try {
            $onePost = $this->repository->findOne($id->id());
        } catch (\OutOfBoundsException $e) {
            throw new \OutOfBoundsException(sprintf(
                "Пост с ID (%d) не найден.", $id->id()
            ));
        }
        return Post::write($onePost);
    }

    /**
     * @return array|null
     */
    public function findAll(): ?array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Post $post
     * @return int|null
     */
    public function createPost(Post $post): ?int
    {
        $lastId = $this->repository->insert([
            'id' => $post->getId()->id(),
            'title' => $post->getBody()->title(),
            'text' => $post->getBody()->text(),
            'status_id' => $post->getPostStatus()->statusId()
        ]);
        return ($lastId) ? $lastId : null;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function updatePost(Post $post): bool
    {
        $result = $this->repository->update([
            'id' => $post->getId()->id(),
            'title' => $post->getBody()->title(),
            'text' => $post->getBody()->text(),
            'status_id' => $post->getPostStatus()->statusId()
        ]);
        return ($result) ? true : false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id): bool
    {
        $result = $this->repository->delete($id);
        return ($result) ? true : false;
    }
}
