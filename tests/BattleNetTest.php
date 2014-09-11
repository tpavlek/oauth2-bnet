<?php

use \Depotwarehouse\OAuth2\Client\Provider\BattleNet;

class BattleNetTest extends PHPUnit_Framework_TestCase {

    /** @var \Depotwarehouse\OAuth2\Client\Provider\BattleNet */
    protected $provider;

    public function setUp() {
        parent::setUp();
        $this->provider = new BattleNet([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none'
        ]);
    }

    public function testAuthorizationUrl() {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);
        parse_str($uri['query'], $query);

        $this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);
        $this->assertArrayHasKey('approval_prompt', $query);
    }

    public function testUrlAccessToken() {
        $url = $this->provider->urlAccessToken();

        // The most trivial of tests, lol...
        $this->assertEquals("https://us.battle.net/oauth/token", $url);
    }

    public function testGetAccessToken() {
        $response = Mockery::mock('\Guzzle\Http\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn('access_token=mock_access_token&expires=3600&refresh_token=mock_refresh_token&uid=1')

    }

    public function testFetchUserDetails() {
        $mockClient = Mockery::mock('\Guzzle\Http\Client');

        $provider = new \Depotwarehouse\OAuth2\Client\Provider\BattleNet();

        $provider->setHttpClient($mockClient);

        $mockClient->shouldReceive('setBaseUrl');
    }


}
 