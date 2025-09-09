<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradosGruposSeeder extends Seeder
{
    public function run()
    {
       $grados = [
    'Primero',
    'Segundo',
    'Tercero',
    'Cuarto',
    'Quinto',
    'Sexto',
    'Séptimo',
    'Octavo',
    'Noveno',
    'Décimo',
    'Undécimo',
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
