<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Emil Gaarde',
            'email' => 'gaardee@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'name' => 'Signe Randorff',
            'email' => 'signerandorff@hotmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
