<?php

namespace App\Controllers;

use App\Models\UserManagementModel;
use App\Models\ReciclajeModel;
use App\Models\ComboBoxModel;
use App\Models\GruposAsignacionModel;

class ReciclajeController extends  BaseController
{
    public function index()
    {
        $ComboBoxModel = new ComboBoxModel();
        $userModel = new UserManagementModel();
        $gruposGrados = new GruposAsignacionModel();
        $estudiantes = $userModel->getUsersWithRoles(2); // Puedes cambiar el 2 si lo deseas
        $data = [

            'estudiantes' => $estudiantes,
            'grados_grupos' => $gruposGrados->getGruposAsignadosPorProfesor() ?? [],
            'materiales' => $ComboBoxModel->getTableData('materiales') ?? [],
            'periodos' => $ComboBoxModel->getTableData('periodos') ?? [],


        ];
        log_message('debug', 'Datos para la vista: ' . print_r($data, true));
        return view('docente/reciclaje/index', $data);
    }

    public function getEstudiantes()
{
    $grupoId = $this->request->getGet('grupo_id');

    $matriculaModel = new \App\Models\MatriculaModel();
    $estudiantes = $matriculaModel->getEstudiantesPorGrupo($grupoId);

    return $this->response->setJSON($estudiantes);
}


public function guardarMateriales()
{
    $data = $this->request->getPost('materiales');
    if (!$data) {
        return $this->response->setJSON(['success' => false, 'msg' => 'No se recibieron datos']);
    }

    $db = \Config\Database::connect();
    $builder = $db->table('reciclajes'); // tu tabla de la DB

    $insertData = [];
    $now = date('Y-m-d H:i:s');

    foreach ($data as $d) {
        $insertData[] = [
            'periodo_id'   => $d['periodo_id'],
            'material_id'  => $d['material_id'],
            'matricula_id' => $d['matricula_id'],
            'peso_total'   => $d['peso_total'],
            'created_at'   => $now,
            'updated_at'   => $now
        ];
    }

    $builder->insertBatch($insertData);

    return $this->response->setJSON(['success' => true]);
}


    // public function reporte_reciclaje_admin()
    // {
    //     $estudianteId = session()->get('user_id');
    //     $reporteModel = new ReciclajeModel();
    //     $periodoModel = new ComboBoxModel();
    //     log_message('debug', 'Generando reporte para estudiante ID: ' . $estudianteId);
    //     // Obtener todos los periodos
    //     $periodos = $periodoModel->getTableData('periodos') ?? [];

    //     // Tomar el primer periodo como default
    //     $periodoId = $this->request->getGet('periodo_id') ?? ($periodos[0]['id'] ?? null);

    //     // Reporte filtrado
    //     $materiales = $reporteModel->getReporteAgrupado($estudianteId, $periodoId);
    //     log_message('debug', 'Materiales obtenidos: ' . print_r($materiales, true));
    //     return view('estudiante/reporte-reciclaje/index', [
    //         'materiales' => $materiales,
    //         'periodos'   => $periodos,
    //         'periodoId'  => $periodoId
    //     ]);
    // }
    // public function buscar($documento)
    // {
    //     log_message('debug', 'Buscar estudiante con documento: ' . $documento);
    //     $model = new UserManagementModel();
    //     $estudiante = $model->getMatriculaByDocumento($documento);

    //     log_message('debug', 'Estudiante encontrado: ' . print_r($estudiante, true));
    //     if (!empty($estudiante)) {
    //         $est = $estudiante[0]; // primer resultado
    //         return $this->response->setJSON([
    //             'success' => true,
    //             'estudiante' => [
    //                 'grado'   => $est['grado'],
    //                 'grupo'   => $est['grupo'],
    //                 'jornada' => $est['jornada'],
    //                 'nombre'  => $est['estudiante'], // ojo: la columna se llama "estudiante", no "nombre"
    //                 'matricula_id' => $est['matricula_id']
    //             ]
    //         ]);
    //     } else {
    //         return $this->response->setJSON(['success' => false]);
    //     }
    // }
    // public function guardar()
    // {
    //     $reciclajeModel = new ReciclajeModel();
    //     $response = ['success' => false];

    //     $data = $this->request->getPost('materiales'); // Array de materiales

    //     if ($data && is_array($data)) {
    //         foreach ($data as $item) {
    //             $insertData = [
    //                 'matricula_id' => $item['matricula_id'],
    //                 'periodo_id' => $item['periodo_id'],
    //                 'material_id' => $item['material_id'],
    //                 'peso_total' => $item['peso']
    //             ];
    //             $reciclajeModel->insert($insertData);
    //         }
    //         $response['success'] = true;
    //     } else {
    //         $response['message'] = 'No se recibieron datos válidos.';
    //     }

    //     return $this->response->setJSON($response);
    // }
    public function reporte_reciclaje()
    {
        $estudianteId = session()->get('user_id');
        $reporteModel = new ReciclajeModel();
        $periodoModel = new ComboBoxModel();
        log_message('debug', 'Generando reporte para estudiante ID: ' . $estudianteId);
        // Obtener todos los periodos
        $periodos = $periodoModel->getTableData('periodos') ?? [];

        // Tomar el primer periodo como default
        $periodoId = $this->request->getGet('periodo_id') ?? ($periodos[0]['id'] ?? null);

        // Reporte filtrado
        $materiales = $reporteModel->getReporteAgrupado($estudianteId, $periodoId);
        log_message('debug', 'Materiales obtenidos: ' . print_r($materiales, true));
        return view('estudiante/reporte_reciclaje/index', [
            'materiales' => $materiales,
            'periodos'   => $periodos,
            'periodoId'  => $periodoId
        ]);
    }
    public function reporte_reciclaje_general()
    {
        $reporteModel = new ReciclajeModel();
        $periodoModel = new ComboBoxModel();

        // Obtener todos los periodos
        $periodos = $periodoModel->getTableData('periodos') ?? [];

        // Tomar el primer periodo como default
        $periodoId = $this->request->getGet('periodo_id') ?? ($periodos[0]['id'] ?? null);

        // Obtener reporte general
        $materiales = $reporteModel->getReporteGeneral($periodoId);

        return view('admin/reporte_reciclaje/index', [
            'materiales' => $materiales,
            'periodos'   => $periodos,
            'periodoId'  => $periodoId
        ]);
    }


      public function filtros(){
        $combobox = new ComboBoxModel();

 $data = [
            'grupos' => $combobox->getTableData('grupos') ?? [],
            'grados' => $combobox->getTableData('grados') ?? [],
            'jornadas' => $combobox->getTableData('jornadas') ?? [],
            'periodos' => $combobox->getTableData('periodos') ?? [],

        ];


        return view('admin/reporte_filtro/index',  $data);


    }

    public function filtrosBuscar()
    {
        $documento = $this->request->getPost('documento');
        $grupo = $this->request->getPost('grupo');
        $jornada = $this->request->getPost('jornada');

        $reporteModel = new ReciclajeModel();
        $resultados = $reporteModel->getReciclajes($grupo, $jornada, $documento);
        return $this->response->setJSON($resultados);
}

}