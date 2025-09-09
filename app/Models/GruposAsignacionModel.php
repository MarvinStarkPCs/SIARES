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
        // Obtiene el id del profesor desde la sesión
        $profesorId = session()->get('user_id');
log_message('debug', 'Profesor ID desde sesión: ' . $profesorId);
        if (!$profesorId) {
            return []; // Si no hay usuario en sesión, retornamos vacío
        }

        $db = \Config\Database::connect();

        $sql = "
            SELECT 
                gr.id AS grupo_id,
                CONCAT(g.nombre, ' - ', gr.nombre) AS grado_grupo
            FROM grupos_asignacion ga
            INNER JOIN grupos gr ON ga.grupo_id = gr.id
            INNER JOIN grados g ON gr.grado_id = g.id
            WHERE ga.profesor_id = ?
              AND YEAR(ga.created_at) = YEAR(CURDATE())
            ORDER BY g.id, gr.id
        ";

        return $db->query($sql, [$profesorId])->getResultArray();
    }


    

    
}