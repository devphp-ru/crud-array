<?php
declare(strict_types=1);

namespace App\Post;

interface RepositoryInterface
{
    /**
     * генерирует ID ключ для массива, как бы ключ из бд ID
     * @return int
     */
    public function generateId(): int;

    /**
     * добавляет новую запись в массив, как бы сохранение в бд
     * @param array $post
     * @return int|null
     */
    public function insert(array $post): ?int;

    /**
     * редактирование данных, массив, или как в бд
     * @param array $post
     * @return bool
     */
    public function update(array $post): bool;

    /**
     * удаляет запись по ID в массиве
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
