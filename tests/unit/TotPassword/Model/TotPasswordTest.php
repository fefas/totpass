<?php

namespace Fefas\TotPass\TotPassword\Model;

use DateTime;
use PHPUnit\Framework\TestCase;

class TotPasswordTest extends TestCase
{
    /**
     * @test
     */
    public function useAlgorithmToRetrivePasswordAtAGivenDateTime()
    {
        $datetime = new DateTime('2016-02-01 08:00:00');
        $expectedPassword = '567123';
        $totPasswordAlgorithmMock = $this->totPasswordAlgorithmMock(
            $datetime->format('U'),
            $expectedPassword
        );
        $totPassword = new TotPassword('sample-name', $totPasswordAlgorithmMock);

        $generatedPassword = $totPassword->retrieveAt($datetime);

        $this->assertSame($expectedPassword, $generatedPassword);
    }

    private function totPasswordAlgorithmMock(
        int $expectedSeed,
        string $fixedPassword
    ): TotPasswordAlgorithm {
        $totPasswordAlgorithmMock = $this->createMock(TotPasswordAlgorithm::class);
        $totPasswordAlgorithmMock
            ->method('generate')
            ->with($this->equalTo($expectedSeed))
            ->willReturn($fixedPassword);

        return $totPasswordAlgorithmMock;
    }
}
