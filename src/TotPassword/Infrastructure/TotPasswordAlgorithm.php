<?php

namespace Fefas\TotPass\TotPassword\Infrastructure;

use OTPHP\TOTP;
use Fefas\TotPass\TotPassword\Model\TotPasswordAlgorithm as ModelTotPasswordAlgorithm;

class TotPasswordAlgorithm implements ModelTotPasswordAlgorithm
{
    private $vendorTotp;

    public function __construct(TOTP $vendorTotp)
    {
        $this->vendorTotp = $vendorTotp;
    }

    public function generate(int $seed): string
    {
        return $this->vendorTotp->at($seed);
    }

    public function secret(): string
    {
        return $this->vendorTotp->getSecret();
    }

    public function refreshPeriod(): int
    {
        return $this->vendorTotp->getPeriod();
    }

    public function hashFunction(): string
    {
        return $this->vendorTotp->getDigest();
    }

    public function digits(): int
    {
        return $this->vendorTotp->getDigits();
    }

    public static function create(
        string $secret,
        int $refreshPeriod = null,
        string $hashFunction = null,
        int $digits = null
    ): ModelTotPasswordAlgorithm {
        if (null === $refreshPeriod) {
            $refreshPeriod = ModelTotPasswordAlgorithm::DEFAULT_REFRESH_PERIOD;
        }

        if (null === $hashFunction) {
            $hashFunction = ModelTotPasswordAlgorithm::DEFAULT_HASH_FUNCTION;
        }

        if (null === $digits) {
            $digits = ModelTotPasswordAlgorithm::DEFAULT_DIGITS;
        }

        $vendorTotp = TOTP::create(
            $secret,
            $refreshPeriod,
            $hashFunction,
            $digits
        );

        return new self($vendorTotp);
    }
}
