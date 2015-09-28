<?php

namespace Depotwarehouse\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class BattleNetUser implements ResourceOwnerInterface
{

    /**
    * @var data[]
    * For WoW or SC2 API data
    */

    public $data = array();

    public function __construct(array $attributes, $region)
    {
        // Detect if === SC2
        if (isset($attributes[0]['portrait'])){

            $this->data = $attributes;

            for ($i = 0; $i < count($this->data); $i++) {
                $this->data[$i]['profile_url'] = "http://{$region}.battle.net/data/en{$this->data[$i]['profilePath']}";

                // Portrait URL links to a sheet of portraits, so we construct the proper one.
                if (isset($this->data[$i]['portrait'])) {
                    $this->data[$i]['portrait_url'] = substr($this->data[$i]['portrait']->url, 0, strpos($this->data[$i]['portrait']->url, '-'))
                        . '-' . $this->data[$i]['portrait']->offset . ".jpg";
                }
            }

        }
        else{
            $this->data = $attributes;
        }
    }

    public function toArray()
    {
        return [$this->data];
    }

    public function getId()
    {
        return $this->data['id'];
    }
}
