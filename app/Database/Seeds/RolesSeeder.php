<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Administrador', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Estudiante', 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Docente', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('roles')->insertBatch($roles);
    }
}
