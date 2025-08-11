<?php
namespace App\Controllers;

use App\Models\UserManagementModel;
use App\Models\MatriculaModel;
use App\Models\ComboBoxModel;
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
        'jornada'          => 'required|integer',
        'grado'            => 'required|integer',
        'grupo'            => 'required|integer',
        'fecha_matricula'  => 'required|valid_date',
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

    // Preparar datos para matrícula
    $matriculaData = [
        'estudiante_id'          => $userId,
        'jornada_id'          => $postData['jornada'],
        'grupo_id'            => $postData['grupo'],
        'fecha_matricula' => date('Y-m-d', strtotime($postData['fecha_matricula'])),
    ];

    $matriculaModel = new MatriculaModel();

    if (!$matriculaModel->insert($matriculaData)) {
        $errors = $matriculaModel->errors();
        log_message('error', 'Error al insertar matrícula: {errors}', [
            'errors' => json_encode($errors)
        ]);
        return redirect()->back()->withInput()->with('errors-insert', $errors);
    }

    log_message('debug', 'Matrícula insertada correctamente para el usuario ID: {id}', ['id' => $userId]);

    return redirect()->to('/admin/usermanagement')->with('success', 'User added successfully');
}


public function exportToExcel()
{
    $userModel = new UserManagementModel();
    $users = $userModel->getUsers() ?? [];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

 $headers = [
        'Full Name', 'Identification', 'Email', 'Phone', 'Address',
        'Date Registration', 'Status', 'Role',
    ];    $sheet->fromArray($headers, null, 'A1');

    // Estilo del encabezado (solo color de fondo amarillo)
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'size' => 12
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'f1c40f']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER
        ]
    ];
    $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
    $sheet->getRowDimension(1)->setRowHeight(25);

    // Llenar filas de datos (sin estilo especial)
    $row = 2;
    foreach ($users as $user) {
   $sheet->setCellValue('A' . $row, $user['name'] . ' ' . $user['last_name']);
        $sheet->setCellValue('B' . $row, $user['identification']);
        $sheet->setCellValue('C' . $row, $user['email']);
        $sheet->setCellValue('D' . $row, $user['phone']);
        $sheet->setCellValue('E' . $row, $user['address']);
        $sheet->setCellValue('F' . $row, $user['date_registration']);
        $sheet->setCellValue('G' . $row, $user['status']);
        $sheet->setCellValue('H' . $row, $user['role_name']);
     

        $row++;
    }

    // Autoajustar columnas
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Descargar archivo
    $writer = new Xlsx($spreadsheet);
    $filename = 'users_export_' . date('Ymd_His') . '.xlsx';

    return $this->response
        ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
        ->setHeader('Content-Disposition', 'attachment;filename="' . $filename . '"')
        ->setHeader('Cache-Control', 'max-age=0')
        ->setBody($this->getSpreadsheetContent($writer));
}
private function getSpreadsheetContent($writer)
    {
        ob_start();
        $writer->save('php://output');
        return ob_get_clean();
}
public function updateUser($id)
    {
        log_message('info', 'Starting updateUser() method for user ID: ' . $id);
        
        $model = new UserManagementModel();
        
        // Define validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[70]',
            'last_name' => 'required|min_length[2]|max_length[80]',
            'identification' => "required|numeric|min_length[5]|max_length[20]|is_unique[users.identification,id_user,{$id}]",
            'email' => "required|valid_email|max_length[100]|is_unique[users.email,id_user,{$id}]",
            'phone' => 'required|numeric|min_length[8]|max_length[15]',
            'address' => 'required|max_length[100]',
            'status' => 'required|in_list[active,inactive]',
        ];
        
        log_message('info', 'Validation rules defined.');
        
        // Validate data
        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode(\Config\Services::validation()->getErrors()));
            
            // Retain input and display validation errors
            return redirect()->back()->withInput()->with('errors-edit', \Config\Services::validation()->getErrors());
        }
        
        log_message('info', 'Validation successful.');
        
        // Collect form data
        $data = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'identification' => $this->request->getPost('identification'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status'),
        ];
        
        log_message('info', 'Collected form data: ' . json_encode($data));
        
        try {
            // Update user in the database
            $model->update($id, $data);
            log_message('info', 'Executed query: ' . $model->db->getLastQuery());
        
            log_message('info', 'User successfully updated.');
            return redirect()->to('/admin/usermanagement')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('errors-insert', ['db_error' => 'An error occurred while updating the user.']);
        }
}  
public function deleteUser($id)
{
    $userModel = new UserManagementModel();
    try {
        $result = $userModel->delete($id);

        if ($result) {
            return redirect()->to('/admin/usermanagement')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->to('/admin/usermanagement')->with('error', 'Could not delete the user.');
        }
    } catch (DatabaseException $e) {
        // Specific error handling
        if (strpos($e->getMessage(), 'Cannot delete or update a parent row: a foreign key constraint fails') !== false) {
            return redirect()->to('/admin/usermanagement')->with('error', 'Cannot delete the user because it is associated with other records or assignments.');
        }

        // Other errors
        return redirect()->to('/admin/usermanagement')->with('error', 'An error occurred while trying to delete the user.');
    }
}
public function getUserById($id)
    {
        log_message('info', 'Iniciando el método getUserById() con ID: ' . $id);
        $model = new UserManagementModel();
        $user = $model->find($id);

        if ($user) {
            log_message('info', 'Usuario encontrado: ' . json_encode($user));
            return $this->response->setJSON($user);
        } else {
            log_message('error', 'Usuario no encontrado con ID: ' . $id);
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
          ->setJSON(['status' => 'error', 'message' => 'User not found']);

        }
}    
}
