<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CouponFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 4),
            'partner_id' => $this->faker->numberBetween(1, 3),
            'slug' => $this->faker->slug(),
            'title' => $this->faker->text(25),
            'expiration' => $this->faker->dateTimeBetween('now', '+8 weeks'),
            'excerpt' => $this->faker->text(200),
            'description' => $this->faker->text(1000),
            'og_price' => $this->faker->numberBetween(999, 9999),
            'discounted_price' => $this->faker->numberBetween(999, 9999),
        ];
    }
}
