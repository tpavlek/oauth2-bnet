# Battle.net provider for league/oauth2-client

This is a package to integrate Battle.net authentication with the OAuth2 client library by
[The League of Extraordinary Packages](https://github.com/thephpleague/oauth2-client).

As an SC2 developer, it is currently only integrated with OAuth and pulls SC2 Profiles. If WoW or Diablo players submit
a PR, I'd be happy to merge in changes and be inclusive :)

To install, use composer:

```bash
composer require depotwarehouse/oauth2-bnet
```

Usage is the same as the league's OAuth client, using `\Depotwarehouse\OAuth2\Client\Provider\BattleNet` as the provider.
For example:

```php
$provider = new \Depotwarehouse\OAuth2\Client\Provider\BattleNet([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri"
]);


if (isset($_GET['code']) && $_GET['code']) {
    $token = $this->provider->getAccessToken("authorizaton_code", [
        'code' => $_GET['code']
    ]);

    // Returns an instance of Depotwarehouse\OAuth2\Client\Entity\BattleNetUser
    $user = $this->provider->getUserDetails($token);

    // $user->id = [ SC2 Account ID ]
    // $user->realm = [ Integer Account Realm ]
    // $user->name = [ username#char_code ]
    // $user->display_name = [ username ]
    // $user->clan_name = [ Clan Name or null ]
    // $user->clan_tag = [ Clan Tag or null ]
    // $user->profile_url = [ Full URL to profile on battle.net ]
}
```
