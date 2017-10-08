<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $createdAt;

    public function __construct(string $name, DateTime $createdAt)
    {
        $this->name = $name;
        $this->createdAt = $createdAt;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
