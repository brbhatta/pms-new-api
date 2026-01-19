<?php

namespace Modules\Organisation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Organisation\Models\OrganisationUnit;

class OrganisationUnitFactory extends Factory
{
    protected $model = OrganisationUnit::class;

    public function definition(): array
    {
        $types = ['ministry','department','division','section'];

        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->company(),
            'code' => strtoupper($this->faker->lexify('???')),
            'type' => $this->faker->randomElement($types),
            'parent_id' => null,
            'metadata' => null,
        ];
    }
}
