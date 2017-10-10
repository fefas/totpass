<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $secret;
    private $refreshPeriod;
    private $registeredAt;

    public function __construct(
        string $name,
        string $secret,
        int $refreshPeriod,
        DateTime $registeredAt
    ) {
        $this->name = $name;
        $this->secret = $secret;
        $this->refreshPeriod = $refreshPeriod;
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

    public function refreshPeriod(): int
    {
        return $this->refreshPeriod;
    }

    public function registeredAt(): DateTime
    {
        return $this->registeredAt;
    }
}
