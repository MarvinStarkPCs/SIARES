<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGruposTable extends Migration
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
        'grado_id' => [
            'type'     => 'INT',
            'unsigned' => true, // 🔴 ¡Esto es clave!
        ],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('grado_id', 'grados', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('grupos');
}


    public function down()
    {
        $this->forge->dropTable('grupos');
    }
}

