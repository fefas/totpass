<?php


use Phinx\Migration\AbstractMigration;

class CreateTableTotpPassword extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('totp_password', [
            'id' => false,
            'primary_key' => 'name',
        ]);

        $table->addColumn('name', 'string')
              ->addColumn('created_at', 'datetime')
              ->create();
    }
}
