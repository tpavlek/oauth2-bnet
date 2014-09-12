# Battle.net provider for league/oauth2-client

This is a package to integrate Battle.net authentication with the OAuth2 client library by
[The League of Extraordinary Packages](https://github.com/thephpleague/oauth2-client).

To install, use composer:

```json
{
    "require": {
        "depotwarehouse/oauth2-bnet": 1.0.*
    }
}
```

Usage is the same as the league's OAuth client, using `\Depotwarehouse\OAuth2\Client\Provider\BattleNet` as the provider
and `\Depotwarehouse\OAuth2\Client\Grant\AuthenticationCode`. For example:

```php
$provider = new \Depotwarehouse\OAuth2\Client\Provider\BattleNet([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri"
]);


if (isset($_GET['code']) && $_GET['code']) {
    $grant = new \Depotwarehouse\OAuth2\Client\Grant\AuthorizationCode;

    $token = $this->provider->getAccessToken($grant, [
        'code' => $_GET['code']
    ]);

    $user = $this->provider->getUserDetails($token);

    // $user->uid = [ Battle.net account ID ]
    // $user->nickname = [ Battle.net Battletag ]
}
```