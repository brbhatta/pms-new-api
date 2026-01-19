<?php

namespace Modules\Organisation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Organisation\Models\Posting;
use Modules\Organisation\Models\Post;
use Modules\Organisation\Models\OrganisationUnit;
use Modules\User\Models\User;

class PostingFactory extends Factory
{
    protected $model = Posting::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'organisation_unit_id' => OrganisationUnit::factory(),
            'posting_type' => 'permanent',
            'start_date' => now()->toDateString(),
            'end_date' => null,
        ];
    }
}
