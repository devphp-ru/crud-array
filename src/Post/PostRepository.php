<?php
declare(strict_types=1);

namespace App\Post;

class PostRepository implements RepositoryInterface
{
    private array $data = [];
    private int $lastId = 0;

    /**
     * @inheritDoc
     */
    public function generateId(): int
    {
        $this->lastId++;
        return $this->lastId;
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOne(int $id): array
    {
        if ($this->assertNotEmpty($id)) {
            throw new \OutOfBoundsException(sprintf(
                "Ошибка запроса, ID (%d) ненайден", $id
            ));
        }
        return $this->data[$id];
    }

    /**
     * @return array
     */
    public function findAll(): ?array
    {
        return (count($this->data) > 0) ? $this->data : null;
    }

    /**
     * @inheritDoc
     */
    public function insert(array $post): ?int
    {
        $this->data[$this->lastId] = $post;
        return ($this->data[$this->lastId]) ? $this->lastId : null;
    }

    /**
     * @inheritDoc
     */
    public function update(array $post): bool
    {
        if ($this->assertNotEmpty($post['id'])) {
            throw new \OutOfBoundsException(sprintf(
                "Ошибка редактирования пост (%d).", $post['id']
            ));
        }
        $this->data[$post['id']] = $post;
        return ($this->assertNotEmpty($post['id'])) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if ($this->assertNotEmpty($id)) {
            throw new \OutOfBoundsException(sprintf(
                "Ошибка удаления поста (%d)", $id
            ));
        }
        unset($this->data[$id]);
        return $this->assertNotEmpty($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    private function assertNotEmpty(int $id)
    {
        return empty($this->data[$id]) ? true : false;
    }
}
