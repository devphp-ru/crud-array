<?php
declare(strict_types=1);

namespace App\Post\Domain;

use PHPUnit\Framework\TestCase;

class BodyTest extends TestCase
{
    public function testFromBody()
    {
        $title = 'Название';
        $text = 'текст';
        $body = Body::fromBody($title, $text);
        $this->assertEquals($title, $body->title());
        $this->assertEquals($text, $body->text());
    }
    
    public function testTheTitleIsTooShort()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("(Название) слишком короткое");
        $title = 'Наз';
        $text = 'текст';
        Body::fromBody($title, $text);
    }

    public function testTitleIsTooLong()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("(Название) сликом длинное");
        $title = 'Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название Название';
        $text = 'текст';
        Body::fromBody($title, $text);
    }
}