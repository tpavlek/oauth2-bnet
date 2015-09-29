<?php

namespace Depotwarehouse\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class WowUser implements ResourceOwnerInterface
{

    /**
     * An array representation of the data received about the WoW character.
     * @var array $data
     */

    public $data;

    public function __construct(array $attributes, $region)
    {
        $this->data = $attributes;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getId()
    {
        return $this->data[0]['id'];
    }
}
