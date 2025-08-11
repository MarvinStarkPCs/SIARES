<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradosGruposSeeder extends Seeder
{
    public function run()
    {
        $grados = [
            'Grado 6',
            'Grado 7',
            'Grado 8',
            'Grado 9',
            'Grado 10',
            'Grado 11',
        ];

        foreach ($grados as $grado) {
            // Insertar grado
            $this->db->table('grados')->insert([
                'nombre'     => $grado,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $gradoId = $this->db->insertID(); // ID del grado recién creado

            // Insertar 10 grupos para cada grado
            for ($i = 1; $i <= 10; $i++) {
                $this->db->table('grupos')->insert([
                    'nombre'     => 'Grupo ' . $i,
                    'grado_id'   => $gradoId,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
