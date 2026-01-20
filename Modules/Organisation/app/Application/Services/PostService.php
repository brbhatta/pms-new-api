<?php

namespace Modules\Organisation\Application\Services;

use Modules\Organisation\Application\Contracts\PostServiceInterface;
use Modules\Organisation\Application\Exceptions\PostNotFoundException;
use Modules\Organisation\Http\Data\PostData;
use Modules\Organisation\Models\Post;

class PostService implements PostServiceInterface
{
    public function __construct(
        private Post $post
    ) {
    }

    public function findPost(string $id): PostData
    {
        $post = $this->post->newQuery()->find($id);

        if (! $post) {
            throw new PostNotFoundException($id);
        }

        return PostData::from($post);
    }

    public function getPost(string $id): ?PostData
    {
        $post = $this->post->newQuery()->find($id);

        return $post ? PostData::from($post) : null;
    }
}
