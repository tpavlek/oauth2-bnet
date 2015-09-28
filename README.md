# Battle.net provider for league/oauth2-client

This is a package to integrate Battle.net authentication with the OAuth2 client library by
[The League of Extraordinary Packages](https://github.com/thephpleague/oauth2-client).

Currently integrated with OAuth to pull profiles from SC2 & WoW. If Diablo players submit
a PR, I'd be happy to merge in changes and be inclusive :)

To install, use composer:

```bash
composer require depotwarehouse/oauth2-bnet
```

Usage is the same as the league's OAuth client (Region:US & Game:SC2 as defaults), using `\Depotwarehouse\OAuth2\Client\Provider\BattleNet` as the provider.
For example:

```php
$provider = new \Depotwarehouse\OAuth2\Client\Provider\BattleNet([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri"
]);

// If looking to change from defaults
$provider->settings(array(
	'region' => 'us', // Default = us
	'game' => 'sc2' // Default = sc2
));

if (isset($_GET['code']) && $_GET['code']) {
    $token = $this->provider->getAccessToken("authorizaton_code", [
        'code' => $_GET['code']
    ]);

    // Returns an instance of Depotwarehouse\OAuth2\Client\Entity\BattleNetUser
    $user = $this->provider->getResourceOwner($token);

    // $user->data[#]['key'];
```

Example output (converted to JSON for display):
```json
// $user->
{
    "data": [
    {
        "name": "Thejaydox",
        "realm": "Stormreaver",
        "battlegroup": "Rampage",
        "class": 4,
        "race": 10,
        "gender": 1,
        "level": 88,
        "achievementPoints": 16330,
        "thumbnail": "stormreaver\/230\/89809638-avatar.jpg",
        "spec": {
            "name": "Assassination",
            "role": "DPS",
            "backgroundImage": "bg-rogue-assassination",
            "icon": "ability_rogue_eviscerate",
            "description": "A deadly master of poisons who dispatches victims with vicious dagger strikes.",
            "order": 0
        },
        "guild": "Honnouji Academy",
        "guildRealm": "Stormreaver",
        "lastModified": 1421373438000
    },
    ]
}
```

Testing
--------

There is a simple scaffold for an integration test in `test/`. Unfortunately, it is nontrivial to use, as
the Battle.net OAuth service *requires* the use of `https` for all authentication traffic (but that does bode well for 
security!)

Included is an SSL certificate as well as a private key for use with the domain `oauth2-bnet.local`. Simply add `oauth2-bnet.local`
to your `/etc/hosts` as an alias for localhost, and configure apache to serve the files in `test/` using the certificate
and key files in `test/ssl`.

Next edit `test/config.php` to fill in the values for your own client key from https://dev.battle.net and you should be able
to run the test. The page should redirect you to log in, and then dump your user values to screen if successful.
