<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $secret;
    private $refreshPeriod;

    public function __construct(string $name, string $secret, int $refreshPeriod)
    {
        $this->name = $name;
        $this->secret = $secret;
        $this->refreshPeriod = $refreshPeriod;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function secret(): string
    {
        return $this->secret;
    }

    public function refreshPeriod(): int
    {
        return $this->refreshPeriod;
    }
}
