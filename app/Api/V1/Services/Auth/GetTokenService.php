<?php declare(strict_types=1);

namespace App\Api\V1\Services\Auth;

use App\Api\V1\Exceptions\Auth\GetTokenException;
use Throwable;

class GetTokenService
{
    private CreateJWTService $jwtService;

    public function __construct(CreateJWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * @return mixed
     * @throws GetTokenException
     */
    public function execute()
    {
        try {
            $user = auth()->user();

            $user->load(['token']);

            $lastValidToken = optional($user->token)->last();

            if ($lastValidToken) {
                if (!$this->jwtService->expired($lastValidToken->jwt)) {
                    return $lastValidToken->jwt;
                }
            }

            $newToken = $this->jwtService->create($user->toArray());

            $user->token()->create(['jwt' => $newToken]);

            return $newToken;
        } catch (Throwable $t) {
            throw new GetTokenException('Unable to fetch token.', 5000, $t);
        }
    }
}
