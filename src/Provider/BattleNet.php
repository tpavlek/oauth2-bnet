<?php

namespace Depotwarehouse\OAuth2\Client\Provider;

use Guzzle\Http\Exception\BadResponseException;
use League\OAuth2\Client\Exception\IDPException;
use League\OAuth2\Client\Provider\IdentityProvider;
use League\OAuth2\Client\Provider\User;
use League\OAuth2\Client\Token\AccessToken;

class BattleNet extends IdentityProvider {

    public function __construct(array $options = array()) {
        parent::__construct($options);
    }

    public $scopes = [
        'wow.profile',
        'sc2.profile'
    ];

    public function urlAuthorize()
    {
        return "https://us.battle.net/oauth/authorize";
    }

    public function urlAccessToken()
    {
        return "https://us.battle.net/oauth/token";
    }

    public function urlUserDetails(AccessToken $token)
    {
        return "https://us.api.battle.net/account/user/id?access_token=" . $token;
    }

    public function urlUserNickname(AccessToken $token) {
        return "https://us.api.battle.net/account/user/battletag?access_token=" . $token;
    }

    protected function fetchUserDetails(AccessToken $token)
    {
        $response = [];

        try {

            $client = $this->getHttpClient();
            $client->setBaseUrl($this->urlUserDetails($token));

            if ($this->headers) {
                $client->setDefaultOption('headers', $this->headers);
            }

            $request = $client->get()->send();
            $response = array_merge($response, (array)json_decode($request->getBody()));

            $client = $this->getHttpClient();
            $client->setBaseUrl($this->urlUserNickname($token));

            if ($this->headers) {
                $client->setDefaultOption('headers', $this->headers);
            }

            $request = $client->get()->send();
            $response = array_merge($response, (array)json_decode($request->getBody()));

        } catch (BadResponseException $e) {
            // @codeCoverageIgnoreStart
            $raw_response = explode("\n", $e->getResponse());
            throw new IDPException(end($raw_response));
            // @codeCoverageIgnoreEnd
        }

        return json_encode($response);
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $response = (array)$response;

        $user = new User();

        $user->uid = $response["id"];
        $user->nickname = strstr($response["battletag"], '#', true);

        return $user;
    }
}