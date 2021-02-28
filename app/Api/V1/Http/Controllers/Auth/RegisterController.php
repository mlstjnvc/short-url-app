<?php declare(strict_types=1);

namespace App\Api\V1\Http\Controllers\Auth;

use App\Api\V1\Http\Controllers\AbstractApiController;
use App\Api\V1\Http\Resources\UserResource;
use App\Api\V1\Services\Auth\CreateJWTService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends AbstractApiController
{
    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return JsonResource
     * @throws ValidationException
     */
    public function register(Request $request): JsonResource
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $jwt = app()->call(function (CreateJWTService $service, array $userData) {
            return $service->create($userData);
        }, ['userData' => $user->toArray()]);

        $user->token()->create(['jwt' => $jwt]);

        event(new Registered($user));

        return $this->success(new UserResource($user->load('token')));
    }
}
