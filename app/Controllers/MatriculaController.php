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
        $matriculaModel = new MatriculaModel();

        // Obtener año actual
        $añoActual = date('Y');

        // Obtener IDs de estudiantes ya matriculados este año
        $estudiantesMatriculados = $matriculaModel
            ->select('estudiante_id')
            ->groupStart()
                ->where('YEAR(fecha_matricula)', $añoActual)
                ->orWhere('YEAR(created_at)', $añoActual)
            ->groupEnd()
            ->groupBy('estudiante_id')
            ->findAll();

        $idsMatriculados = array_column($estudiantesMatriculados, 'estudiante_id');

        // Obtener solo estudiantes NO matriculados este año
        $queryEstudiantes = $userModel->where('role_id', 2)->where('estado', 'activo');
        
        if (!empty($idsMatriculados)) {
            $queryEstudiantes->whereNotIn('id', $idsMatriculados);
        }

        $data = [
            'estudiantes' => $queryEstudiantes->findAll(),
            'jornadas'    => $comboModel->getTableData('jornadas') ?? [],
            'grados'      => $comboModel->getTableData('grados') ?? [],
            'añoActual'   => $añoActual
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

        // Validaciones básicas
        if (empty($grupoId) || empty($jornadaId) || empty($estudiantes)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Todos los campos son obligatorios');
        }

        $añoActual = date('Y');
        $fechaMatricula = date('Y-m-d');
        
        $exitosos = 0;
        $duplicados = [];

        foreach ($estudiantes as $estudianteId) {
            // Verificar si el estudiante ya está matriculado este año
            $yaMatriculado = $matriculaModel
                ->where('estudiante_id', $estudianteId)
                ->groupStart()
                    ->where('YEAR(fecha_matricula)', $añoActual)
                    ->orWhere('YEAR(created_at)', $añoActual)
                ->groupEnd()
                ->first();

            if ($yaMatriculado) {
                // Obtener nombre del estudiante para el mensaje
                $userModel = new UserManagementModel();
                $estudiante = $userModel->find($estudianteId);
                $duplicados[] = $estudiante['name'] ?? "ID: $estudianteId";
                continue;
            }

            // Insertar matrícula
            $inserted = $matriculaModel->insert([
                'grupo_id'        => $grupoId,
                'jornada_id'      => $jornadaId,
                'estudiante_id'   => $estudianteId,
                'fecha_matricula' => $fechaMatricula,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ]);

            if ($inserted) {
                $exitosos++;
            }
        }

        // Mensajes de resultado
        $mensaje = '';
        $tipo = 'success';

        if ($exitosos > 0) {
            $mensaje = "$exitosos matrícula(s) registrada(s) correctamente. ";
        }

        if (!empty($duplicados)) {
            $tipo = $exitosos > 0 ? 'warning' : 'error';
            $mensaje .= "Los siguientes estudiantes ya están matriculados este año: " . implode(', ', $duplicados);
        }

        if ($exitosos === 0 && empty($duplicados)) {
            $mensaje = "No se pudo registrar ninguna matrícula";
            $tipo = 'error';
        }

        return redirect()->to('admin/matricula')->with($tipo, $mensaje);
    }
}