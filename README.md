# Battle.net provider for league/oauth2-client

This is a package to integrate Battle.net authentication with the OAuth2 client library by
[The League of Extraordinary Packages](https://github.com/thephpleague/oauth2-client).

Currently integrated with OAuth to pull profiles from SC2 & WoW. If Diablo players submit
a PR, I'd be happy to merge in changes and be inclusive :) Thanks to [@TheJaydox](https://github.com/TheJaydox)
for submitting a WoW pull!

To install, use composer:

```bash
composer require depotwarehouse/oauth2-bnet
```

Usage is the same as the league's OAuth client, using `\Depotwarehouse\OAuth2\Client\Provider\SC2Provider` or
`\Depotwarehouse\OAuth2\Client\Provider\WowProvider` as the provider.
For example:

```php
$provider = new \Depotwarehouse\OAuth2\Client\Provider\SC2Provider([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri",
    'region' => 'eu'
]);
```
As you can see you may pass an optional 'region' argument to the constructor, and it will then query on that region
instead. If you omit the region argument, then it will default to the `us` region.

```php
if (isset($_GET['code']) && $_GET['code']) {
    $token = $this->provider->getAccessToken("authorization_code", [
        'code' => $_GET['code']
    ]);

    // Returns an instance of Depotwarehouse\OAuth2\Client\Entity\SC2User
    $user = $this->provider->getResourceOwner($token);
```

To get to know the data available on an `SC2User` simply inspect the public properties of the class, as they show all the
available data that has been returned.

Alternatively, for WoW you can use `\Depotwarehouse\OAuth2\Client\Provider\WowProvider` and it will return an object of
type `WowUser`. A `WowUser` simply contains a public `$data` property with an array of character objects as `stdClass`s.

There's an example JSON representation below, but I suggest you use inspection to figure out more closely what you're
looking for (and maybe send a pull request with the properties you find!)

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
