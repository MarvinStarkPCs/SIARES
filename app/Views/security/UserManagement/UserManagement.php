<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- DataTable -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-dark-blue">
        <h6 class="m-0 font-weight-bold text-primary">List of Users</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3 gap-2">

        <button type="button" id="openModalButtonUser" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
        <i class="fas fa-user-plus"></i> Agregar Usuario
    </button>
        </div>






        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['name']) ?></td>
                        <td><?=esc($user['last_name'])?></td>
                        <td><?= esc($user['documento']) ?></td>
                        <td><?= esc(data: $user['email']) ?></td>
                        <td><?= esc($user['telefono']) ?></td>

                        <td class="text-center">
                            <?php if ($user['estado'] == 'activo'): ?>
                                <span class="badge badge-success">Activo</span>
                                <i class="fas fa-check-circle text-success ml-2"></i>
                            <?php else: ?>
                                <span class="badge badge-danger">Inactivo</span>
                                <i class="fas fa-times-circle text-danger ml-2"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($user['role_name']) ?></td>
                        <td class="text-center">
                            <!-- Botón Detalle -->
                            <a href="<?= base_url('admin/usermanagement/detail/' . $user['id']) ?>"
                               class="btn btn-icon btn-detail btn-secondary btn-sm"
                               title="Ver Detalles">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <!-- Botón Editar (abre en otra pestaña) -->
                            <a href="<?= base_url('admin/usermanagement/edit/' . $user['id']) ?>"
                               class="btn btn-icon btn-edit btn-info btn-sm"
                               title="Editar Usuario">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= view('security/UserManagement/modals/Create') ?>
<?= $this->endSection() ?>








