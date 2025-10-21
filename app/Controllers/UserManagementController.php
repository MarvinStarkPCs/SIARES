<?php

namespace App\Controllers;

use App\Models\UserManagementModel;
use App\Models\MatriculaModel;
use App\Models\ComboBoxModel;
use App\Models\GruposAsignacionModel;
use App\Models\getProfesorConGrupos;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;


class UserManagementController extends BaseController
{
public function index()
    {
        $userModel = new UserManagementModel();
        $roleModel = new ComboBoxModel();

        $data = [
            'users' => $userModel->getUsers() ?? [],
            'roles' => $roleModel->getTableData('roles') ?? [],
            'grados_grupos' => $roleModel->getGradosGrupos() ?? [],
            'jornadas' => $roleModel->getTableData('jornadas') ?? [],
            'grados' => $roleModel->getTableData('grados') ?? []

        ];

        return view('security/UserManagement/UserManagement', $data);
}

public function showComboBox()
    {
        $tabla = $this->request->getPost('tabla') ?? '';
        $campo = $this->request->getPost('campo') ?? 'id';
        $id    = $this->request->getPost('id') ?? '';

        $model = new ComboBoxModel();
        $result = $model->getById($tabla, $id, $campo);

        return $this->response->setJSON($result);
}

 public function addUser()
    {
        log_message('debug', 'Entrando a addUser()');

        $postData = $this->request->getPost();
        log_message('debug', 'POST recibido: {post}', [
            'post' => json_encode($postData)
        ]);

        // Reglas base de validación
        $rules = [
            'name'             => 'required|min_length[2]|max_length[70]',
            'last_name'        => 'required|min_length[2]|max_length[70]',
            'email'            => 'required|valid_email|max_length[100]|is_unique[users.email]',
            'documento'        => 'required|numeric|min_length[5]|max_length[20]|is_unique[users.documento]',
            'role_id'          => 'required|integer',
            'status'           => 'required|in_list[active,inactive]',
        ];

        // Agregar reglas condicionales según el rol
        $roleId = $postData['role_id'] ?? null;

        if ($roleId == 2) { // Estudiante
            $rules['jornada_id'] = 'required|integer';
            $rules['grado_id']   = 'required|integer';
            $rules['grupo_id']   = 'required|integer';
        } elseif ($roleId == 3) { // Profesor
            $rules['jornada_asignacion'] = 'required|integer';
            $rules['grados']             = 'required';
        }

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            log_message('error', 'Errores de validación: {errors}', [
                'errors' => json_encode($errors)
            ]);
            return redirect()->back()->withInput()->with('errors-insert', $errors);
        }

        // Extraer solo los campos necesarios para users
        $userData = [
            'name'       => $postData['name'],
            'last_name'  => $postData['last_name'],
            'documento'  => $postData['documento'],
            'email'      => $postData['email'],
            'telefono'   => $postData['telefono'] ?? null,
            'role_id'    => $postData['role_id'],
            'status'     => $postData['status'],
            'password'   => password_hash($postData['documento'], PASSWORD_DEFAULT)
        ];

        log_message('debug', 'Datos para insertar usuario: {data}', [
            'data' => json_encode($userData)
        ]);

        $userModel = new UserManagementModel();
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            if (!$userModel->insert($userData)) {
                $errors = $userModel->errors();
                log_message('error', 'Error al insertar usuario: {errors}', [
                    'errors' => json_encode($errors)
                ]);
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors-insert', $errors);
            }

            $userId = $userModel->getInsertID();
            log_message('debug', 'Usuario insertado correctamente con ID: {id}', ['id' => $userId]);

