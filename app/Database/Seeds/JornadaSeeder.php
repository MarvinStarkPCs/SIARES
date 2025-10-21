<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JornadaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Mañana'],
            ['nombre' => 'Tarde'],
            ['nombre' => 'Noche'],
        ];

        $this->db->table('jornadas')->insertBatch($data);
    }
}
