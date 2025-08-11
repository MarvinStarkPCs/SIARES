<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'       => 'Admin Principal',
                'documento'  => '10000001',
                'email'      => 'admin@siares.com',
                'telefono'   => '3001234567',
                'direccion'  => 'Calle Falsa 123',
                'genero'     => 'M',
                'fecha_nacimiento' => '1990-01-01',
                'estado'     => 'activo',
                'password'   => password_hash('admin123*', PASSWORD_DEFAULT),
                'role_id'    => 1, // Administrador
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Laura Martínez',
                'documento'  => '10000002',
                'email'      => 'laura@siares.com',
                'telefono'   => '3001231234',
                'direccion'  => 'Carrera 10 #20-30',
                'genero'     => 'F',
                'fecha_nacimiento' => '2005-03-15',
                'estado'     => 'activo',
                'password'   => password_hash('laura123*', PASSWORD_DEFAULT),
                'role_id'    => 2, // Estudiante
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
