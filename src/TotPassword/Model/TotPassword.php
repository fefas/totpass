<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

class TotPassword
{
    private $name;
    private $algorithm;

    public function __construct(string $name, TotPasswordAlgorithm $algorithm)
    {
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function retrieveAt(DateTime $datetime): string
    {
        $timestamp = (int) $datetime->format('U');

        return $this->algorithm->generate($timestamp);
    }

    public function secret(): string
    {
        return $this->algorithm->secret();
    }

    public function refreshPeriod(): int
    {
        return $this->algorithm->refreshPeriod();
    }
}
