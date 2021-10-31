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
        $heatingType = [
            'gas',
            'electricity',
            'wood',
        ];

        $propertyType = [
            'land',
            'apartment',
            'office'
        ];

        return [
            'name' => $this->faker->name(),
            'property_type' => $this->faker->passthrough(
                $propertyType[array_rand($propertyType)]
            ),
            'address' => $this->faker->address(),
            'price' => $this->faker->optional()->randomNumber(mt_rand(4, 7)),
            'area' => $this->faker->optional()->randomNumber(3),
            'construction_year' => $this->faker->optional()->year(),
            'rooms' => $this->faker->optional()->randomDigitNotZero(),
            'actual_return' => array_rand($propertyType),
            'parking' => $this->faker->optional()->boolean(),
            'heating_type' => $this->faker->optional()->passthrough(
                $heatingType[array_rand($heatingType)]
            ),
        ];
    }
}
