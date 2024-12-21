<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;
 
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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
        Route::prefix('oauth')->group(function () {
          
            Route::get('/authorize', [AuthorizationController::class, 'authorize'])->name('passport.authorizations.authorize');
            Route::post('/authorize', [ApproveAuthorizationController::class, 'approve'])->name('passport.authorizations.approve');
            Route::delete('/authorize', [DenyAuthorizationController::class, 'deny'])->name('passport.authorizations.deny');
            Route::post('/token/refresh', [TransientTokenController::class, 'refresh'])->name('passport.token.refresh');
            Route::get('/clients', [ClientController::class, 'index'])->name('passport.clients.index');
            Route::post('/clients', [ClientController::class, 'store'])->name('passport.clients.store');
            Route::put('/clients/{client_id}', [ClientController::class, 'update'])->name('passport.clients.update');
            Route::delete('/clients/{client_id}', [ClientController::class, 'destroy'])->name('passport.clients.destroy');
            Route::get('/personal-access-tokens', [PersonalAccessTokenController::class, 'index'])->name('passport.personal.tokens.index');
            Route::post('/personal-access-tokens', [PersonalAccessTokenController::class, 'store'])->name('passport.personal.tokens.store');
            Route::delete('/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])->name('passport.personal.tokens.destroy');
        });

        //
    }
}
