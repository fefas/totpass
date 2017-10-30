<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;

interface TotPasswordAlgorithm
{
    public const DEFAULT_REFRESH_PERIOD = 30;
    public const DEFAULT_HASH_FUNCTION = 'sha1';
    public const DEFAULT_DIGITS = 6;

    public function generate(int $seed): string;
    public function secret(): string;
    public function refreshPeriod(): int;
    public function hashFunction(): string;
    public function digits(): int;

    public static function create(
        string $secret,
        int $refreshPeriod = null,
        string $hashFunction = null,
        int $digits = null
    ): self;
}
