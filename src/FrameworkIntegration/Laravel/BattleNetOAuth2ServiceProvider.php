<?php

namespace Depotwarehouse\OAuth2\Client\FrameworkIntegration\Laravel;


use Depotwarehouse\OAuth2\Client\Provider\BattleNet;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class BattleNetOAuth2ServiceProvider extends ServiceProvider
{

    /** @var  Repository */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

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
        $config = $this->config;

        $this->app->bind(BattleNet::class, function () use ($config) {
            return new BattleNet([
                'clientId' => $config->get('oauth2-bnet.clientId'),
                'clientSecret' => $config->get('oauth2-bnet.clientSecret'),
                'redirectUri' => $config->get('oauth2-bnet.redirectUri'),
            ]);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/oauth2-bnet.php' => config_path('oauth2-bnet.php')
        ]);
    }
}
