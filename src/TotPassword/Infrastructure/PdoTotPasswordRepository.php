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
            $totPasswords[] = new TotPassword(
                $totPasswordRow['name'],
                new DateTime($totPasswordRow['registered_at'])
            );
        }

        return $totPasswords;
    }
}
