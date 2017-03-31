<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->put('/hello', function () use ($app) {
    return 'Hello World';
});

$app->get('/user/{id}', 'UserController@show');

$app->get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    echo '$postId:' . $postId .'<br>';
    echo '$commentId:' . urldecode($commentId) .'<br>';
});


