<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(100)->create()->each(function($user){
        //to create 10 posts of the users too
            $user->posts()->save(\App\Models\Post::factory()->make());
            //$user->posts()->save(factory('App/Models/Post')->make());
         });
        
        //factory('App\Models\User', 10)->create();
    }
}
