<?php

namespace Fefas\TotPass;

use PDO;
use DateTime;
use Fefas\TotPass\TotPassword\Model\TotPassword;

class DatabaseFixture
{
    private $pdoDatabaseConnection;

    public function __construct(PDO $pdoDatabaseConnection)
    {
        $this->pdoDatabaseConnection = $pdoDatabaseConnection;
    }

    public function purgeDatabase()
    {
        $this->pdoDatabaseConnection->exec('DELETE FROM tot_password');
    }

    public function insertTotPasswords(array $totPasswords)
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            INSERT INTO tot_password (name, secret, registered_at) VALUES
                (:name, :secret, :registeredAt)
        ');

        foreach ($totPasswords as $totPassword) {
            $pdoStatement->execute([
                'name' => $totPassword->name(),
                'secret' => $totPassword->secret(),
                'registeredAt' => $totPassword->registeredAt()->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function retrieveTotPasswordByName(string $name): ?TotPassword
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            SELECT * FROM tot_password WHERE name = :name
        ');

        $pdoStatement->execute([
            'name' => $name
        ]);
        $totPasswordRow = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        if (0 === count($totPasswordRow)) {
            return null;
        }
        $totPasswordRow = $totPasswordRow[0];

        return new TotPassword(
            $totPasswordRow['name'],
            $totPasswordRow['secret'],
            new DateTime($totPasswordRow['registered_at'])
        );
    }
}
