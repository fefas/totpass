<?php

namespace Fefas\TotPass;

use PDO;

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
            INSERT INTO tot_password (name, registered_at) VALUES
                (:name, :registeredAt)
        ');

        foreach ($totPasswords as $totPassword) {
            $pdoStatement->execute([
                'name' => $totPassword->name(),
                'registeredAt' => $totPassword->registeredAt()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
