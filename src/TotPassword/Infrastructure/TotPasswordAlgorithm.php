<?php

namespace Fefas\TotPass\TotPassword\Infrastructure;

use OTPHP\TOTP;
use Fefas\TotPass\TotPassword\Model\TotPasswordAlgorithm as ModelTotPasswordAlgorithm;

class TotPasswordAlgorithm implements ModelTotPasswordAlgorithm
{
    private $thirdTotPasswordAlgorithm;

    public function __construct(TOTP $thirdTotPasswordAlgorithm)
    {
        $this->thirdTotPasswordAlgorithm = $thirdTotPasswordAlgorithm;
    }

    public function generate(int $seed): string
    {
        return $this->thirdTotPasswordAlgorithm->at($seed);
    }

    public function secret(): string
    {
        return $this->thirdTotPasswordAlgorithm->getSecret();
    }

    public function refreshPeriod(): int
    {
        return $this->thirdTotPasswordAlgorithm->getPeriod();
    }

    public function hashFunction(): string
    {
        return $this->thirdTotPasswordAlgorithm->getDigest();
    }

    public function digits(): int
    {
        return $this->thirdTotPasswordAlgorithm->getDigits();
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

        $vendorLibrary = TOTP::create(
            $secret,
            $refreshPeriod,
            $hashFunction,
            $digits
        );

        return new self($vendorLibrary);
    }
}
