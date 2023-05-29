<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // create super admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123qweasd'),
            'administrator' => true,
        ]);

        User::create([
            'name' => 'user_1',
            'email' => 'user_1@example.com',
            'password' => bcrypt('123qweasd'),
            'administrator' => true,
        ]);
    }
}
