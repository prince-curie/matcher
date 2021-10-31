<?php

namespace Database\Factories;

use App\Models\SearchProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SearchProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SearchProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $minArea = $this->faker->optional()->randomNumber(3);
        $maxArea = $minArea == null ? 
            $this->faker->optional()->randomNumber(3) :
            $minArea + $this->faker->optional()->randomNumber(3);

        $minYear = optional(Carbon::create($this->faker->year()));
        $maxYear = $minYear == null ? 
            $this->faker->year() :
            ($minYear->addYears($this->faker->randomDigitNotNull()))->format('Y');
        
        $minRooms = $this->faker->optional()->randomDigitNotZero();
        $maxRooms = $minRooms == null ? 
            $this->faker->optional()->randomDigitNotZero() :
            $minRooms + $this->faker->randomDigit();
        
        $minPotentialReturn = $this->faker->optional()->passthrough(mt_rand(0,100));
        $maxPotentialReturn = $minPotentialReturn < 80 && !is_null($minPotentialReturn) ? 
            mt_rand(0,100) + $minPotentialReturn : 
            $this->faker->optional()->passthrough(mt_rand(0,100));

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
            'min_price' => $this->faker->optional()->randomNumber(4),
            'max_price' => $this->faker->optional()->randomNumber(7),
            'min_area' => $minArea,
            'max_area' => $maxArea,
            'min_year_of_construction' => $minYear->format('Y'),
            'max_year_of_construction' => $maxYear,
            'min_rooms' => $minRooms,
            'max_rooms' => $maxRooms,
            'min_potential_return' => $minPotentialReturn,
            'max_potential_return' => $maxPotentialReturn,
            'parking' => $this->faker->optional()->boolean(),
            'heating_type' => $this->faker->optional()->passthrough(
                $heatingType[array_rand($heatingType)]
            ), 
        ];
    }
}
