<?php
declare(strict_types=1);

namespace App\Post\Domain;

class PostStatus
{
    const STATUS_DRAFT_ID = 1;
    const STATUS_PUBLISHED_ID = 2;

    const STATUS_DRAFT = 'черновик';
    const STATUS_PUBLISHED = 'опубликовано';

    private int $id;
    private string $name;

    private static array $statusList = [
        self::STATUS_DRAFT_ID => self::STATUS_DRAFT,
        self::STATUS_PUBLISHED_ID => self::STATUS_PUBLISHED,
    ];

    /**
     * @param int $statusId
     * @return PostStatus
     */
    public static function fromId(int $statusId): PostStatus
    {
        self::assertValidId($statusId);
        return new self($statusId, self::$statusList[$statusId]);
    }

    /**
     * @param string $name
     * @return PostStatus
     */
    public static function fromName(string $name): PostStatus
    {
        self::assertValidName($name);
        $statusId = array_search($name, self::$statusList);

        if (false === $statusId) {
            throw new \InvalidArgumentException(sprintf(
                "Неверный статус (%s)", $name
            ));
        }
        return new self($statusId, $name);
    }

    /**
     * PostStatus constructor.
     * @param int $statusId
     * @param string $name
     */
    private function __construct(int $statusId, string $name)
    {
        $this->setStatusId($statusId);
        $this->setName($name);
    }

    /**
     * @return int
     */
    public function statusId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    private function setStatusId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $statusId
     */
    private static function assertValidId(int $statusId): void
    {
        if (!in_array($statusId, array_keys(self::$statusList), true)) {
            throw new \InvalidArgumentException(sprintf(
                "Неверный ID статуса (%d)", $statusId
            ));
        }
    }

    /**
     * @param string $name
     */
    private static function assertValidName(string $name): void
    {
        if (!in_array($name, self::$statusList, true)) {
            throw new \InvalidArgumentException(sprintf(
                "Неверное имя статуса (%s)", $name
            ));
        }
    }
}
