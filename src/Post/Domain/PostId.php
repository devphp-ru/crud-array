<?php
declare(strict_types=1);

namespace App\Post\Domain;

class PostId
{
    private int $id;

    /**
     * @param int $id
     * @return PostId
     */
    public static function fromInt(int $id): PostId
    {
        self::assertValidInt($id);
        return new self($id);
    }

    /**
     * PostId constructor.
     * @param int $id
     */
    private function __construct(int $id)
    {
        $this->setId($id);
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    private function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $id
     */
    private static function assertValidInt(int $id)
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException(sprintf(
                "Недопустимое значение ID (%d)", $id
            ));
        }
    }
}
