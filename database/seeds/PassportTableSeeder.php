<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PassportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');
        DB::statement('UPDATE `oauth_clients` SET `secret` = \'Aw32E9rYahjTQ5NxUdOOQDmuJFE5vB7U2SAQgFX4\' WHERE `oauth_clients`.`id` = 1;');
        DB::statement('UPDATE `oauth_clients` SET `secret` = \'VmSYqmpn9tSrZ3iJ6TfVbZ6PwWbhWPUBoEOrX8Cc\' WHERE `oauth_clients`.`id` = 2;');
    }
}
