<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ComboBoxModel;
use APP\Models\MatriculaModel;
use App\Models\UserManagementModel;

class MatriculaController extends BaseController
{
public function index()
{
    $comboModel = new ComboBoxModel(); 
    $userModel = new UserManagementModel(); 
    // Traer solo los usuarios con rol 2 (por ejemplo, estudiantes)
    $estudiantes = $userModel->getUsersWithRoles(2); // Puedes cambiar el 2 si lo deseas
    $data = [
        'estudiantes' => $estudiantes,
        'jornadas'    => $comboModel->getTableData('jornadas') ?? [],
        'grupos'      => $comboModel->getTableData('grupos') ?? [],
    ];

    return view('admin/matricula/matricula', $data);
}


    public function create()
    {
        // Lógica para crear una nueva matrícula
        // Puedes recibir datos del formulario y guardarlos en la base de datos
    }

    public function edit($id)
    {
        // Lógica para editar una matrícula existente
        // Puedes buscar la matrícula por ID y cargar los datos en un formulario
    }

    public function delete($id)
    {
        // Lógica para eliminar una matrícula por ID
    }
}