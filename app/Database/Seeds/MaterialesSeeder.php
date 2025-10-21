<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Cartón y papel'],
            ['nombre' => 'Botellas'],
            ['nombre' => 'Latas'],
            ['nombre' => 'Bolsas plásticas'],
        ];

        // Inserta múltiples registros en la tabla 'materiales'
        $this->db->table('materiales')->insertBatch($data);
    }
}
