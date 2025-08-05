<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReciclajesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'periodo_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'material_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'matricula_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'peso_total' => [
                'type' => 'FLOAT',
                'null' => false,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('material_id', 'materiales', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('matricula_id', 'matriculas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('periodo_id', 'periodos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('reciclajes');
    }

    public function down()
    {
        $this->forge->dropTable('reciclajes');
    }
}
