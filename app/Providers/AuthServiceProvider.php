<?php

namespace App\Providers;

use App\Api\V1\Services\Auth\CreateJWTService;
use App\Models\JWToken;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('jwt', function (Request $request) {
            $jwt = JWToken::with(['user'])
                ->where('jwt', $request->header('Authorization'))
                ->orderByDesc('created_at')
                ->first();

            if (!$jwt) {
                return null;
            }

            $tokenExpired = app()->call(function (CreateJWTService $service, $jwt) {
                return $service->expired($jwt);
            }, ['jwt' => $jwt]);

            if ($tokenExpired) {
                return null;
            }

            return optional($jwt)->user;
        });
    }
}
