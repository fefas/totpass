<?php

namespace Fefas\Totp\TotpPassword\Infrastructure;

use PDO;
use DateTime;
use PHPUnit\Framework\TestCase;
use Fefas\Totp\DatabaseFixture;
use Fefas\Totp\TotpPassword\Model\TotpPassword;

class PdoTotpPasswordRepositoryTest extends TestCase
{
    private $databaseFixture;
    private $totpPasswordRepository;

    protected function setUp()
    {
        $pdoDatabaseConnection = new PDO('sqlite:'.__DIR__.'/../../../../totp.sqlite');

        $this->databaseFixture = new DatabaseFixture($pdoDatabaseConnection);
        $this->pdoTotpPasswordRepository = new PdoTotpPasswordRepository($pdoDatabaseConnection);

        $this->databaseFixture->purgeDatabase();
    }

    protected function tearDown()
    {
        $this->databaseFixture->purgeDatabase();
    }

    /**
     * @test
     */
    public function shouldReturnArrayWithAllTotpPasswordsWhenFindAllIsCalled()
    {
        $expectedTotpPasswords = [
            new TotpPassword('dropbox', new DateTime('2017-03-14 10:12:34')),
            new TotpPassword('google.fefas', new DateTime('2016-08-22 22:02:31')),
        ];
        $this->databaseFixture->insertTotpPasswords($expectedTotpPasswords);

        $totpPasswords = $this->pdoTotpPasswordRepository->findAll();

        $this->assertEquals($expectedTotpPasswords, $totpPasswords);
    }
}
