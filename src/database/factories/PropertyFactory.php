<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'bedrooms' => rand(1, 5),
            'bathrooms' => rand(1, 5),
            'total_area' => rand(20, 500),
            'purchased' => rand(0, 1),
            'value' => floatval(rand(100000, 1000000)),
            'discount' => rand(10, 50),
            'owner_id' => rand(1, 5),
            'expired' => rand(0, 1),
        ];
    }
}
