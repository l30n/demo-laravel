<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['joint', 'fund', 'comment'];

        return [
            'sender' => "System",
            'type' => $types[array_rand($types, 1)],
            'metadata' => ["user" => fake()->name(), "formation" => fake()->name()]
        ];
    }
}
