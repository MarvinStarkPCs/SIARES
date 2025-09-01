<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    
    <!-- Botón Atrás -->
    <a href="<?= base_url('admin/usermanagement') ?>" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>

    <h3 class="mb-3">Editar Usuario</h3>
    <form action="<?= base_url('admin/usermanagement/update/' . $user['id']) ?>" method="post">
        
        <!-- Nombre y Documento -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nombre</label>
                <input type="text" class="form-control" name="name" 
                       value="<?= old('name', $user['name']) ?>">
                <?php if (session('errors-edit.name')): ?>
                    <small class="text-danger"><?= session('errors-edit.name') ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label>Documento</label>
                <input type="text" class="form-control" name="documento" 
                       value="<?= old('documento', $user['documento']) ?>">
                <?php if (session('errors-edit.documento')): ?>
                    <small class="text-danger"><?= session('errors-edit.documento') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Email y Teléfono -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" class="form-control" name="email" 
                       value="<?= old('email', $user['email']) ?>">
                <?php if (session('errors-edit.email')): ?>
                    <small class="text-danger"><?= session('errors-edit.email') ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" 
                       value="<?= old('telefono', $user['telefono']) ?>">
                <?php if (session('errors-edit.telefono')): ?>
                    <small class="text-danger"><?= session('errors-edit.telefono') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Dirección -->
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Dirección</label>
                <input type="text" class="form-control" name="direccion" 
                       value="<?= old('direccion', $user['direccion']) ?>">
                <?php if (session('errors-edit.direccion')): ?>
                    <small class="text-danger"><?= session('errors-edit.direccion') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Género y Fecha de nacimiento -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Género</label>
                <select class="form-control" name="genero">
                    <option value="Masculino" <?= old('genero', $user['genero']) == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                    <option value="Femenino" <?= old('genero', $user['genero']) == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= old('genero', $user['genero']) == 'Otro' ? 'selected' : '' ?>>Otro</option>
                </select>
                <?php if (session('errors-edit.genero')): ?>
                    <small class="text-danger"><?= session('errors-edit.genero') ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label>Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fecha_nacimiento" 
                       value="<?= old('fecha_nacimiento', $user['fecha_nacimiento']) ?>">
                <?php if (session('errors-edit.fecha_nacimiento')): ?>
                    <small class="text-danger"><?= session('errors-edit.fecha_nacimiento') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Estado -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Estado</label>
                <select class="form-control" name="status">
                    <option value="active" <?= old('status', $user['estado']) == 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= old('status', $user['estado']) == 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <?php if (session('errors-edit.status')): ?>
                    <small class="text-danger"><?= session('errors-edit.status') ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Fechas -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Creado en</label>
                <input type="text" class="form-control" name="created_at" 
                       value="<?= esc($user['created_at']) ?>" readonly>
            </div>
            <div class="form-group col-md-6">
                <label>Última actualización</label>
                <input type="text" class="form-control" name="updated_at" 
                       value="<?= esc($user['updated_at']) ?>" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-block">Guardar Cambios</button>
    </form>
</div>
<?= $this->endSection() ?>
