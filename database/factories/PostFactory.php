<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'user_id' => factory('App\Models\User'),
            'user_id' => \App\Models\User::all()->random()->id,
            'title' => $this->faker->sentence,
            'post_image' => $this->faker->imageUrl('900', '300'),
            'body' => $this->faker->paragraph
        ];
    }
}

/* laravel 7
$factory->define(Post::class, function (Faker $faker){
    return [
        'user_id' => factory('App\Models\User'),
        'title' => $faker->sentence,
        'post_image' => $faker->imageUrl('900', '300'),
        'body' => $faker->paragraph
    ];
});
*/
