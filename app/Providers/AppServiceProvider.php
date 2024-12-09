<?php

namespace App\Providers;

use App\Services\Proxycheck\Client;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                config('services.proxycheck.key'),
                config('services.proxycheck.base_url')
            );
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
