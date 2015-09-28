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

    protected $_ROD = array(
        "region" => "us",
        "game" => "sc2"
    );

    protected $_RODurl;

    public function settings(array $params)
    {
        // Update any params defined
        foreach ($params as $option => $value) {
            if ($this->_ROD[$option]){
                $this->_ROD[$option] = $value;
            }
        }

        // Set final url
        switch ($this->_ROD['game']) {
            case 'wow':
                $this->_RODurl = "https://{$this->_ROD['region']}.api.battle.net/wow/user/characters?access_token=";
                break;
            
            default:
                $this->_RODurl = "https://{$this->_ROD['region']}.api.battle.net/sc2/profile/user?access_token=";
                break;
        }
    }

    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'accountId';

    protected function getScopeSeparator()
    {
        return " ";
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
        return $this->_RODurl . $token;
    }

    protected function getDefaultScopes()
    {
        return [
            "{$this->_ROD['game']}.profile"
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
        $response = (array)($response['characters']);
        $user = new BattleNetUser($response, $this->_ROD['region']);

        return $user;
    }
}
