<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">

    <!-- Botón Atrás -->
    <a href="<?= base_url('admin/usermanagement') ?>" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>

    <h3 class="mb-4">Editar Usuario</h3>

    <form action="<?= base_url('admin/usermanagement/update/' . $user['id']) ?>" method="post">
        <div class="row">

            <!-- Nombre -->
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="<?= old('name', $user['name']) ?>">
                <?php if (session('errors-edit.name')): ?>
                    <small class="text-danger"><?= session('errors-edit.name') ?></small>
                <?php endif; ?>
            </div>

            <!-- Apellido -->
            <div class="col-md-6 mb-3">
                <label for="last_name" class="form-label">Apellido</label>
                <input type="text" id="last_name" name="last_name" class="form-control" 
                       value="<?= old('last_name', $user['last_name']) ?>">
                <?php if (session('errors-edit.last_name')): ?>
                    <small class="text-danger"><?= session('errors-edit.last_name') ?></small>
                <?php endif; ?>
            </div>

            <!-- Documento -->
            <div class="col-md-6 mb-3">
                <label for="documento" class="form-label">Documento</label>
                <input type="text" id="documento" name="documento" class="form-control" 
                       value="<?= old('documento', $user['documento']) ?>">
                <?php if (session('errors-edit.documento')): ?>
                    <small class="text-danger"><?= session('errors-edit.documento') ?></small>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?= old('email', $user['email']) ?>">
                <?php if (session('errors-edit.email')): ?>
                    <small class="text-danger"><?= session('errors-edit.email') ?></small>
                <?php endif; ?>
            </div>

            <!-- Teléfono -->
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" 
                       value="<?= old('telefono', $user['telefono']) ?>">
                <?php if (session('errors-edit.telefono')): ?>
                    <small class="text-danger"><?= session('errors-edit.telefono') ?></small>
                <?php endif; ?>
            </div>

            <!-- Contraseña -->
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="text" id="password" name="password" class="form-control" 
                      placeholder="********">
                <?php if (session('errors-edit.password')): ?>
                    <small class="text-danger"><?= session('errors-edit.password') ?></small>
                <?php endif; ?>
            </div>

            <!-- Estado -->
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Estado</label>
                <select id="status" name="status" class="form-control">
                    <option value="active" <?= old('status', $user['estado']) == 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= old('status', $user['estado']) == 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <?php if (session('errors-edit.status')): ?>
                    <small class="text-danger"><?= session('errors-edit.status') ?></small>
                <?php endif; ?>
            </div>

            <!-- Fechas -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Creado en</label>
                <input type="text" class="form-control" value="<?= esc($user['created_at']) ?>" readonly>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">Última actualización</label>
                <input type="text" class="form-control" value="<?= esc($user['updated_at']) ?>" readonly>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
