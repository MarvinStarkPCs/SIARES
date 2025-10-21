<?php

namespace App\Models;

use CodeIgniter\Model;

class GruposAsignacionModel extends Model
{
    protected $table      = 'grupos_asignacion';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['profesor_id', 'grupo_id',  'jornada_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

public function getGruposAsignadosPorProfesor()
{
    $db = \Config\Database::connect();

    $sql = "
     SELECT 
            gr.id AS id_grupo,
            CONCAT(g.nombre, '  -  ', gr.nombre, '  -  ',j.nombre) AS grados_grupos
        FROM grupos_asignacion ga
        INNER JOIN grupos gr ON ga.grupo_id = gr.id
        INNER JOIN grados g ON gr.grado_id = g.id
        INNER JOIN jornadas j ON ga.jornada_id = j.id
    ";

    return $db->query($sql)->getResultArray();
}
public function getGrupos()
{
    $db = \Config\Database::connect();

    $sql = "
    SELECT 
        gu.id AS id_grupo,
    CONCAT(ga.nombre, ' - ', gu.nombre) AS grados_grupos
FROM grupos gu
INNER JOIN grados ga ON gu.grado_id = ga.id;

    ";

    return $db->query($sql)->getResultArray();
}

    public function getProfesorConGrupos($documento)
    {
        $db = \Config\Database::connect();

    $sql = "
    SELECT 
    u.id AS profesor_id,
    u.documento,
    u.name AS nombre_profesor,
    u.email,
    u.telefono,
    GROUP_CONCAT(
        CONCAT('Grado ', gra.nombre, ' - Grupo ', g.nombre, ' - Jornada ', j.nombre)
        ORDER BY g.id 
        SEPARATOR ', '
    ) AS grupos_asignados
FROM grupos_asignacion ga
INNER JOIN users u ON ga.profesor_id = u.id
INNER JOIN grupos g ON ga.grupo_id = g.id
INNER JOIN grados gra ON g.grado_id = gra.id
INNER JOIN jornadas j ON ga.jornada_id = j.id
WHERE u.role_id = 3
AND u.documento = ?
GROUP BY u.id, u.name, u.documento, u.email, u.telefono;

    ";

    $query = $db->query($sql, [$documento]);
    return $query->getResultArray();
    }
}
