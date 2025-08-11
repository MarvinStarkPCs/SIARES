<?php
namespace App\Models;
use CodeIgniter\Model;

class UserManagementModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
protected $allowedFields = [
    'name',
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

    // Método para obtener usuarios sin la contraseña
    public function getUsers($id = null)
    {
        log_message('info', 'UserManagementModel: getUsers called with id: ' . $id);
        $query = $this->select('users.id, users.name, users.documento, users.email, 
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

    public function updateUserBalance($documento, $newBalance)
    {
        return $this->set('balance', $newBalance)
            ->where('documento', $documento)
            ->update();
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

