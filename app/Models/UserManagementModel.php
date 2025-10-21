<?php
namespace App\Models;
use CodeIgniter\Model;

class UserManagementModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
protected $allowedFields = [
    'name',
    'last_name',
    'documento',
    'email',
    'telefono',
    'direccion',
    'genero',
    'fecha_nacimiento',
    'estado',
    'password',
    'role_id',
    'created_at',
    'updated_at'
];
    protected $returnType = 'array';
    protected $useTimestamps = false;
 protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // Método para obtener usuarios sin la contraseña
    public function getUsers($id = null)
    {
        log_message('info', 'UserManagementModel: getUsers called with id: ' . $id);
        $query = $this->select('users.id, users.name, users.last_name, users.documento, users.email, 
                                users.telefono, users.direccion, users.genero, users.fecha_nacimiento, 
                                users.estado, users.role_id, users.created_at, users.updated_at, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id');

        if ($id !== null) {
            $query->where('users.id', $id);
            log_message('info', 'UserManagementModel: Filtering by user ID: ' . $id);
            log_message('info', 'UserManagementModel: Query executed: ' . $query->getLastQuery());
            return $query->first(); // Retorna solo un usuario si hay filtro
        }

        return $query->findAll(); // Retorna todos los usuarios si no hay filtro
    }

    public function getUserByDocumento($documento)
    {
        return $this->where('documento', $documento)->first();
    }

    public function getUserById($id)
    {
        return $this->where('id', $id)->first();
    }

 public function getMatriculaByEstudiante($estudianteId)
    {
        return $this->db->table('matriculas m')
            ->select('
                m.id AS matricula_id,
                m.fecha_matricula,
                u.id AS estudiante_id,
                u.name AS estudiante,
                u.last_name AS last_name,
                u.documento,
                u.email,
                u.telefono,
                u.direccion,
                u.genero,
               r.name as role,
                u.fecha_nacimiento,
                u.estado,
                gra.nombre AS grado,
                gru.nombre AS grupo,
                j.nombre AS jornada
            ')
            ->join('users u', 'm.estudiante_id = u.id')
            ->join('grupos gru', 'm.grupo_id = gru.id')
            ->join('grados gra', 'gru.grado_id = gra.id')
            ->join('jornadas j', 'm.jornada_id = j.id')
            ->join('roles r', 'u.role_id = r.id')
            ->get()
            ->getRow(); // devuelve un solo registro
    }

    public function getMatriculaByDocumento($documento)
{
    return $this->db->table('matriculas m')
        ->select('
            m.id AS matricula_id,
            m.fecha_matricula,
            u.id AS estudiante_id,
            u.name AS estudiante,
            u.last_name AS last_name,
            u.documento,
            u.email,
            u.telefono,
            u.direccion,
            u.genero,
            r.name as role,
            u.fecha_nacimiento,
            u.estado,
            gra.nombre AS grado,
            gru.nombre AS grupo,
            j.nombre AS jornada
        ')
        ->join('users u', 'm.estudiante_id = u.id')
        ->join('grupos gru', 'm.grupo_id = gru.id')
        ->join('grados gra', 'gru.grado_id = gra.id')
        ->join('jornadas j', 'm.jornada_id = j.id')
        ->join('roles r', 'u.role_id = r.id')
        ->where('u.documento', $documento)   // 👈 buscar por documento
        ->get()
        ->getResultArray(); // devuelve un solo registro
}



    public function getUsersWithRoles($roleId = null)
    {
        $builder = $this->select('users.*, roles.name as role_name')
                        ->join('roles', 'roles.id = users.role_id');

        if (!is_null($roleId)) {
            $builder->where('users.role_id', $roleId);
        }

        return $builder->findAll();
    }

}

