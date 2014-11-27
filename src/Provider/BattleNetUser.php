<?php

namespace Depotwarehouse\OAuth2\Client\Provider;

class BattleNetUser {

    public $id;
    public $realm;
    public $name;
    public $display_name;
    public $clan_name;
    public $clan_tag;
    public $profile_url;


    public function __construct(array $attributes) {
        $this->id = $attributes['id'];
        $this->realm = $attributes['realm'];
        $this->name = $attributes['name'];
        $this->display_name = $attributes['displayName'];
        $this->clan_name = (isset($attributes['clanName'])) ? $attributes['clanName'] : null;
        $this->clan_tag = (isset($attributes['clanTag'])) ? $attributes['clanTag'] : null;
        $this->profile_url = "http://us.battle.net/sc2/en{$attributes['profilePath']}";
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'realm' => $this->realm,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'clan_name' => $this->clan_name,
            'clan_tag' => $this->clan_tag,
            'profile_url' => $this->profile_url,
        ];
    }

} 