<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthAPIController@login')->name('login');
Route::post('password/reset', 'AuthAPIController@sendResetLinkEmail')->name('password.reset');
Route::post('register', 'AuthAPIController@register')->name('register');

Route::group(['middleware' => ['auth:api']], function () {
    Route::patch('profile', 'ProfileAPIController@update');
    Route::patch('profile/password', 'ProfileAPIController@password');
    Route::get('profile/notifications', 'ProfileAPIController@notifications');

    Route::get('users/{user}/comments', 'UserAPIController@comments');

    Route::get('posts/{post}/comments', 'PostAPIController@comments');
    Route::put('posts/{post}/comment', 'PostAPIController@comment');
    Route::delete('posts/{post}/users/{user}/comments', 'PostAPIController@deleteUserComments');

    Route::delete('comments/{comment}', 'CommentAPIController@destroy');
});
