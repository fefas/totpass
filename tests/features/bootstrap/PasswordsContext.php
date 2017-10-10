<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Fefas\TotPass\DatabaseFixture;
use Fefas\TotPass\TotPassword\Model\TotPassword;

class PasswordsContext implements Context
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
     * @Transform table:TOT Password,Registered At
     */
    public function transformTotps(TableNode $totPasswordsTable)
    {
        $totPasswords = [];
        foreach ($totPasswordsTable as $totPasswordRow) {
            $name = $totPasswordRow['TOT Password'];
            $registeredAt = new DateTime($totPasswordRow['Registered At'] ?? null);

            $totPasswords[] = new TotPassword($name, $registeredAt);
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
}
