<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

interface TotPasswordAlgorithm
{
    public function generate(int $seed): string;
    public function secret(): string;
    public function refreshPeriod(): int;
    public static function create(string $secret, int $refreshPeriod): self;
}
