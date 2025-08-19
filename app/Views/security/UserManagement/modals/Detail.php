<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Detail user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detailForm" method="post"
                    class="edit-form">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="editTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-client" data-toggle="tab" href="#edit-client"
                                role="tab">Informacion Basica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-banking" data-toggle="tab" href="#edit-banking"
                                role="tab">Matricula</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-financial" data-toggle="tab" href="#edit-financial"
                                role="tab">Sistema</a>
                        </li>

                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content pt-3" id="editTabContent">
                        <!-- Tab 1: info -->
                        <div class="tab-pane fade show active" id="edit-client" role="tabpanel">
                            <h5 class="text-primary">Informacion Basica</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre"
                                        class="form-control"
                                        value=""
                                        readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Documento</label>
                                    <input type="text" name="identification"
                                        class="form-control"
                                        value=""
                                        readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Correo</label>
                                    <input type="correo" name="correo"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Telefono</label>
                                    <input type="tel" name="telefono"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Direccion</label>
                                    <textarea name="address"
                                        class="form-control " readonly></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                  <div class="form-group col-md-4">
                                    <label>Genero</label>
                                    <input name="genero"
                                        class="form-control " readonly></input>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputFechaNacimiento">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control"
                                        id="inputFechaNacimiento" name="fecha_nacimiento" readonly>
                                </div>



                                <div class="form-group col-md-4">
                                    <label>Tipo de Usuario</label>
                                    <input type="text" name="role" class="form-control" readonly>
                                </div>


                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-tab">Previous</button>
                                <button type="button" class="btn btn-primary next-tab">Next</button>
                            </div>
                        </div>
                        <!-- Tab 2: matricula -->
                        <div class="tab-pane fade" id="edit-banking" role="tabpanel">
                            <h5 class="text-primary">Informacion de Matricula</h5>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label>Jornada</label>
                                    <input type="text" name="jornada"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Grado</label>
                                    <input type="text" name="grado"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Grupo</label>
                                    <input type="text" name="grupo"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputFechaNacimiento">Fecha de Matricula</label>
                                    <input type="date" class="form-control"
                                        id="inputFechaNacimiento" name="fecha_matricula" readonly>
                                </div>

                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-tab">Previous</button>
                                <button type="button" class="btn btn-primary next-tab">Next</button>
                            </div>
                        </div>
                        <!-- Tab 3: sistema-->
                        <div class="tab-pane fade" id="edit-financial" role="tabpanel">
                            <h5 class="text-primary">Acceso al Sistema</h5>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Estado</label>
                                    <input type="text" name="estado"
                                        class="form-control"
                                        readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary prev-tab">Previous</button>
                                <button type="button" class="btn btn-primary next-tab">Next</button>
                            </div>
                        </div>




                    </div> <!-- End Tabs -->
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            const id_client = $(this).data('id');

            const url = '<?= base_url('admin/usermanagement/getInfoUser/') ?>' + id_client;
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data) {
                        // Informacion Básica
                        $('#detailForm').find('input[name="nombre"]').val(data.estudiante);
                        $('#detailForm').find('input[name="identification"]').val(data.documento);
                        $('#detailForm').find('input[name="correo"]').val(data.email);
                        $('#detailForm').find('input[name="telefono"]').val(data.telefono);
                        $('#detailForm').find('textarea[name="address"]').val(data.direccion);
                        $('#detailForm').find('input[name="genero"]').val(data.genero);
                        $('#detailForm').find('input[name="fecha_nacimiento"]').val(data.fecha_nacimiento);
                        $('#detailForm').find('input[name="role"]').val(data.role); // <- ahora viene del backend

                        // Informacion de Matricula
                        $('#detailForm').find('input[name="jornada"]').val(data.jornada);
                        $('#detailForm').find('input[name="grado"]').val(data.grado);
                        $('#detailForm').find('input[name="grupo"]').val(data.grupo);
                        $('#detailForm').find('input[name="fecha_matricula"]').val(data.fecha_matricula);

                        // Acceso al sistema
                        $('#detailForm').find('input[name="estado"]').val(data.estado);

                        // Opcional: IDs ocultos
                        if ($('#detailForm').find('input[name="matricula_id"]').length === 0) {
                            $('#detailForm').append('<input type="hidden" name="matricula_id">');
                            $('#detailForm').append('<input type="hidden" name="estudiante_id">');
                        }
                        $('#detailForm').find('input[name="matricula_id"]').val(data.matricula_id);
                        $('#detailForm').find('input[name="estudiante_id"]').val(data.estudiante_id);
                    } else {
                        alert('Error loading user data');
                    }
                },
                error: function(err) {
                    console.error('Error connecting to server:', err);
                    alert('Error connecting to server');
                }
            });
        });
    });
</script>