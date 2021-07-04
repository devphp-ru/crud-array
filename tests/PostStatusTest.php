<?php
declare(strict_types=1);

namespace App\Post\Domain;


use PHPUnit\Framework\TestCase;

class PostStatusTest extends TestCase
{
    public function testStatusIsInt()
    {
        $status = 1;
        $postStatus = PostStatus::fromId($status);
        $this->assertEquals($status, $postStatus->statusId());
    }

    public function testStatusIsString()
    {
        $status = 'черновик';
        $postStatus = PostStatus::fromName($status);
        $this->assertEquals($status, $postStatus->name());
    }
}
