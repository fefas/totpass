<?php


use Phinx\Migration\AbstractMigration;

class CreateTableTotPassword extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('tot_password', [
            'id' => false,
            'primary_key' => 'name',
        ]);

        $table->addColumn('name', 'string')
              ->addColumn('created_at', 'datetime')
              ->create();
    }
}
