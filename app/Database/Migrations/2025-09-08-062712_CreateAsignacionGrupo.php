<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsignacionGrupo extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'profesor_id' => [
            'type'     => 'INT',
            'unsigned' => true,
        ],
         'grupo_id' => [
            'type'     => 'INT',
            'unsigned' => true, // 🔴 esto es fundamental
        ],
        'jornada_id' => [
            'type'     => 'INT',
            'unsigned' => true,
        ],  
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('grupo_id', 'grupos', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('profesor_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('jornada_id', 'jornadas', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('grupos_asignacion');
}


    public function down()
    {
        $this->forge->dropTable('grupos_asignacion');
    }
}
