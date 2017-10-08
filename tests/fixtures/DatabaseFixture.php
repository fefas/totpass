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
            INSERT INTO tot_password (name, created_at) VALUES (:name, :createdAt)
        ');

        foreach ($totPasswords as $totPassword) {
            $pdoStatement->execute([
                'name' => $totPassword->name(),
                'createdAt' => $totPassword->createdAt()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