            // === LÓGICA SEGÚN ROL ===
            if ($postData['role_id'] == 2) { 
                // ---------- ESTUDIANTE -> Matriculas ----------
                $matriculaData = [
                    'estudiante_id'  => $userId,
                    'jornada_id'     => $postData['jornada_id'],
                    'grupo_id'       => $postData['grupo_id']
                ];

                log_message('debug', 'Datos para insertar matrícula: {data}', [
                    'data' => json_encode($matriculaData)
                ]);
                
                $matriculaModel = new MatriculaModel();

                if (!$matriculaModel->insert($matriculaData)) {
                    $errors = $matriculaModel->errors();
                    log_message('error', 'Error al insertar matrícula: {errors}', [
                        'errors' => json_encode($errors)
                    ]);
                    $db->transRollback();
                    return redirect()->back()->withInput()->with('errors-insert', $errors);
                }

                log_message('debug', 'Matrícula insertada correctamente para estudiante ID: {id}', ['id' => $userId]);

            } elseif ($postData['role_id'] == 3) { 
                // ---------- PROFESOR -> GruposAsignacion ----------
                if (!empty($postData['grados']) && is_array($postData['grados'])) {
                    $asignacionModel = new GruposAsignacionModel();
                    
                    // Obtener el año actual
                    $yearActual = date('Y');
                    
                    // ⭐ VALIDAR QUE LOS GRUPOS NO ESTÉN YA ASIGNADOS
                    $gruposYaAsignados = [];
                    $gruposBuilder = $db->table('grupos_asignacion ga')
                        ->select('ga.grupo_id, g.nombre as grupo_nombre, gr.nombre as grado_nombre')
                        ->join('grupos g', 'g.id = ga.grupo_id')
                        ->join('grados gr', 'gr.id = g.grado_id')
                        ->where('ga.jornada_id', $postData['jornada_asignacion'])
                        ->where('YEAR(ga.created_at)', $yearActual)
                        ->whereIn('ga.grupo_id', $postData['grados'])
                        ->get();
                    
                    if ($gruposBuilder->getNumRows() > 0) {
                        $gruposConflicto = $gruposBuilder->getResultArray();
                        foreach ($gruposConflicto as $grupo) {
                            $gruposYaAsignados[] = $grupo['grado_nombre'] . ' - ' . $grupo['grupo_nombre'];
                        }
                        
                        $errorMsg = 'Los siguientes grupos ya están asignados a otro profesor en el año actual: ' . implode(', ', $gruposYaAsignados);
                        log_message('warning', 'Intento de asignar grupos ya asignados: {grupos}', [
                            'grupos' => implode(', ', $gruposYaAsignados)
                        ]);
                        
                        $db->transRollback();
                        return redirect()->back()->withInput()->with('errors-insert', [
                            'grados' => $errorMsg
                        ]);
                    }

                    // Si no hay conflictos, proceder con las asignaciones
                    foreach ($postData['grados'] as $grupoId) {
                        $asignacionData = [
                            'jornada_id'  => $postData['jornada_asignacion'],
                            'profesor_id' => $userId,
                            'grupo_id'    => $grupoId,
                        ];

                        log_message('debug', 'Datos para insertar asignación: {data}', [
                            'data' => json_encode($asignacionData)
                        ]);
                        
                        if (!$asignacionModel->insert($asignacionData)) {
                            $errors = $asignacionModel->errors();
                            log_message('error', 'Error al insertar asignación: {errors}', [
                                'errors' => json_encode($errors)
                            ]);
                            $db->transRollback();
                            return redirect()->back()->withInput()->with('errors-insert', $errors);
                        }
                    }

                    log_message('debug', 'Asignaciones insertadas correctamente para profesor ID: {id}', ['id' => $userId]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                log_message('error', 'Error en la transacción al crear usuario');
                return redirect()->back()->withInput()->with('errors-insert', ['error' => 'Error al guardar los datos']);
            }

            log_message('info', 'Usuario creado exitosamente con ID: {id}', ['id' => $userId]);
            return redirect()->to('/admin/usermanagement')->with('success', 'Usuario agregado correctamente');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Excepción al crear usuario: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('errors-insert', ['error' => 'Error inesperado: ' . $e->getMessage()]);
        }
    }

public function editUser($id)
    {
        $roleModel = new ComboBoxModel();

        log_message('info', 'Iniciando el méto11do editUser() con ID: ' . $id);

        $data['user'] = (new UserManagementModel())->getUserById($id);
        $data['roles']    = $roleModel->getTableData('roles') ?? [];

        log_message('info', 'Datos del usuario: ' . json_encode($data['user']));
        return view('security/UserManagement/Update', $data);
}

public function detailUser($id)
    {
        $roleModel = new ComboBoxModel();

        log_message('info', 'Iniciando el méto11do editUser() con ID: ' . $id);

        $data['user'] = (new UserManagementModel())->getUserById($id);
        $data['roles']    = $roleModel->getTableData('roles') ?? [];

        log_message('info', 'Datos del usuario: ' . json_encode($data['user']));
        return view('security/UserManagement/Detail', $data);
}

public function updateUser($id)
{
    log_message('info', 'Starting updateUser() method for user ID: ' . $id);

    $model = new UserManagementModel();

    // Reglas de validación
    $rules = [
        'name'            => 'required|min_length[2]|max_length[70]',
        'last_name'       => 'required|min_length[2]|max_length[70]',
        'documento'       => 'required|min_length[2]|max_length[80]',
        'email'           => "required|valid_email|max_length[100]|is_unique[users.email,id,{$id}]",
        'telefono'        => 'required|numeric|min_length[8]|max_length[15]',
        'status'          => 'required|in_list[active,inactive]',
        'password'       => 'permit_empty|min_length[8]|max_length[255]',
    ];

    log_message('info', 'Validation rules defined.');

    // Validación
    if (!$this->validate($rules)) {
        log_message('error', 'Validation failed: ' . json_encode(\Config\Services::validation()->getErrors()));

        return redirect()->back()->withInput()->with('errors-edit', \Config\Services::validation()->getErrors());
    }

    log_message('info', 'Validation successful.');

    // Datos a actualizar
    $data = [
        'name'             => $this->request->getPost('name'),
        'last_name'       => $this->request->getPost('last_name'),
        'documento'        => $this->request->getPost('documento'),
        'email'            => $this->request->getPost('email'),
        'telefono'         => $this->request->getPost('telefono'),
        'status'           => $this->request->getPost('status'),
        'password'        => $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : $model->find($id)['password'],
    ];

    log_message('info', 'Collected form data: ' . json_encode($data));

    try {
        // Ejecuta el update
        $model->update($id, $data);
        log_message('info', 'Executed query: ' . $model->db->getLastQuery());

        log_message('info', 'User successfully updated.');
        return redirect()->to('/admin/usermanagement')->with('success', 'Usuario actualizado correctamente.');
    } catch (\Exception $e) {
        log_message('error', 'Database error: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('errors-insert', [
            'db_error' => 'Ocurrió un error al actualizar el usuario.'
        ]);
    }
}

