<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="mb-4">Registrar Matrícula - Año <?= $añoActual ?></h2>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('admin/matriculas/store') ?>" method="post" id="formMatricula">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="grado" class="form-label">
                            <i class="fas fa-graduation-cap"></i> Grado <span class="text-danger">*</span>
                        </label>
                        <select name="grado" id="grado" class="form-control" required>
                            <option value="">Seleccione un grado</option>
                            <?php foreach ($grados as $grado): ?>
                                <option value="<?= $grado['id'] ?>"><?= $grado['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="grupo" class="form-label">
                            <i class="fas fa-users"></i> Grupo <span class="text-danger">*</span>
                        </label>
                        <select name="grupo_id" id="grupo" class="form-control" required>
                            <option value="">Primero seleccione un grado</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jornada_id" class="form-label">
                            <i class="fas fa-clock"></i> Jornada <span class="text-danger">*</span>
                        </label>
                        <select name="jornada_id" id="jornada_id" class="form-control" required>
                            <option value="">Seleccione una jornada</option>
                            <?php foreach ($jornadas as $jornada): ?>
                                <option value="<?= $jornada['id'] ?>"><?= $jornada['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="estudiante_id" class="form-label">
                            <i class="fas fa-user-graduate"></i> Estudiantes <span class="text-danger">*</span>
                        </label>
                        <select name="estudiante_id[]" id="estudiante_id" class="form-control select2" multiple="multiple" required>
                            <?php if (empty($estudiantes)): ?>
                                <option value="" disabled>No hay estudiantes disponibles para matricular</option>
                            <?php else: ?>
                                <?php foreach ($estudiantes as $estudiante): ?>
                                    <option value="<?= $estudiante['id'] ?>">
                                        <?= esc($estudiante['name']) ?> - <?= esc($estudiante['documento']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">
                            Solo se muestran estudiantes NO matriculados en el año <?= $añoActual ?>
                        </small>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="<?= base_url('admin/matriculas') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                        <i class="fas fa-save"></i> Guardar Matrícula
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Mostrar alertas con SweetAlert2
        <?php if (session()->has('success')): ?>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?= addslashes(session('success')) ?>',
                showConfirmButton: true,
                timer: 5000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if (session()->has('warning')): ?>
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                html: '<?= addslashes(session('warning')) ?>',
                showConfirmButton: true,
                confirmButtonColor: '#ffc107'
            });
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= addslashes(session('error')) ?>',
                showConfirmButton: true,
                confirmButtonColor: '#dc3545'
            });
        <?php endif; ?>
        // Inicializar Select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione uno o más estudiantes',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron estudiantes";
                }
            }
        });

        // Cargar grupos dinámicamente por grado
        function cargarGruposPorGrado(gradoId) {
            console.log('Cargando grupos para el grado ID:', gradoId);
            const grupoSelect = $('#grupo');
            grupoSelect.empty().append('<option value="">Cargando...</option>').prop('disabled', true);

            if (!gradoId || gradoId.trim() === '') {
                grupoSelect.html('<option value="">Primero seleccione un grado</option>').prop('disabled', false);
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
                    grupoSelect.empty().append('<option value="">Seleccione un grupo</option>');
                    if (data && data.length > 0) {
                        data.forEach(grupo => {
                            grupoSelect.append(new Option(grupo.nombre, grupo.id));
                        });
                    } else {
                        grupoSelect.append('<option value="">No hay grupos disponibles</option>');
                    }
                    grupoSelect.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar grupos:', error);
                    grupoSelect.html('<option value="">Error al cargar grupos</option>').prop('disabled', false);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los grupos. Por favor, intente nuevamente.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }

        // Evento change del select de grado
        $('#grado').on('change', function() {
            const gradoId = $(this).val();
            cargarGruposPorGrado(gradoId);
        });

        // Validación antes de enviar con SweetAlert2
        $('#formMatricula').on('submit', function(e) {
            e.preventDefault();
            const estudiantes = $('#estudiante_id').val();
            
            if (!estudiantes || estudiantes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe seleccionar al menos un estudiante',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            // Confirmar acción con SweetAlert2
            Swal.fire({
                title: '¿Está seguro?',
                html: `Está a punto de matricular <strong>${estudiantes.length}</strong> estudiante(s)<br>en el año <?= $añoActual ?>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check"></i> Sí, matricular',
                cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Deshabilitar botón y mostrar loading
                    $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Procesando...',
                        html: 'Guardando matrícula(s)',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar formulario
                    $('#formMatricula')[0].submit();
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>