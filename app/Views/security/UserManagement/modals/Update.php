<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="editForm" method="post" class="detail-form">
                    <?= csrf_field() ?>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="detailTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-client" data-toggle="tab" href="#detail-client" role="tab">Información Básica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-banking" data-toggle="tab" href="#detail-banking" role="tab">Matrícula</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-financial" data-toggle="tab" href="#detail-financial" role="tab">Sistema</a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content pt-3" id="detailTabContent">
                        
                        <!-- Tab 1: Información Básica -->
                        <div class="tab-pane fade show active" id="detail-client" role="tabpanel">
                            <h5 class="text-primary">Información Básica</h5>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label>Nombre</label>
                                    <input type="text" name="name" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Documento</label>
                                    <input type="text" name="identification" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Correo</label>
                                    <input type="email" name="email" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Teléfono</label>
                                    <input type="tel" name="phone" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Dirección</label>
                                    <textarea name="address" class="form-control"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Género</label>
                                    <select name="genero" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        <option value="O">Otro</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Tipo de Usuario</label>
                                    <select class="form-control" name="role_id">
                                        <option value="">Seleccione un rol</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= esc($role['id']) ?>"><?= esc($role['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
                            </div>
                        </div>

                        <!-- Tab 2: Matrícula -->
                        <div class="tab-pane fade" id="detail-banking" role="tabpanel">
                            <h5 class="text-primary">Información de Matrícula</h5>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="jornada">Jornada</label>
                                    <select class="form-control select2" id="jornada" name="jornada">
                                        <option value="">Seleccione Jornada</option>
                                        <?php foreach ($jornadas as $jornada): ?>
                                            <option value="<?= esc($jornada['id']) ?>"><?= esc($jornada['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gradoFormUpdate">Grado</label>
                                    <select class="form-control select2" id="gradoFormUpdate" name="gradoFormUpdate">
                                        <option value="">Selecciona...</option>
                                        <?php foreach ($grados as $grado): ?>
                                            <option value="<?= esc($grado['id']) ?>"><?= esc($grado['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="grupoFormUpdate">Grupo</label>
                                    <select class="form-control select2" id="grupoFormUpdate" name="grupoFormUpdate">
                                        <option value="">Selecciona...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha_matricula">Fecha de Matrícula</label>
                                    <input type="date" class="form-control" id="fecha_matricula" name="fecha_matricula">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
                            </div>
                        </div>

                        <!-- Tab 3: Sistema -->
                        <div class="tab-pane fade" id="detail-financial" role="tabpanel">
                            <h5 class="text-primary">Acceso al Sistema</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Selecciona estado</option>
                                        <option value="active">Activo</option>
                                        <option value="inactive">Inactivo</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>

                    </div> <!-- End Tabs -->
                </form>
            </div>
        </div>
    </div>
</div>

<script>


//Función: Cargar grupos por grado
    function cargarGruposPorGrado(gradoId) {
        const grupoSelect = $('#grupoFormUpdate');
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
            success: function (data) {
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
    // Evento: cambio de grado
    $('#gradoFormUpdate').on('change', function () {
        cargarGruposPorGrado($(this).val());
    });
$(function(){
    // =========================
    // Limpiar formulario al cerrar
    // =========================
    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
        $('#grupo').html('<option value="">Selecciona...</option>').trigger('change');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    });

    // =========================
    // Cargar datos en el modal
    // =========================
    function fillOutTheForm(id_client) {
        const url = '<?= base_url('admin/usermanagement/getInfoUser/') ?>' + id_client;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data) {
                    // Información básica
                    $('[name="name"]').val(data.name);
                    $('[name="identification"]').val(data.identification);
                    $('[name="email"]').val(data.email);
                    $('[name="phone"]').val(data.phone);
                    $('[name="address"]').val(data.address);
                    $('[name="genero"]').val(data.genero);
                    $('[name="fecha_nacimiento"]').val(data.fecha_nacimiento);
                    $('[name="role_id"]').val(data.role_id);

                    // Matrícula
                    $('[name="jornada"]').val(data.jornada).trigger('change');
                    $('[name="grado"]').val(data.grado).trigger('change');
                    $('[name="fecha_matricula"]').val(data.fecha_matricula);

                    // Sistema
                    $('[name="status"]').val(data.status);

                    $('#editModal').modal('show');
                } else {
                    alert('Error cargando datos del usuario');
                }
            },
            error: function() {
                alert('Error conectando con el servidor');
            }
        });
    }

    // =========================
    // Cargar grupos por grado
    // =========================
 
    // =========================
    // Botón Editar
    // =========================
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        const id_client = $(this).data('id');
        fillOutTheForm(id_client);
    });

    // =========================
    // Navegación entre tabs
    // =========================
    $('.next-tab').on('click', function() {
        let nextTabPane = $(this).closest('.tab-pane').next('.tab-pane');
        if (nextTabPane.length) $(`a[href="#${nextTabPane.attr('id')}"]`).click();
    });

    $('.prev-tab').on('click', function() {
        let prevTabPane = $(this).closest('.tab-pane').prev('.tab-pane');
        if (prevTabPane.length) $(`a[href="#${prevTabPane.attr('id')}"]`).click();
    });

    function toggleTabButtons() {
        $('.tab-pane').each(function(){
            if ($(this).hasClass('active')) {
                $(this).find('.prev-tab').prop('disabled', !$(this).prev('.tab-pane').length);
                $(this).find('.next-tab').prop('disabled', !$(this).next('.tab-pane').length);
            }
        });
    }
    $('#detailTab a').on('shown.bs.tab', toggleTabButtons);
    toggleTabButtons();

});
</script>
