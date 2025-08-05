<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJornadasTable extends Migration
{
  
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'nombre' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
        ],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('jornadas');
}

    public function down()
    {
        $this->forge->dropTable('jornadas');
    }
}
