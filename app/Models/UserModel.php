<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name', 'documento', 'email', 'telefono', 'direccion',
        'genero', 'fecha_nacimiento', 'estado', 'password', 'role_id',
        'created_at', 'updated_at'
    ];

    protected $useTimestamps = false; // Cámbialo a true si quieres que se gestionen automáticamente

    // Verifica si el usuario existe y la contraseña es correcta
    public function login($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if (!$user) {
            return false; // Usuario no encontrado
        }

        if (password_verify($password, $user['password'])) {
            return $user; // Autenticación exitosa
        }

        return false; // Contraseña incorrecta
    }
}
