<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table      = 'matriculas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'estudiante_id',
        'jornada_id',
        'grupo_id',
        'fecha_matricula',
    ];
}
