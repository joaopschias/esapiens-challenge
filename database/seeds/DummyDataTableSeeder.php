<?php

use Illuminate\Database\Seeder;
use \App\Models\Post;
use \App\Models\User;

class DummyDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = \App\Models\Role::query()->where('name', '=', 'user')->firstOrFail();
        $roleSubscriber = \App\Models\Role::query()->where('name', '=', 'subscriber')->firstOrFail();

        factory(User::class, 10)->create()->each(function ($user) use ($roleUser, $roleSubscriber) {
            $user->attachRole($roleUser);
            if($user->balance > 0){
                $user->attachRole($roleSubscriber);

                $user->posts()->createMany(
                    factory(Post::class, 5)->make(['user_id' => $user->id])->toArray()
                );
            }
        });
    }
}
