<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- DataTable -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-dark-blue">
        <h6 class="m-0 font-weight-bold text-primary">List of Users</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3 gap-2">
    <a href="<?= base_url('admin/usermanagement/excel') ?>" class="btn btn-success btn-sm mr-2" title="Exportar a Excel">
        <i class="fas fa-file-excel"></i> Excel
    </a>
    <button type="button" id="openModalButtonUser" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
        <i class="fas fa-user-plus"></i> Agregar Usuario
    </button>
</div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Género</th>
                    <th>Fecha Nacimiento</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['documento']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['telefono']) ?></td>
                        <td><?= esc($user['direccion']) ?></td>
                        <td><?= esc($user['genero']) ?></td>
                        <td><?= esc($user['fecha_nacimiento']) ?></td>
                        <td class="text-center">
                            <?php if ($user['estado'] == 'activo'): ?>
                                <span class="badge badge-success">Activo</span>
                                <button class="btn btn-sm btn-success ml-2" title="Usuario activo">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            <?php else: ?>
                                <span class="badge badge-danger">Inactivo</span>
                                <button class="btn btn-sm btn-danger ml-2" title="Usuario inactivo">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($user['role_name']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-detail btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#detailsModal" 
                                        data-id="<?= $user['id']?>"
                                        title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <button class="btn btn-icon btn-edit btn-info btn-sm" data-toggle="modal" id="editModalClient"
                                        data-target="#editModal"
                                        data-id="<?= $user['id']?>" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    
</script>
<?= view('security/UserManagement/modals/Create') ?>
<?= view('security/UserManagement/modals/Delete') ?>
<?= view('security/UserManagement/modals/Detail') ?>
<?= view('security/UserManagement/modals/Update') ?>
<?= $this->endSection() ?>
