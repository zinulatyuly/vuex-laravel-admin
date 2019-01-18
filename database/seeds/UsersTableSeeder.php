<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'           => 'Admin',
            'email'          => 'a@a.a',
            'password'       => bcrypt('bbb'),
            'remember_token' => str_random(60)
        ]);
    }
}
