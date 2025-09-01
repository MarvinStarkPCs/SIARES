<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">

    <!-- Botón Atrás -->
    <a href="<?= base_url('admin/usermanagement') ?>" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>

    <h3 class="mb-3">Detalles del Usuario</h3>

    <!-- Nombre y Documento -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" class="form-control" value="<?= esc($user['name']) ?>" readonly>
        </div>
        <div class="form-group col-md-6">
            <label>Documento</label>
            <input type="text" class="form-control" value="<?= esc($user['documento']) ?>" readonly>
        </div>
    </div>

    <!-- Email y Teléfono -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" class="form-control" value="<?= esc($user['email']) ?>" readonly>
        </div>
        <div class="form-group col-md-6">
            <label>Teléfono</label>
            <input type="text" class="form-control" value="<?= esc($user['telefono']) ?>" readonly>
        </div>
    </div>

    <!-- Dirección -->
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Dirección</label>
            <input type="text" class="form-control" value="<?= esc($user['direccion']) ?>" readonly>
        </div>
    </div>

    <!-- Género y Fecha de nacimiento -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Género</label>
            <input type="text" class="form-control" value="<?= esc($user['genero']) ?>" readonly>
        </div>
        <div class="form-group col-md-6">
            <label>Fecha de Nacimiento</label>
            <input type="date" class="form-control" value="<?= esc($user['fecha_nacimiento']) ?>" readonly>
        </div>
    </div>

    <!-- Estado -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Estado</label>
            <input type="text" class="form-control" value="<?= esc($user['estado']) ?>" readonly>
        </div>
    </div>

    <!-- Fechas -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Creado en</label>
            <input type="text" class="form-control" value="<?= esc($user['created_at']) ?>" readonly>
        </div>
        <div class="form-group col-md-6">
            <label>Última actualización</label>
            <input type="text" class="form-control" value="<?= esc($user['updated_at']) ?>" readonly>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
