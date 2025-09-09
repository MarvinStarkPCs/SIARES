<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ComboBoxModel;
use App\Models\MatriculaModel;
use App\Models\UserManagementModel;

class MatriculaController extends BaseController
{


public function index()
{  
      $comboModel = new ComboBoxModel(); 
    $userModel = new UserManagementModel(); 


    $data = [
        'estudiantes' => $userModel->where('role_id', 2)->findAll(),
        'jornadas'    => $comboModel->getTableData('jornadas') ?? [],
        'grados'      => $comboModel->getTableData('grados') ?? [],

    ];
return view('admin/matricula/matricula', $data);

}

public function store()
{
    $matriculaModel = new MatriculaModel();

    // Recibir datos del formulario
    $grupoId        = $this->request->getPost('grupo_id');
    $jornadaId      = $this->request->getPost('jornada_id');
    $estudiantes    = $this->request->getPost('estudiante_id'); // array

log_message('debug', 'Grupo ID: ' . $grupoId);
log_message('debug', 'Jornada ID: ' . $jornadaId);
log_message('debug', 'Estudiantes: ' . implode(',', $estudiantes));


    foreach ($estudiantes as $estudianteId) {
        $matriculaModel->insert([
            'grupo_id'        => $grupoId,
            'jornada_id'      => $jornadaId,
            'estudiante_id'   => $estudianteId,
        ]);
    }

    return redirect()->to('admin/matricula')->with('success', 'Matrícula(s) registrada(s) correctamente');
}


 
}