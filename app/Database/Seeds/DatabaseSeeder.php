<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

                shell_exec('php spark migrate:refresh');

        $this->call('RolesSeeder');
        $this->call('UsersSeeder');
        $this->call('GradosGruposSeeder');
$this->call('JornadaSeeder');
$this->call('PeriodoSeeder');
        $this->call('MaterialesSeeder');
    }
}
