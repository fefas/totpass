<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $registeredAt;

    public function __construct(string $name, DateTime $registeredAt)
    {
        $this->name = $name;
        $this->registeredAt = $registeredAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function registeredAt(): DateTime
    {
        return $this->registeredAt;
    }
}