public function form_estudiante()
{
    
        $userModel = new UserManagementModel();
        $roleModel = new ComboBoxModel();
         $data = [
            'users' => $userModel->getUsers() ?? [],
            'roles' => $roleModel->getTableData('roles') ?? [],
            'grados_grupos' => $roleModel->getGradosGrupos() ?? [],
            'jornadas' => $roleModel->getTableData('jornadas') ?? [],
            'grados' => $roleModel->getTableData('grados') ?? []

        ];

        return view('form_estudiante', $data);
}

public function guardarFormRegister()
{
    $request = service('request');

    // --- 1️⃣ Reglas de validación ---
    $rules = [
        'nombres' => [
            'label'  => 'Nombres',
            'rules'  => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos 3 caracteres.',
                'max_length' => 'El campo {field} no debe superar los 50 caracteres.'
            ]
        ],
        'apellidos' => [
            'label'  => 'Apellidos',
            'rules'  => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos 3 caracteres.',
                'max_length' => 'El campo {field} no debe superar los 50 caracteres.'
            ]
        ],
        'documento' => [
            'label'  => 'Documento',
            'rules'  => 'required|numeric|is_unique[users.documento]',
            'errors' => [
                'required'  => 'El campo {field} es obligatorio.',
                'numeric'   => 'El campo {field} solo debe contener números.',
                'is_unique' => 'Este documento ya está registrado.'
            ]
        ],
        'email' => [
            'label'  => 'Correo electrónico',
            'rules'  => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required'    => 'El campo {field} es obligatorio.',
                'valid_email' => 'Debe ingresar un correo electrónico válido.',
                'is_unique'   => 'Este correo ya está registrado.'
            ]
        ],
        'jornada' => [
            'label'  => 'Jornada',
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Debe seleccionar una {field}.',
                'integer'  => 'El valor de {field} no es válido.'
            ]
        ],
        'grado' => [
            'label'  => 'Grado',
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Debe seleccionar un {field}.',
                'integer'  => 'El valor de {field} no es válido.'
            ]
        ],
        'grupo' => [
            'label'  => 'Grupo',
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'Debe seleccionar un {field}.',
                'integer'  => 'El valor de {field} no es válido.'
            ]
        ],
    ];

    // --- 2️⃣ Validar formulario ---
    if (!$this->validate($rules)) {
        return redirect()->back()
                         ->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    // --- 3️⃣ Datos limpios ---
    $nombre     = $request->getPost('nombres');
    $apellido   = $request->getPost('apellidos');
    $documento  = $request->getPost('documento');
    $email      = $request->getPost('email');
    $grupo_id   = $request->getPost('grupo');
    $jornada_id = $request->getPost('jornada');

    // Contraseña = documento
    $password = password_hash($documento, PASSWORD_DEFAULT);

    // --- 4️⃣ Modelos ---
    $userModel      = new UserManagementModel();
    $matriculaModel = new MatriculaModel();

    // --- 5️⃣ Guardar usuario ---
    $userData = [
        'name'       => $nombre,
        'last_name'  => $apellido,
        'documento'  => $documento,
        'email'      => $email,
        'password'   => $password,
        'role_id'    => 2, // Estudiante
        'estado'     => 'activo',
        'created_at' => date('Y-m-d H:i:s')
    ];

    $userModel->insert($userData);
    $estudiante_id = $userModel->getInsertID();

    // --- 6️⃣ Guardar matrícula ---
    $matriculaModel->insert([
        'estudiante_id'   => $estudiante_id,
        'jornada_id'      => $jornada_id,
        'grupo_id'        => $grupo_id,
        'fecha_matricula' => date('Y-m-d'),
        'created_at'      => date('Y-m-d H:i:s')
    ]);

    // --- 7️⃣ Redirección final ---
    return redirect()->to('login')->with('success', 'Estudiante registrado exitosamente.'); 
}

