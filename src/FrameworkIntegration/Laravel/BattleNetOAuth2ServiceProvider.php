<?php

namespace Depotwarehouse\OAuth2\Client\FrameworkIntegration\Laravel;


use Depotwarehouse\OAuth2\Client\Provider\BattleNet;
use Illuminate\Support\ServiceProvider;

class BattleNetOAuth2ServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('depotwarehouse/oauth2-bnet', null, __DIR__);
        $this->app->bind(BattleNet::class, function () {
            return new BattleNet([
                'clientId' => \Config::get('oauth2-bnet::clientId'),
                'clientSecret' => \Config::get('oauth2-bnet::clientSecret'),
                'redirectUri' => \Config::get('oauth2-bnet::redirectUri'),
            ]);
        });
    }

    public function boot()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
} 