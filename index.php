<?php
declare(strict_types=1);
error_reporting(-1);

require_once __DIR__ . '/vendor/autoload.php';

function debug($arr)
{
    echo '<pre>'; var_dump($arr); echo '</pre>';
}

$postRepository = new \App\Post\PostRepository();
$postService = new \App\Post\PostService($postRepository);

$title = 'title 1';
$text = 'text 1';
$body = \App\Post\Domain\Body::fromBody($title, $text);
$post = \App\Post\Domain\Post::draft($body);
$postId = $postService->generateId();
$post->setId($postId);
$lastId = $postService->createPost($post);
echo $lastId;//1

$id = 1;
$postId = \App\Post\Domain\PostId::fromInt($id);
debug($postService->findById($postId));

$title = 'title 2';
$text = 'text 2';
$body = \App\Post\Domain\Body::fromBody($title, $text);
$post = \App\Post\Domain\Post::draft($body);
$postId = $postService->generateId();
$post->setId($postId);
$lastId = $postService->createPost($post);
echo $lastId;//1
$id = 2;
$postId = \App\Post\Domain\PostId::fromInt($id);
debug($postService->findById($postId));

$row['id'] = '2';
$row['title'] = 'new title';
$row['text'] = 'new text';
$row['status_id'] = '2';
$post = \App\Post\Domain\Post::write($row);
$postService->updatePost($post);


debug($postService->findAll());

$id = 1;
debug($postService->deletePost($id));

debug($postService->findAll());
