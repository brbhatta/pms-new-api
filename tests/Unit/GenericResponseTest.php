<?php

use App\Http\Resources\GenericResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Http\Data\UserData;

uses(Tests\TestCase::class);

it('notFound returns 404 with message', function () {
    $res = GenericResponse::notFound('Not here');

    expect($res)->toBeInstanceOf(Illuminate\Http\JsonResponse::class);
    expect($res->getStatusCode())->toBe(404);
    $payload = $res->getData(true);
    expect($payload['message'])->toBe('Not here');
});

it('success returns default success message and custom message', function () {
    $res = GenericResponse::success();
    $payload = $res->getData(true);
    expect($payload['code'])->toBe('SUCCESS');

    $res2 = GenericResponse::success('Action completed');
    $payload2 = $res2->getData(true);
    expect($payload2['message'])->toBe('Action completed');
});

it('failed accepts optional message and code', function () {
    $response = GenericResponse::failed('RESOURCE_NOT_FOUND', 'Failed to process request');

    $result = $response->getData(true);
    $code = $response->getStatusCode();

    expect(in_array($code, [422, 400]))->toBeTrue();
    $errorCode = $result['code'] ?? null;
    $message = $result['message'] ?? null;

    expect($message)->not->toBeNull();
    expect(is_string($message))->toBeTrue();
    expect($message)->toBe("Failed to process request");
    expect($errorCode)->toBe('RESOURCE_NOT_FOUND');

    $res2 = GenericResponse::failed();
    expect($res2->getStatusCode())->toBe(400);
});

it('resource returns JsonResource wrapping plain data and supports resourceClass mapping', function () {
    $data = ['id' => '1', 'name' => 'x', 'email' => 'user@user.com', 'metadata' => []];

    $res = GenericResponse::resource($data);

    $arr = $res->toArray(Request::create('/'));
    expect($arr)->toBe($data);

    $res2 = GenericResponse::resource($data, UserData::class);
    $arr2 = $res2->toArray(Request::create('/'));

    expect($arr2)->toBe($data);
});

it('collection returns a non-paginated json resource', function () {
    $collection = [['id' => 1], ['id' => 2]];

    $res = GenericResponse::collection($collection, null, 'items');

    $arr = $res->toArray(Request::create('/'));
    expect($arr['items'])->toBe($collection);
});

it('collection handles LengthAwarePaginator and extra keys and resourceClass', function () {
    $items = [['id' => '1', 'name' => 'x', 'email' => 'user@user.com']];
    $paginator = new LengthAwarePaginator($items, 2, 2, 1, ['path' => 'http://example.test/items']);

    // set current request query so appends() picks it up
    request()->query->replace(['q' => '1']);

    $res = GenericResponse::collection($paginator, UserData::class, 'data', ['extra' => 'ok']);

    $arr = $res->toArray(Request::create('/items?page=1'));

    expect(array_key_exists('data', $arr))->toBeTrue();
    expect($arr['extra'])->toBe('ok');
    expect($arr['meta']['totalResources'])->toBe(2);
    expect(array_key_exists('links', $arr))->toBeTrue();

    // ensure items were mapped by PagedResource::from
    expect($arr['data'][0]['name'])->toBe('x');
});

it('collection with resourceClass on paginator maps items', function () {
    $items = [['id' => '1', 'name' => 'x', 'email' => 'user@user.com']];
    $paginator = new LengthAwarePaginator($items, 2, 2, 1, ['path' => 'http://example.test/items']);

    $res = GenericResponse::collection($paginator, UserData::class, 'items');
    $arr = $res->toArray(Request::create('/items?page=1'));

    expect(array_key_exists('items', $arr))->toBeTrue();
    expect($arr['items'][0]['name'])->toBe('x');
});
