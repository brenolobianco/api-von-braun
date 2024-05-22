<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TelnetService;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TelnetService::class, function ($app) {
            // Aqui você pode obter as configurações necessárias do .env ou de algum outro lugar
            // Para simplificar, estou usando valores fixos, mas você deve substituir por variáveis do seu .env ou configuração
            $hostname = env('TELNET_HOST', 'default_host');
            $port = env('TELNET_PORT', 23);
            $username = env('TELNET_USERNAME', 'default_user');
            $password = env('TELNET_PASSWORD', 'default_pass');
            return new TelnetService($hostname, $port, $username, $password);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(SanctumPersonalAccessToken::class);
    }
}
