<?php

namespace App\Api\V1\Http\Controllers\Auth;

use App\Api\V1\Exceptions\Auth\GetTokenException;
use App\Api\V1\Http\Controllers\AbstractApiController;
use App\Api\V1\Services\Auth\GetTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTokenController extends AbstractApiController
{
    /**
     * Instance of GetTokenService.
     * @var GetTokenService
     */
    public GetTokenService $getTokenService;

    public function __construct(GetTokenService $getTokenService)
    {
        $this->getTokenService = $getTokenService;
    }

    /**
     * Prepare data for retrieval and return processed data.
     * @param Request $request
     * @return JsonResource|JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            return $this->success(new JsonResource(['token' => $this->getTokenService->execute()]));
        } catch (GetTokenException $e) {
            return $this->failure($e);
        }
    }
}
