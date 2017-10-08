<?php

namespace Fefas\Totp;

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
        $this->pdoDatabaseConnection->exec('DELETE FROM totp_password');
    }

    public function insertTotpPasswords(array $totpPasswords)
    {
        $pdoStatement = $this->pdoDatabaseConnection->prepare('
            INSERT INTO totp_password (name, created_at) VALUES (:name, :createdAt)
        ');

        foreach ($totpPasswords as $totpPassword) {
            $pdoStatement->execute([
                'name' => $totpPassword->name(),
                'createdAt' => $totpPassword->createdAt()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
