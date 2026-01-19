<?php

use App\Http\Resources\PaginatedResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

uses(Tests\TestCase::class);

it('formats a LengthAwarePaginator into the paginated response structure', function () {
    // Prepare items and paginator
    $items = [
        ['id' => 1, 'name' => 'A'],
        ['id' => 2, 'name' => 'B'],
    ];

    $total = 10;
    $perPage = 2;
    $currentPage = 2;

    $paginator = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
        'path' => 'http://example.test/resources',
    ]);

    // Create the resource with a custom label and additional data
    $resource = new PaginatedResponse($paginator, 'items', ['extra' => 'value']);

    // Build a fake request (so request()->fullUrlWithoutQuery works)
    $request = Request::create('http://example.test/resources?page=2', 'GET');

    $array = $resource->toArray($request);

    // Basic structure
    expect($array)->toHaveKeys(['items', 'meta', 'links', 'extra']);

    // Data label contains items
    expect($array['items'])->toBe($items);

    // Additional data preserved
    expect($array['extra'])->toBe('value');

    // Meta fields
    expect($array['meta']['total'])->toBe($total);
    expect($array['meta']['per_page'])->toBe($perPage);
    expect($array['meta']['current_page'])->toBe($currentPage);

    // Links keys exist and are strings or null
    expect(array_keys($array['links']))->toContain('first');
    expect(array_keys($array['links']))->toContain('last');
    expect(array_keys($array['links']))->toContain('prev');
    expect(array_keys($array['links']))->toContain('next');

    // Values for first/last should be strings or null (environment may render absolute or relative URLs)
    $first = $array['links']['first'];
    $last = $array['links']['last'];

    expect(is_null($first) || is_string($first))->toBeTrue();
    expect(is_null($last) || is_string($last))->toBeTrue();
});
