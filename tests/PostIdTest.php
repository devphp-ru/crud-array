<?php
declare(strict_types=1);

namespace App\Post\Domain;

use PHPUnit\Framework\TestCase;

class PostIdTest extends TestCase
{
    public function testIsInt()
    {
        $id = 1;
        $postId = PostId::fromInt($id);
        $this->assertIsInt($postId->id());
    }

    public function testGetExceptionTheValuesIncorrect()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Недопустимое значение ID (-1)");
        $id = -1;
        PostId::fromInt($id);
    }
}