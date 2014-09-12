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

    public function tearDown() {
        Mockery::close();
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

    public function testUserDetails() {

        $token = new \League\OAuth2\Client\Token\AccessToken([
            'uid' => 12345678,
            'access_token' => "mock_access_token",
            "refresh_token" => "mock_refresh_token",
            "expires_in" => 3600
        ]);

        $response = [
            'battletag' => 'testuser#1234'
        ];

        $user = $this->provider->userDetails($response, $token);

        $this->assertAttributeEquals(12345678, 'uid', $user);
        $this->assertAttributeEquals($response['battletag'], 'nickname', $user);
    }


}
 