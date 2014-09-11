<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 11/09/14
 * Time: 15:12
 */

namespace Depotwarehouse\OAuth2\Client\Grant;


use Depotwarehouse\OAuth2\Client\Token\AccessToken;

class AuthorizationCode extends \League\OAuth2\Client\Grant\Authorizationcode {


    public function handleResponse($response = array())
    {
        // We need to override this method because our access token is slightly different.
        return new AccessToken($response);
    }
}