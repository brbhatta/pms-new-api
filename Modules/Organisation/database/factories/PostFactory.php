<?php

namespace Modules\Organisation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Organisation\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => $this->faker->jobTitle(),
            'code' => strtoupper($this->faker->lexify('???')) . '_' . $this->faker->unique()->numberBetween(1, 9999),
            'level' => $this->faker->numberBetween(1, 10),
            'reports_to_post_id' => null,
            'metadata' => null,
        ];
    }
}
