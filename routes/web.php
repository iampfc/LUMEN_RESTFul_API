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


$app->get('/user/getByID/{id}', 'UserController@getByID');
$app->get('/user/getList', 'UserController@getList');
$app->post('/user/register', 'UserController@register');
$app->post('/user/login', 'UserController@login');
$app->post('/user/test', 'UserController@test');



$app->post('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    echo '$postId:' . $postId .'<br>';
    echo '$commentId:' . urldecode($commentId) .'<br>';
});


