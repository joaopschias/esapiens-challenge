<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'administrator@domain.com'],
            [
                'name' => 'Administrator',
                'email_verified_at' => now(),
                'password' => 'abc123',
                'remember_token' => Str::random(10),
            ]
        );

        $role = \App\Models\Role::query()->where('name', '=', 'administrator')->firstOrFail();

        $user->attachRole($role);
    }
}
