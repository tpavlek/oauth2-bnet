<?php

namespace Depotwarehouse\OAuth2\Client\Provider;

use Depotwarehouse\OAuth2\Client\Entity\BattleNetUser;
use Guzzle\Http\Exception\BadResponseException;
use League\OAuth2\Client\Exception\IDPException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class BattleNet extends AbstractProvider
{

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'accountId';

    protected function getScopeSeparator()
    {
        return " ";
    }

    /**
     * @param $response
     * @param AccessToken $token
     * @return BattleNetUser
     */
    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {

    }

    public function getBaseAuthorizationUrl()
    {
        return "https://us.battle.net/oauth/authorize";
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return "https://us.battle.net/oauth/token";
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return "https://us.api.battle.net/sc2/profile/user?access_token=" . $token;
    }

    protected function getDefaultScopes()
    {
        return [
            'sc2.profile'
        ];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() != 200) {
            $data = json_decode($data, true);
            throw new IdentityProviderException($data['message'], $response->getStatusCode(), $data);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $response = (array)($response['characters'][0]);
        $user = new BattleNetUser($response);

        return $user;
    }
}
