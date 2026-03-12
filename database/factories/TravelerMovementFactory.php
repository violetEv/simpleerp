<?php

namespace Database\Factories;

use App\Models\Departments;
use App\Models\Machine;
use App\Models\Traveler;
use App\Models\TravelerMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelerMovement>
 */
class TravelerMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TravelerMovement::class;

    public function definition(): array
    {
        $traveler = Traveler::inRandomOrder()->first();
        $dept = Departments::inRandomOrder()->first();
        $machine = Machine::inRandomOrder()->first();

        $qty_in = $this->faker->numberBetween(50, 200);
        $qty_out = $this->faker->numberBetween(0, $qty_in);
        $qty_reject = $qty_in - $qty_out;

        return [
            'traveler_id' => $traveler->id,
            'dept_id' => $dept->id,
            'qty_in' => $qty_in,
            'qty_out' => $qty_out,
            'date_in' => $this->faker->dateTimeThisMonth(),
            'date_out' => $this->faker->dateTimeThisMonth(),
            'dept_destination_id' => Departments::inRandomOrder()->first()->id,
            'qty_reject' => $qty_reject,
            'type_reject' => $qty_reject > 0 ? 'defect' : null,
            'notes' => $this->faker->sentence(),
            'machine_id' => $machine->id,
        ];
    }
}
