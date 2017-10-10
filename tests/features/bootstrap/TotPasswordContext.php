<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Fefas\TotPass\DatabaseFixture;
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
     * @Transform table:TOT Password,Secret,Refresh Period
     * @Transform table:TOT Password,Secret,Refresh Period,Registered at
     */
    public function transformTotps(TableNode $totPasswordsTable)
    {
        $totPasswords = [];
        foreach ($totPasswordsTable as $totPasswordRow) {
            $name = $totPasswordRow['TOT Password'];
            $secret = $totPasswordRow['Secret'];
            $refreshPeriod = $totPasswordRow['Refresh Period'];
            $registeredAt = new DateTime($totPasswordRow['Registered at'] ?? null);

            $totPasswords[] = new TotPassword(
                $name,
                $secret,
                $refreshPeriod,
                $registeredAt
            );
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

            assertTrue(null !== $registeredTotPassword);
            assertEquals($expectedTotPassword->name(), $registeredTotPassword->name());
            assertEquals($expectedTotPassword->secret(), $registeredTotPassword->secret());
            assertEquals($expectedTotPassword->refreshPeriod(), $registeredTotPassword->refreshPeriod());
        }
    }
}
