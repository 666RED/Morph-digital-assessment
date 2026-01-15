<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Record;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    protected $model = Record::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();

        return [
            'name' => $this->faker->sentence(3),
            "user_id" => User::inRandomOrder()->first()->id,
            'category_id' => $category->id,
            'type' => $category->type,
            'amount' => $this->faker->randomFloat(2, 5, 1000),
            'note' => $this->faker->optional()->sentence(),
            'record_date' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
        ];
    }
}
