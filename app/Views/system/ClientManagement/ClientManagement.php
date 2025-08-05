<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<!-- DataTable -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-dark-blue d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">List of Clients</h6>
        <div>
            <a href="./clientmanagement/excel" class="btn btn-success btn-sm mr-2" title="Export to Excel">
                <i class="fas fa-file-excel"></i> Excel
            </a>
            <button type="button" id="openModalButtonUser" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#addUserModal">
                <i class="fas fa-user-plus"></i> Add Client
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Identification</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['name'] . ' ' . $user['last_name']) ?></td>
                            <td><?= esc($user['identification']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['role_name']) ?></td>
                            <td class="text-center">
                                <?php if ($user['status'] == 'active'): ?>
                                    <span class="badge badge-success">Active</span>
                                    <button class="btn btn-sm btn-success ml-2" title="User is active">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                    <button class="btn btn-sm btn-danger ml-2" title="User is inactive">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-icon btn-detail btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#detailsModal" 
                                        data-id="<?= $user['id_user']?>"
                                        title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <button class="btn btn-icon btn-edit btn-info btn-sm" data-toggle="modal" id="editModalClient"
                                        data-target="#editModal"
                                        data-id="<?= $user['id_user']?>" title="Edit User">
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

<?= view('system/ClientManagement/modals/Create') ?>
<?= view('system/ClientManagement/modals/Delete') ?>
<?= view('system/ClientManagement/modals/Detail') ?>
<?= view('system/ClientManagement/modals/Update') ?>

<?= $this->endSection() ?>
