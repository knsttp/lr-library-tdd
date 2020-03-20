<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(['email' => 'admin@example.com', 'password' => bcrypt('secret')]);
        factory(User::class)->create(['email' => 'user@example.com', 'password' => bcrypt('secret')]);
    }
}
