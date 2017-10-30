<?php

namespace Fefas\TotPass\TotPassword\Infrastructure;

use PHPUnit\Framework\TestCase;
use OTPHP\TOTP;
use Fefas\TotPass\TotPassword\Model\TotPasswordAlgorithm as ModelTotPasswordAlgorithm;

class TotPasswordAlgorithmTest extends TestCase
{
    private const SAMPLE_SECRET = 'SECRET';
    private const SAMPLE_TIMESTAMP = 1485936000;

    /**
     * @test
     */
    public function integrateWithTotpVendorLibrary()
    {
        $totpVendorLibrary = TOTP::create(self::SAMPLE_SECRET);
        $totPasswordAlgorithm = new TotPasswordAlgorithm($totpVendorLibrary);

        $secret = $totPasswordAlgorithm->secret();
        $refreshPeriod = $totPasswordAlgorithm->refreshPeriod();
        $hashFunction = $totPasswordAlgorithm->hashFunction();
        $digits = $totPasswordAlgorithm->digits();
        $generatedPassword = $totPasswordAlgorithm->generate(self::SAMPLE_TIMESTAMP);

        $this->assertSame($totpVendorLibrary->getSecret(), $secret);
        $this->assertSame($totpVendorLibrary->getPeriod(), $refreshPeriod);
        $this->assertSame($totpVendorLibrary->getDigest(), $hashFunction);
        $this->assertSame($totpVendorLibrary->getDigits(), $digits);
        $this->assertSame($totpVendorLibrary->at(1485936000), $generatedPassword);
    }

    /**
     * @test
     */
    public function useTheDefaultValuesToTheAlgorithmDefinedInModel()
    {
        $totPasswordAlgorithm = TotPasswordAlgorithm::create(self::SAMPLE_SECRET);

        $refreshPeriod = $totPasswordAlgorithm->refreshPeriod();
        $hashFunction = $totPasswordAlgorithm->hashFunction();
        $digits = $totPasswordAlgorithm->digits();

        $this->assertSame(ModelTotPasswordAlgorithm::DEFAULT_REFRESH_PERIOD, $refreshPeriod);
        $this->assertSame(ModelTotPasswordAlgorithm::DEFAULT_HASH_FUNCTION, $hashFunction);
        $this->assertSame(ModelTotPasswordAlgorithm::DEFAULT_DIGITS, $digits);
    }
}
