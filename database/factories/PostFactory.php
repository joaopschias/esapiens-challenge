<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {
    $kind = Arr::random(array_keys(Post::getArrayKinds()));
    $content = '';

    switch ($kind) {
        case 'photo':
            $content = $faker->imageUrl();
            break;
        case 'video':
            $content = $faker->url;
            break;
        case 'text':
            $content = $faker->paragraph;
            break;
    }

    return [
        'user_id' => factory(User::class),
        'kind' => $kind,
        'content' => $content,
    ];
});
