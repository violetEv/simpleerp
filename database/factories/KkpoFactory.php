<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryProcess;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kkpo>
 */
class KkpoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $style = Style::inRandomOrder()->first();
        $color = Color::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();
        $customer = Customer::inRandomOrder()->first();

        return [
            'no_kkpo' => 'KKPO-' . $this->faker->unique()->numerify('#####'),
            'style_id' => $style->id,
            'color_id' => $color->id,
            'category_id' => $category->id,
            'customer_id' => $customer->id,
            'qty_total' => $this->faker->numberBetween(50, 500),
            'price' => $this->faker->randomFloat(2, 10000, 100000),
        ];
    }
}