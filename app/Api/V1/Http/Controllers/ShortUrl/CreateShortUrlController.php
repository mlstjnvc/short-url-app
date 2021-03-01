<?php

namespace App\Api\V1\Http\Controllers\ShortUrl;

use App\Api\V1\Exceptions\ShortUrl\CreateShortUrlException;
use App\Api\V1\Http\Controllers\AbstractApiController;
use App\Api\V1\Http\Requests\ShortUrl\CreateShortUrlRequest;
use App\Api\V1\Services\ShortUrl\CreateShortUrlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateShortUrlController extends AbstractApiController
{
    /**
     * Instance of CreateShortUrlService.
     * @var CreateShortUrlService
     */
    public CreateShortUrlService $shortUrlService;

    public function __construct(CreateShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
    }

    /**
     * Transform given url to short url.
     * @param CreateShortUrlRequest $request
     * @return JsonResource|JsonResponse
     */
    public function __invoke(CreateShortUrlRequest $request)
    {
        $data = $request->validated();

        try {
            return $this->success(new JsonResource(['short_url' => $this->shortUrlService->execute($data)]));
        } catch (CreateShortUrlException $e) {
            return $this->failure($e);
        }
    }
}
