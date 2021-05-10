<?php

namespace Database\Factories;

use App\Models\Incident;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Incident::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->text(80),
            'description' => $this->faker->text(255),
            'criticality' => Incident::CRITICALITY_HIGH,
            'type'        => Incident::TYPE_INCIDENT,
            'status'      => Incident::STATUS_ACTIVE,
        ];
    }
}
