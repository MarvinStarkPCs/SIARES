<?php

namespace App\Controllers;

use App\Models\UserManagementModel;
use App\Models\MatriculaModel;
use App\Models\ComboBoxModel;
use App\Models\GruposAsignacionModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\SendEmail;
use CodeIgniter\Database\Exceptions\DatabaseException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

    $rules = [
        'name'             => 'required|min_length[2]|max_length[70]',
        'documento'        => 'required|numeric|min_length[5]|max_length[20]|is_unique[users.documento]',
        'email'            => 'required|valid_email|is_unique[users.email]',
        'telefono'         => 'permit_empty|min_length[7]|max_length[20]',
        'direccion'        => 'permit_empty|max_length[100]',
        'genero'           => 'required|in_list[MASCULINO,FEMENINO]',
        'fecha_nacimiento' => 'required|valid_date',
        'role_id'          => 'required|integer',
        'status'           => 'required|in_list[active,inactive]',
    ];

    if (!$this->validate($rules)) {
        $errors = $this->validator->getErrors();
        log_message('error', 'Errores de validación: {errors}', [
            'errors' => json_encode($errors)
        ]);
        return redirect()->back()->withInput()->with('errors-insert', $errors);
    }

    // Extraer solo los campos necesarios para users
    $userData = [
        'name'             => $postData['name'],
        'documento'        => $postData['documento'],
        'email'            => $postData['email'],
        'telefono'         => $postData['telefono'] ?? null,
        'direccion'        => $postData['direccion'] ?? null,
        'genero'           => $postData['genero'],
        'fecha_nacimiento' => $postData['fecha_nacimiento'],
        'role_id'          => $postData['role_id'],
        'status'           => $postData['status'],
        'password'         => password_hash('admin123*', PASSWORD_DEFAULT)
    ];

    log_message('debug', 'Datos para insertar usuario: {data}', [
        'data' => json_encode($userData)
    ]);

    $userModel = new UserManagementModel();

    if (!$userModel->insert($userData)) {
        $errors = $userModel->errors();
        log_message('error', 'Error al insertar usuario: {errors}', [
            'errors' => json_encode($errors)
        ]);
        return redirect()->back()->withInput()->with('errors-insert', $errors);
    }

    $userId = $userModel->getInsertID();
    log_message('debug', 'Usuario insertado correctamente con ID: {id}', ['id' => $userId]);

    // === LÓGICA SEGÚN ROL ===
    if ($postData['role_id'] == 2) { 
        // ---------- ESTUDIANTE -> Matriculas ----------
        $matriculaData = [
            'estudiante_id'  => $userId,
            'jornada_id'     => $postData['jornada'],
            'grupo_id'       => $postData['grupoFormNew']
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
            return redirect()->back()->withInput()->with('errors-insert', $errors);
        }

        log_message('debug', 'Matrícula insertada correctamente para estudiante ID: {id}', ['id' => $userId]);

    } elseif ($postData['role_id'] == 3) { 
        // ---------- PROFESOR -> GruposAsignacion ----------
        if (!empty($postData['grados'])) {
            $asignacionModel = new GruposAsignacionModel();

            foreach ($postData['grados'] as $grupoId) {
                $asignacionData = [
                    'jornada_id'   => $postData['jornada_asignacion'],
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
                    return redirect()->back()->withInput()->with('errors-insert', $errors);
                }
            }

            log_message('debug', 'Asignaciones insertadas correctamente para profesor ID: {id}', ['id' => $userId]);
        }
    }

    return redirect()->to('/admin/usermanagement')->with('success', 'Usuario agregado correctamente');
}

    public function editUser($id)
    {
        $roleModel = new ComboBoxModel();

        log_message('info', 'Iniciando el méto11do editUser() con ID: ' . $id);

        $data['user'] = (new UserManagementModel())->getUserById($id);
        $data['roles']    = $roleModel->getTableData('roles') ?? [];

        log_message('info', 'Datos del usuario: ' . json_encode($data['user']));
        return view('security/UserManagement/update', $data);
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
        'documento'       => 'required|min_length[2]|max_length[80]',
        'email'           => "required|valid_email|max_length[100]|is_unique[users.email,id,{$id}]",
        'telefono'        => 'required|numeric|min_length[8]|max_length[15]',
        'direccion'       => 'required|max_length[100]',
        'genero'          => 'required|in_list[Masculino,Femenino,Otro]',
        'fecha_nacimiento'=> 'required|valid_date',
        'status'          => 'required|in_list[active,inactive]',
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
        'documento'        => $this->request->getPost('documento'),
        'email'            => $this->request->getPost('email'),
        'telefono'         => $this->request->getPost('telefono'),
        'direccion'        => $this->request->getPost('direccion'),
        'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
        'genero'           => $this->request->getPost('genero'),
        'status'           => $this->request->getPost('status'),
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


    
}
