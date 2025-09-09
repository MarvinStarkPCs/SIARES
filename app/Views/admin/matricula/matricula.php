<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="mb-4">Registrar Matrícula</h2>
    <form action="<?= base_url('admin/matriculas/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="grado_id" class="form-label">Grado</label>
                <select name="grado" id="grado" class="form-control " required>
                    <option value="">Seleccione un grado</option>
                    <?php foreach ($grados as $grado): ?>
                        <option value="<?= $grado   ['id'] ?>"><?= $grado['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="grupo_id" class="form-label">Grupo</label>
                <select name="grupo_id" id="grupo" class="form-control " required>
                    <option value="">Seleccione un grupo</option>
                </select>
            </div>
              <div class="col-md-6 mb-3">
                <label for="jornada_id" class="formlabel">Jornada</label>
                <select name="jornada_id" id="jornada_id" class="form-control " required>
                    <option value="">Seleccione una jornada</option>
                    <?php foreach ($jornadas as $jornada): ?>
                        <option value="<?= $jornada['id'] ?>"><?= $jornada['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            

             <div class="col-md-6 mb-3">
                <label for="estudiante_id" class="form-label">Estudiantes</label>
                <select name="estudiante_id[]" id="estudiante_id" class="form-control select2" multiple="multiple" required>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?= $estudiante['id'] ?>">
                            <?= $estudiante['name'] .  ' - ' . $estudiante['documento'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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

        // Cargar grupos dinámicamente por grado
        function cargarGruposPorGrado(gradoId) {
            console.log('Cargando grupos para el grado ID:', gradoId);
            const grupoSelect = $('#grupo');
            grupoSelect.empty().append('<option value="">Cargando...</option>');

            if (!gradoId || gradoId.trim() === '') {
                grupoSelect.html('<option value="">Selecciona un grado</option>');
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/usermanagement/showComboBox') ?>",
                type: "POST",
                data: {
                    tabla: 'grupos',
                    campo: 'grado_id',
                    id: gradoId,
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>"
                },
                dataType: "json",
                success: function(data) {
                    grupoSelect.empty().append('<option value="">Selecciona...</option>');
                    if (data.length) {
                        data.forEach(grupo => {
                            grupoSelect.append(new Option(grupo.nombre, grupo.id));
                        });
                    } else {
                        grupoSelect.append('<option value="">No hay grupos</option>');
                    }
                }
            });
        }

        $('#grado').on('change', function() {
            cargarGruposPorGrado($(this).val());
        });


    });
</script>

<?= $this->endSection() ?>