<?php

namespace Fefas\TotPass\TotPassword\Infrastructure;

use PDO;
use DateTime;
use Fefas\TotPass\TotPassword\Model\TotPassword;
use Fefas\TotPass\TotPassword\Model\TotPasswordRepository;

class PdoTotPasswordRepository implements TotPasswordRepository
{
    private $pdoDatabaseConnection;

    public function __construct(PDO $pdoDatabaseConnection)
    {
        $this->pdoDatabaseConnection = $pdoDatabaseConnection;
    }

    public function findAll(): array
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            SELECT * FROM tot_password
        ');

        $pdoStatement->execute();
        $totPasswordsRows = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $totPasswords = [];
        foreach ($totPasswordsRows as $totPasswordRow) {
            $totPasswordAlgorithm = TotPasswordAlgorithm::create(
                $totPasswordRow['secret'],
                $totPasswordRow['refresh_period']
            );

            $totPasswords[] = new TotPassword(
                $totPasswordRow['name'],
                $totPasswordAlgorithm
            );
        }

        return $totPasswords;
    }

    public function register(TotPassword $totPassword): void
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            INSERT INTO tot_password (name, secret, refresh_period)
                VALUES (:name, :secret, :refreshPeriod)
        ');

        $pdoStatement->execute([
            'name' => $totPassword->name(),
            'secret' => $totPassword->secret(),
            'refreshPeriod' => $totPassword->refreshPeriod()
        ]);
    }
}
