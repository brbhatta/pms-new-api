<?php

namespace Modules\Organisation\Application\Contracts;

use Modules\Organisation\Http\Data\PostData;

interface PostServiceInterface
{
    public function findPost(string $id): PostData;
    public function getPost(string $id): ?PostData;
}
