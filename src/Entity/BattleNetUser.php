<?php

namespace Depotwarehouse\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class BattleNetUser implements ResourceOwnerInterface
{

    /**
    * @var APIdata[]
    * For WoW or SC2 API data
    */

    public $APIdata = array();

    public function __construct(array $attributes, $region)
    {
        // Detect if === SC2
        if (isset($attributes[0]['portrait'])){

            $this->APIdata = $attributes;

            for ($i = 0; $i < count($this->APIdata); $i++) {
                $this->APIdata[$i]['profile_url'] = "http://{$region}.battle.net/APIdata/en{$this->APIdata[$i]['profilePath']}";

                // Portrait URL links to a sheet of portraits, so we construct the proper one.
                if (isset($this->APIdata[$i]['portrait'])) {
                    $this->APIdata[$i]['portrait_url'] = substr($this->APIdata[$i]['portrait']->url, 0, strpos($this->APIdata[$i]['portrait']->url, '-'))
                        . '-' . $this->APIdata[$i]['portrait']->offset . ".jpg";
                }
            }

        }
        else{
            $this->APIdata = $attributes;
        }
    }

    public function toArray()
    {
        return $this->APIdata;
    }

    public function getId()
    {
        return $this->APIdata['id'];
    }
}
