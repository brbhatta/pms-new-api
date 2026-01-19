<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\User\Http\Data\UserData;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GenericResponse
{
    public static function notFound(?string $message): JsonResponse
    {
        return response()->json([
            'code' => "RESOURCE-NOT_FOUND",
            'message' => $message ?? 'Resource not found'
        ], ResponseAlias::HTTP_NOT_FOUND);
    }

    public static function success(?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => 'SUCCESS',
            'message' => $message ?? 'Operation completed successfully'
        ], ResponseAlias::HTTP_OK);
    }

    // Accept either an optional message and optional status code
    public static function failed(?string $code = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'code' => $code ?? 'FAILED',
            'message' => $message ?? 'Failed to process request'
        ], ResponseAlias::HTTP_BAD_REQUEST);
    }

    public static function resource($resource, $resourceClass = null): JsonResource
    {
        if ($resourceClass) {
            $resource = $resourceClass::from($resource);
        }

        return new JsonResource($resource);
    }

    public static function collection($collection, $resourceClass = null, $key = 'data', $extraKeys = null): JsonResource
    {
        if ($resourceClass) {
            $collection->setCollection(
                $collection->getCollection()->map(fn ($item) => $resourceClass::from($item))
            );
        }

        if ($extraKeys && $resourceClass) {
            if (is_string($resourceClass) && method_exists($resourceClass, 'keysMap')) {
                $resourceClass::keysMap($extraKeys);
            }
        }

        $extraKeys = $extraKeys ?? [];

        if (!$collection instanceof LengthAwarePaginator) {
            return new JsonResource(
                $extraKeys +
                [
                    $key => $collection
                ]
            );
        }

        $collection = $collection->appends(request()->query())->toArray();

        $meta = [
            'totalResources' => $collection['total'],
            'currentPage' => $collection['current_page'],
            'totalPages' => $collection['last_page'],
            'pageSize' => $collection['per_page']
        ];

        $links = [
            'first' => $collection['first_page_url'] ? url($collection['first_page_url']) : null,
            'prev' => $collection['prev_page_url'] ? url($collection['prev_page_url']) : null,
            'next' => $collection['next_page_url'] ? url($collection['next_page_url']) : null,
            'last' => $collection['last_page_url'] ? url($collection['last_page_url']) : null
        ];

        return new JsonResource(
            $extraKeys +
            [
                $key => $collection['data'],
                'meta' => $meta,
                'links' => $links
            ]
        );
    }
}
