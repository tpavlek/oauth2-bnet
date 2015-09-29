<?php

namespace Depotwarehouse\OAuth2\Client\FrameworkIntegration\Laravel;


use Depotwarehouse\OAuth2\Client\Provider\BattleNet;
use Depotwarehouse\OAuth2\Client\Provider\SC2Provider;
use Depotwarehouse\OAuth2\Client\Provider\WowProvider;
use Illuminate\Support\ServiceProvider;

class BattleNetOAuth2ServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     */
    public function register()
    {
        $this->app->bind(SC2Provider::class, function() {
            return new SC2Provider([
                'clientId' => \Config::get('oauth2-bnet.clientId'),
                'clientSecret' => \Config::get('oauth2-bnet.clientSecret'),
                'redirectUri' => \Config::get('oauth2-bnet.redirectUri'),
            ]);
        });

        $this->app->bind(WowProvider::class, function() {
            return new WowProvider([
                'clientId' => \Config::get('oauth2-bnet.clientId'),
                'clientSecret' => \Config::get('oauth2-bnet.clientSecret'),
                'redirectUri' => \Config::get('oauth2-bnet.redirectUri'),
            ]);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/oauth2-bnet.php' => config_path('oauth2-bnet.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/config/oauth2-bnet.php', 'oauth2-bnet');
    }
}
