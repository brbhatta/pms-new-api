<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedResponse extends JsonResource
{
    public function __construct(
        private readonly LengthAwarePaginator $paginator,
        private readonly string $dataLabel = 'data',
        private readonly array $additionalData = []
    ) {
        parent::__construct($paginator->items());
    }

    public function toArray(Request $request): array
    {
        $this->paginator->setPath(request()->fullUrlWithoutQuery('page'));

        $meta = [
            'current_page' => $this->paginator->currentPage(),
            'from' => $this->paginator->firstItem(),
            'last_page' => $this->paginator->lastPage(),
            'per_page' => $this->paginator->perPage(),
            'to' => $this->paginator->lastItem(),
            'total' => $this->paginator->total(),
            'links' => $this->paginator->linkCollection()->toArray(),
        ];

        $links = [
            'first' => $this->paginator->url(1),
            'last' => $this->paginator->url($this->paginator->lastPage()),
            'prev' => $this->paginator->previousPageUrl(),
            'next' => $this->paginator->nextPageUrl(),
        ];

        $items = $this->paginator->items();

        return array_merge([
            $this->dataLabel => $items,
            'meta' => $meta,
            'links' => $links,
        ], $this->additionalData);
    }
}
