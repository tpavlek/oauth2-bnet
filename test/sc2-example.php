<?php

require '../vendor/autoload.php';
require 'config.php';

$provider = new \Depotwarehouse\OAuth2\Client\Provider\SC2Provider(
    $config
);


if (isset($_GET['code']) && $_GET['code']) {
    $token = $provider->getAccessToken("authorization_code", [
        'code' => $_GET['code']
    ]);

    $user = $provider->getResourceOwner($token);
    echo '<pre>' . var_export($user, true) . '</pre>';


} else {
    header('Location: ' . $provider->getAuthorizationUrl());
}
