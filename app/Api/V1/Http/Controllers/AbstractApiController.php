<?php declare(strict_types=1);

namespace App\Api\V1\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;

abstract class AbstractApiController extends Controller
{
    /**
     * Return a resource with added meta
     * @param JsonResource|null $resource
     * @param array|null $meta
     * @return JsonResource
     */
    final public function success(?JsonResource $resource, ?array $meta = null): JsonResource
    {
        if ($resource === null) {
            $resource = new ResourceCollection([]);
        }

        if ($meta !== null) {
            $this->addMetaToResource($resource, $meta);
        }

        return $resource;
    }

    /**
     * Create log and return error.
     * @param \Throwable $error
     * @return JsonResponse
     */
    final public function failure(\Throwable $error): JsonResponse
    {
        logger()->critical(
            $error->getMessage() ?? 'Unable to execute request',
            [
                'user_id' => optional(auth()->user())->id ?? 'public route',
                'location' => $error->getLine()
            ]
        );

        return new JsonResponse($error->getMessage(), 500);
    }

    /**
     * Add or merge meta.
     * @param JsonResource $resource
     * @param array $meta
     */
    private function addMetaToResource(JsonResource &$resource, array $meta): void
    {
        if (isset($resource->additional['meta'])) {
            $meta = array_merge($resource->additional['meta'], $meta);
        }

        $resource->additional['meta'] = $meta;
    }
}
