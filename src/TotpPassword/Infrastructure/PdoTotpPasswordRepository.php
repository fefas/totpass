<?php

namespace Fefas\Totp\TotpPassword\Infrastructure;

use PDO;
use DateTime;
use Fefas\Totp\TotpPassword\Model\TotpPassword;
use Fefas\Totp\TotpPassword\Model\TotpPasswordRepository;

class PdoTotpPasswordRepository implements TotpPasswordRepository
{
    private $pdoDatabaseConnection;

    public function __construct(PDO $pdoDatabaseConnection)
    {
        $this->pdoDatabaseConnection = $pdoDatabaseConnection;
    }

    public function findAll(): array
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            SELECT * FROM totp_password
        ');

        $pdoStatement->execute();

        $totpPasswordsRows = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        $totpPasswords = [];
        foreach ($totpPasswordsRows as $totpPasswordRow) {
            $totpPasswords[] = new TotpPassword(
                $totpPasswordRow['name'],
                new DateTime($totpPasswordRow['created_at'])
            );
        }

        return $totpPasswords;
    }
}
