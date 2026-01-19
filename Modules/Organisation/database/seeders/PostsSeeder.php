<?php

namespace Modules\Organisation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Organisation\Http\Enums\PostType;
use Modules\Organisation\Models\Post;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        // Create posts top-down (Secretary -> Additional -> Joint -> Deputy -> Section)
        $parentId = null;

        // PostType::orderedHierarchy() returns lowest-to-highest; reverse to create highest-first
        $hierarchy = array_reverse(PostType::orderedHierarchy());

        foreach ($hierarchy as $postType) {
            $created = Post::create([
                'id' => Str::uuid()->toString(),
                'name' => $postType->label(),
                'code' => $postType->name,
                'level' => $postType->level(),
                'reports_to_post_id' => $parentId,
                'metadata' => null,
            ]);

            // next item should report to this created post
            $parentId = $created->id;
        }
    }
}