public function buscar()
    {
        if ($this->request->isAJAX()) {
            $documento = trim($this->request->getPost('documento'));
            $userModel = new GruposAsignacionModel();
            $resultado = $userModel->getProfesorConGrupos($documento);

            return $this->response->setJSON($resultado);
        }
    }

public function guardarAsignaturas()
{
    log_message('debug', 'Entrando a guardarAsignaturas()');

    if (!$this->request->isAJAX()) {
        return $this->response->setStatusCode(405, 'Método no permitido');
    }

    $profesorId = $this->request->getPost('profesor_id');
    $gruposSeleccionados = $this->request->getPost('grados'); // array de IDs de grupo
    $jornadaAsignacion = $this->request->getPost('jornada_asignacion'); // Jornada seleccionada

    if (empty($profesorId)) {
        return $this->response->setJSON([
            'status' => 'error',
            'msg' => 'Profesor no válido.'
        ]);
    }

    if (empty($jornadaAsignacion)) {
        return $this->response->setJSON([
            'status' => 'error',
            'msg' => 'Debe seleccionar una jornada.'
        ]);
    }

    if (empty($gruposSeleccionados)) {
        return $this->response->setJSON([
            'status' => 'error',
            'msg' => 'Debe seleccionar al menos un grupo.'
        ]);
    }

    $db = Database::connect();
    $builder = $db->table('grupos_asignacion');

    // 🗓️ Obtener el año actual
    $anioActual = date('Y');

    // 📋 Arrays para almacenar resultados de validación
    $gruposYaAsignados = [];
    $gruposValidos = [];

    // Obtener nombre de la jornada seleccionada
    $jornada = $db->table('jornadas')
        ->select('nombre')
        ->where('id', $jornadaAsignacion)
        ->get()
        ->getRow();

    $nombreJornada = $jornada ? $jornada->nombre : 'Sin jornada';

    // 📌 Validar cada grupo seleccionado
    foreach ($gruposSeleccionados as $grupoId) {
        // Obtener información del grupo con grado
        $grupo = $db->table('grupos')
            ->select('grupos.id, grupos.nombre as nombre_grupo, grupos.grado_id, grados.nombre as nombre_grado')
            ->join('grados', 'grados.id = grupos.grado_id', 'left')
            ->where('grupos.id', $grupoId)
            ->get()
            ->getRow();

        if (!$grupo) {
            log_message('debug', "Grupo ID {$grupoId} no encontrado en la base de datos");
            continue; // Si el grupo no existe, saltar
        }

        // ⚠️ Validar si ese grupo ya está asignado a otro profesor EN EL AÑO ACTUAL con la misma jornada
        $asignacionExistente = $db->table('grupos_asignacion as ga')
            ->select('ga.id, ga.profesor_id, u.name as nombre_profesor, ga.created_at')
            ->join('users as u', 'u.id = ga.profesor_id', 'left')
            ->where('ga.grupo_id', $grupoId)
            ->where('ga.jornada_id', $jornadaAsignacion)
            ->where('YEAR(ga.created_at)', $anioActual)
            ->where('ga.profesor_id !=', $profesorId) // Excluir al mismo profesor
            ->get()
            ->getRow();

        if ($asignacionExistente) {
            // ❌ Grupo ya asignado a otro profesor
            $gruposYaAsignados[] = [
                'grupo_id' => $grupoId,
                'grado' => "Grado {$grupo->nombre_grado}°",
                'grupo' => "Grupo {$grupo->nombre_grupo}",
                'jornada' => "Jornada {$nombreJornada}",
                'profesor_actual' => $asignacionExistente->nombre_profesor,
                'info_completa' => "Grado {$grupo->nombre_grado}° - Grupo {$grupo->nombre_grupo} - Jornada {$nombreJornada}"
            ];
            
            log_message('debug', "Grupo ID {$grupoId} (Grado {$grupo->nombre_grado}° Grupo {$grupo->nombre_grupo}) ya asignado a {$asignacionExistente->nombre_profesor} en el año {$anioActual}");
        } else {
            // ✅ Grupo disponible
            $gruposValidos[] = [
                'grupo_id' => $grupoId,
                'jornada_id' => $jornadaAsignacion,
                'grado_id' => $grupo->grado_id
            ];
        }
    }

    // 🚫 Si hay grupos ya asignados, retornar error con detalles
    if (!empty($gruposYaAsignados)) {
        $mensajeGrupos = [];
        foreach ($gruposYaAsignados as $ga) {
            $mensajeGrupos[] = "• {$ga['info_completa']} (Asignado a: {$ga['profesor_actual']})";
        }

        $mensajeFinal = "⚠️ Los siguientes grupos ya están asignados en el año {$anioActual}:\n\n" . 
                        implode("\n", $mensajeGrupos) . 
                        "\n\nPor favor, seleccione otros grupos disponibles.";

        log_message('debug', 'Grupos en conflicto: ' . json_encode($gruposYaAsignados));

        return $this->response->setJSON([
            'status' => 'error',
            'msg' => $mensajeFinal,
            'grupos_conflicto' => $gruposYaAsignados
        ]);
    }

    // ✅ Si no hay conflictos, proceder a guardar

    try {
        // 1. Eliminar las asignaciones actuales del profesor EN EL AÑO ACTUAL con esa jornada
        $builder->where('profesor_id', $profesorId)
                ->where('jornada_id', $jornadaAsignacion)
                ->where('YEAR(created_at)', $anioActual)
                ->delete();

        log_message('debug', "Asignaciones anteriores eliminadas para profesor {$profesorId} en jornada {$jornadaAsignacion} del año {$anioActual}");

        // 2. Insertar nuevos registros validados
        if (!empty($gruposValidos)) {
            $data = [];

            foreach ($gruposValidos as $gv) {
                $data[] = [
                    'profesor_id' => $profesorId,
                    'grupo_id'    => $gv['grupo_id'],
                    'jornada_id'  => $gv['jornada_id'],
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }

            $builder->insertBatch($data);
            log_message('debug', count($data) . " grupos asignados correctamente al profesor {$profesorId}");
        }

        return $this->response->setJSON([
            'status' => 'success',
            'msg' => '✅ Grupos actualizados correctamente para el año ' . $anioActual . '.'
        ]);

    } catch (\Exception $e) {
        log_message('error', 'Error al guardar asignaciones: ' . $e->getMessage());
        return $this->response->setJSON([
            'status' => 'error',
            'msg' => 'Error al guardar las asignaciones. Por favor, intente nuevamente.'
        ]);
    }
}


}
