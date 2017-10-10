<?php

namespace Fefas\TotPass\TotPassword\Infrastructure;

use PDO;
use DateTime;
use PHPUnit\Framework\TestCase;
use Fefas\TotPass\DatabaseFixture;
use Fefas\TotPass\TotPassword\Model\TotPassword;

class PdoTotPasswordRepositoryTest extends TestCase
{
    private $databaseFixture;
    private $totPasswordRepository;

    protected function setUp()
    {
        $pdoDatabaseConnection = new PDO('sqlite:'.__DIR__.'/../../../../totpass.sqlite');

        $this->databaseFixture = new DatabaseFixture($pdoDatabaseConnection);
        $this->pdoTotPasswordRepository = new PdoTotPasswordRepository($pdoDatabaseConnection);

        $this->databaseFixture->purgeDatabase();
    }

    protected function tearDown()
    {
        $this->databaseFixture->purgeDatabase();
    }

    /**
     * @test
     */
    public function shouldReturnArrayWithAllTotPasswordsWhenFindAllIsCalled()
    {
        $expectedTotPasswords = [
            new TotPassword('dropbox', 'SECRET', new DateTime('2017-03-14 10:12:34')),
            new TotPassword('google.fefas', 'SECRET', new DateTime('2016-08-22 22:02:31')),
        ];
        $this->databaseFixture->insertTotPasswords($expectedTotPasswords);

        $totPasswords = $this->pdoTotPasswordRepository->findAll();

        $this->assertEquals($expectedTotPasswords, $totPasswords);
    }

    /**
     * @test
     */
    public function shouldRegisterANewTotPassword()
    {
        $totPasswordToRegister = new TotPassword(
            'dropbox',
            'SECRET',
            new DateTime('2017-03-14 10:12:34')
        );

        $this->pdoTotPasswordRepository->register($totPasswordToRegister);

        $registeredTotPassword = $this->databaseFixture->retrieveTotPasswordByName(
            $totPasswordToRegister->name()
        );
        $this->assertEquals($totPasswordToRegister, $registeredTotPassword);
    }
}
