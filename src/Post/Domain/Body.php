<?php
declare(strict_types=1);

namespace App\Post\Domain;

class Body
{
    private const MIN_LENGTH = 5;
    private const MAX_LENGTH = 200;

    private string $title;
    private string $text;

    /**
     * @param string $title
     * @param string $text
     * @return Body
     */
    public static function fromBody(string $title, string $text): Body
    {
        self::assertNotEmpty($title, 'Название');
        self::assertFirstLength($title, 'Название');
        self::assertNotEmpty($text, 'Текст');
        return new self($title, $text);
    }

    /**
     * Body constructor.
     * @param string $title
     * @param string $text
     */
    private function __construct(string $title, string $text)
    {
        $this->setTitle($title);
        $this->setText($text);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    private function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    private function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $value
     * @param string $name
     */
    private static function assertNotEmpty(string $value, string $name): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException(sprintf(
                "Заполните поле (%s)", $name
            ));
        }
    }

    /**
     * @param string $value
     * @param string $name
     */
    private static function assertFirstLength(string $value, string $name): void
    {
        if (\mb_strlen($value) < self::MIN_LENGTH) {
            throw new \DomainException(sprintf(
                "(%s) слишком короткое", $name
            ));
        }

        if (\mb_strlen($value) > self::MAX_LENGTH) {
            throw new \DomainException(sprintf(
                "(%s) сликом длинное", $name
            ));
        }
    }
}
