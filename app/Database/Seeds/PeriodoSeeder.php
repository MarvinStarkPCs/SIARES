<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Primero'],
            ['nombre' => 'Segundo'],
            ['nombre' => 'Tercero'],
            ['nombre' => 'Cuarto'],
        ];

        $this->db->table('periodos')->insertBatch($data);
    }
}
