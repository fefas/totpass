<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Fefas\TotPass\DatabaseFixture;
use Fefas\TotPass\TotPassword\Infrastructure\TotPasswordAlgorithm;
use Fefas\TotPass\TotPassword\Model\TotPassword;

class TotPasswordContext implements Context
{
    private $databaseFixture;

    public function __construct()
    {
        $pdoDatabaseConnection = new PDO('sqlite:totpass.sqlite');

        $this->databaseFixture = new DatabaseFixture($pdoDatabaseConnection);
    }

    /**
     * @beforeScenario
     */
    public function beforeScenario()
    {
        $this->databaseFixture->purgeDatabase();
    }

    /**
     * @afterScenario
     */
    public function afterScenario()
    {
        $this->databaseFixture->purgeDatabase();
    }

    /**
     * @Transform table:TOTP Name,Secret,Refresh Period
     */
    public function transformTotps(TableNode $totPasswordsTable)
    {
        $totPasswords = [];
        foreach ($totPasswordsTable as $totPasswordRow) {
            $name = $totPasswordRow['TOTP Name'];
            $secret = $totPasswordRow['Secret'];
            $refreshPeriod = $totPasswordRow['Refresh Period'];

            $totPasswordAlgorithm = TotPasswordAlgorithm::create(
                $secret,
                $refreshPeriod
            );

            $totPasswords[] = new TotPassword($name, $totPasswordAlgorithm);
        }

        return $totPasswords;
    }

    /**
     * @Given the following time-based one-time passwords were registered:
     */
    public function theFollowingTotPasswordsWereRegistered(array $totPasswords)
    {
        $this->databaseFixture->insertTotPasswords($totPasswords);
    }

    /**
     * @Then the following time-based one-time passwords should be registered:
     */
    public function theFollowingTotPasswordsShouldBeRegistered(
        array $expectedTotPasswords
    ) {
        foreach ($expectedTotPasswords as $expectedTotPassword) {
            $registeredTotPassword = $this->databaseFixture->retrieveTotPasswordByName(
                $expectedTotPassword->name()
            );

            assertEquals($expectedTotPassword, $registeredTotPassword);
        }
    }
}
