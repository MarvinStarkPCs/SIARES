<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">

    <h2 class="mb-4">Registrar Matrícula</h2>
    <form action="<?= base_url('matriculas/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
         <div class="col-md-6 mb-3">
    <label for="estudiante_id" class="form-label">Estudiante(Escriba Documento o Nombre)</label>
    <select name="estudiante_id[]" id="estudiante_id" class="form-control select2" multiple="multiple" required>
        <?php foreach ($estudiantes as $estudiante): ?>
            <option value="<?= $estudiante['id'] ?>">
                <?= $estudiante['name'] . ' - ' . $estudiante['documento'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


            <div class="col-md-6 mb-3">
                <label for="jornada_id" class="form-label">Jornada</label>
                <select nombre="jornada_id" id="jornada_id" class="form-control select2" required>
                    <option value="">Seleccione una jornada</option>
                    <?php foreach ($jornadas as $jornada): ?>
                        <option value="<?= $jornada['id'] ?>"><?= $jornada['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="grupo_id" class="form-label">Grupo</label>
                <select nombre="grupo_id" id="grupo_id" class="form-control select2" required>
                    <option value="">Seleccione un grupo</option>
                    <?php foreach ($grupos as $grupo): ?>
                        <option value="<?= $grupo['id'] ?>"><?= $grupo['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="grado_id" class="form-label">Grado</label>
                <select nombre="grado_id" id="grado_id" class="form-control select2" required>
                    <option value="">Seleccione un grado</option>
                    <!-- < ?php foreach ($grados as $grado): ?>
                        <option value="< ?= $grado['id'] ?>">< ?= $grado['nombre'] ?></option>
                    < ?php endforeach; ?> -->
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="fecha_matricula" class="form-label">Fecha de Matrícula</label>
                <input type="date" nombre="fecha_matricula" id="fecha_matricula" class="form-control" required>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script>
  $(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: 'Seleccione una opción',
        allowClear: true
    });
  });
</script>

<?= $this->endSection() ?>
