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
        'grupo_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


public function getEstudiantesPorGrupo(int $grupoId): array
{
    return $this->select("
            matriculas.id AS matricula_id,
            u.id AS estudiante_id,
            u.name AS nombre_estudiante,
            u.documento,
            u.email,
            u.telefono,
            gr.nombre AS grupo,
            g.nombre AS grado,
            j.nombre AS jornada
        ")
        ->join('users u', 'matriculas.estudiante_id = u.id')
        ->join('grupos gr', 'matriculas.grupo_id = gr.id')
        ->join('grados g', 'gr.grado_id = g.id')
        ->join('jornadas j', 'matriculas.jornada_id = j.id')
        ->where('matriculas.grupo_id', $grupoId)
        ->where('YEAR(matriculas.created_at)', date('Y'))
        ->where('u.role_id', 2) // Solo estudiantes
        ->orderBy('u.name', 'ASC')
        ->findAll();
}

}
