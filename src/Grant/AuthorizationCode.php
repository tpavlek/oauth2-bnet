<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 11/09/14
 * Time: 15:12
 */

namespace Depotwarehouse\OAuth2\Client\Grant;


use League\OAuth2\Client\Token\AccessToken;

class AuthorizationCode extends \League\OAuth2\Client\Grant\AuthorizationCode {


    public function handleResponse($response = array())
    {
        // We need to set the accountId as uid, to be compatible with the league oauth2 implementation.
        if (isset($response['accountId']) and $response['accountId']) {
            $response['uid'] = $response['accountId'];
        }
        return new AccessToken($response);
    }
}