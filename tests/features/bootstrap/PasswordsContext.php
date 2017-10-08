<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Fefas\Totp\DatabaseFixture;
use Fefas\Totp\TotpPassword\Model\TotpPassword;

class PasswordsContext implements Context
{
    private $databaseFixture;

    public function __construct()
    {
        $pdoDatabaseConnection = new PDO('sqlite:totp.sqlite');

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
     * @Transform table:Password,Created At
     */
    public function transformTotpPasswords(TableNode $totpPasswordsTable)
    {
        $totpPasswords = [];
        foreach ($totpPasswordsTable as $totpPasswordRow) {
            $totpPasswordName = $totpPasswordRow['Password'];
            $totpPasswordCreatedAt = new DateTime($totpPasswordRow['Created At']);

            $totpPasswords[] = new TotpPassword($totpPasswordName, $totpPasswordCreatedAt);
        }

        return $totpPasswords;
    }

    /**
     * @Given the following time-based one-time passwords were registered:
     */
    public function theFollowingTimeBasedOneTimePasswordsWereRegistered(array $totpPasswords)
    {
        $this->databaseFixture->insertTotpPasswords($totpPasswords);
    }
}
