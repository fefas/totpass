<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $secret;
    private $registeredAt;

    public function __construct(string $name, string $secret, DateTime $registeredAt)
    {
        $this->name = $name;
        $this->secret = $secret;
        $this->registeredAt = $registeredAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function secret(): string
    {
        return $this->secret;
    }

    public function registeredAt(): DateTime
    {
        return $this->registeredAt;
    }
}
