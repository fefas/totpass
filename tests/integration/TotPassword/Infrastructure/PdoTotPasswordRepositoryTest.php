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

        unset($this->databaseFixture);
        unset($this->pdoTotPasswordRepository);
    }

    /**
     * @test
     */
    public function shouldReturnArrayWithAllTotPasswordsWhenFindAllIsCalled()
    {
        $expectedTotPasswords = [
            new TotPassword('dropbox', TotPasswordAlgorithm::create('SECRET', 30)),
            new TotPassword('google.fefas', TotPasswordAlgorithm::create('SECRET', 45)),
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
            TotPasswordAlgorithm::create('SECRET', 30)
        );

        $this->pdoTotPasswordRepository->register($totPasswordToRegister);

        $registeredTotPassword = $this->databaseFixture->retrieveTotPasswordByName(
            $totPasswordToRegister->name()
        );
        $this->assertEquals($totPasswordToRegister, $registeredTotPassword);
    }
}
