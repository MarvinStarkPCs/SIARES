<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradosGruposSeeder extends Seeder
{
    public function run()
    {
       $grados = [
    '1°',
    '2°',
    '3°',
    '4°',
    '5°',
    '6°',
    '7°',
    '8°',
    '9°',
    '10°',
    '11°',
];

        foreach ($grados as $grado) {
            // Insertar grado
            $this->db->table('grados')->insert([
                'nombre'     => $grado,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $gradoId = $this->db->insertID(); // ID del grado recién creado

            // Insertar 10 grupos para cada grado
            for ($i = 1; $i <= 4; $i++) {
                $this->db->table('grupos')->insert([
                    'nombre'     =>  $i,
                    'grado_id'   => $gradoId,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
