<?php

class AuthorizationCodeTest extends PHPUnit_Framework_TestCase {

    public function testHandleResponse() {
        $authCode = new \Depotwarehouse\OAuth2\Client\Grant\AuthorizationCode();

        $response = [
            'access_token' => 'mock_access_token',
            'accountId' => 12345678,
            'expires_in' => 2591999,
            'scope' => 'wow.profile sc2.profile',
            'token_type' => "bearer",
            'success' => true
        ];

        $token = $authCode->handleResponse($response);

        $this->assertInstanceOf('League\OAuth2\Client\Token\AccessToken', $token);
        $this->assertAttributeEquals($response['accountId'], 'uid', $token);
    }

} 