<?php declare(strict_types=1);

namespace App\Api\V1\Http\Controllers\Auth;

use App\Api\V1\Http\Controllers\AbstractApiController;
use App\Api\V1\Http\Requests\Auth\LoginRequest;
use App\Api\V1\Http\Resources\UserResource;
use App\Api\V1\Services\Auth\GetTokenService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends AbstractApiController
{
    /**
     * Handle an incoming authentication request.
     * @param LoginRequest $request
     * @return JsonResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResource
    {
        $request->authenticate();

        $request->session()->regenerate();

        app()->call(function (GetTokenService $service) {
            return $service->execute();
        });

        return $this->success(new UserResource(auth()->user()->load(['token'])));
    }

    /**
     * Destroy an authenticated session.
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
