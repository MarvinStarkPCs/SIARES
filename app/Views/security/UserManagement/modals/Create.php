<!-- Modal de Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="./usermanagement/add" method="post" id="addUserForm">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Agregar Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- NAV TABS -->
          <ul class="nav nav-tabs" id="userTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#client" role="tab">Información Básica</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#matricula" role="tab">Matrícula</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#system" role="tab">Sistema</a>
            </li>
          </ul>

          <div class="tab-content pt-3">

            <!-- TAB: Información Básica -->
            <div class="tab-pane fade show active" id="client" role="tabpanel">
              <h5 class="text-primary">Información Básica</h5>
              <div class="row">

                <!-- Nombre -->
                <div class="form-group col-md-4">
                  <label for="inputName">Nombre</label>
                  <input type="text" class="form-control <?= session('errors-insert.name') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputName" name="name" value="<?= esc(old('name')) ?>" placeholder="Nombre">
                  <?= session('errors-insert.name') ? '<div class="invalid-feedback">' . esc(session('errors-insert.name')) . '</div>' : '' ?>
                </div>

                <!-- Documento -->
                <div class="form-group col-md-4">
                  <label for="inputDocumento">Documento</label>
                  <input type="number" class="form-control <?= session('errors-insert.documento') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputDocumento" name="documento" value="<?= esc(old('documento')) ?>" placeholder="Documento">
                  <?= session('errors-insert.documento') ? '<div class="invalid-feedback">' . esc(session('errors-insert.documento')) . '</div>' : '' ?>
                </div>

                <!-- Email -->
                <div class="form-group col-md-4">
                  <label for="inputEmail">Email</label>
                  <input type="email" class="form-control <?= session('errors-insert.email') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputEmail" name="email" value="<?= esc(old('email')) ?>" placeholder="Email">
                  <?= session('errors-insert.email') ? '<div class="invalid-feedback">' . esc(session('errors-insert.email')) . '</div>' : '' ?>
                </div>

                <!-- Teléfono -->
                <div class="form-group col-md-4">
                  <label for="inputTelefono">Teléfono</label>
                  <input type="text" class="form-control <?= session('errors-insert.telefono') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputTelefono" name="telefono" value="<?= esc(old('telefono')) ?>" placeholder="Teléfono">
                  <?= session('errors-insert.telefono') ? '<div class="invalid-feedback">' . esc(session('errors-insert.telefono')) . '</div>' : '' ?>
                </div>

                <!-- Dirección -->
                <div class="form-group col-md-4">
                  <label for="inputDireccion">Dirección</label>
                  <input type="text" class="form-control <?= session('errors-insert.direccion') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputDireccion" name="direccion" value="<?= esc(old('direccion')) ?>" placeholder="Dirección">
                  <?= session('errors-insert.direccion') ? '<div class="invalid-feedback">' . esc(session('errors-insert.direccion')) . '</div>' : '' ?>
                </div>

                <!-- Género -->
                <div class="form-group col-md-4">
                  <label for="inputGenero">Género</label>
                  <select class="form-control <?= session('errors-insert.genero') ? 'is-invalid errors-insert' : '' ?>" 
                          id="inputGenero" name="genero">
                    <option value="">Selecciona...</option>
                    <option value="MASCULINO" <?= old('genero') == 'MASCULINO' ? 'selected' : '' ?>>Masculino</option>
                    <option value="FEMENINO" <?= old('genero') == 'FEMENINO' ? 'selected' : '' ?>>Femenino</option>
                  </select>
                  <?= session('errors-insert.genero') ? '<div class="invalid-feedback">' . esc(session('errors-insert.genero')) . '</div>' : '' ?>
                </div>

                <!-- Fecha de nacimiento -->
                <div class="form-group col-md-4">
                  <label for="inputFechaNacimiento">Fecha de Nacimiento</label>
                  <input type="date" class="form-control <?= session('errors-insert.fecha_nacimiento') ? 'is-invalid errors-insert' : '' ?>" 
                         id="inputFechaNacimiento" name="fecha_nacimiento" value="<?= esc(old('fecha_nacimiento')) ?>">
                </div>

                <!-- Tipo de usuario -->
                <div class="form-group col-md-4">
                  <label for="inputTipoUsuario">Tipo de Usuario</label>
                  <select class="form-control" id="inputTipoUsuario" name="role_id">
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= esc($role['id']) ?>" <?= old('role_id') == $role['id'] ? 'selected' : '' ?>>
                            <?= esc($role['name']) ?>
                        </option>
                    <?php endforeach; ?>
                  </select>
                </div>

              </div>
              <div class="text-right">
                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
              </div>
            </div>

            <!-- TAB: Matrícula -->
            <div class="tab-pane fade" id="matricula" role="tabpanel">
              <h5 class="text-primary">Datos de Matrícula</h5>
              <div class="row" id="matriculaFields">
                <div class="form-group col-md-4">
                  <label for="jornada">Jornada</label>
                  <select class="form-control select2" id="jornada" name="jornada">
                    <option value="">Seleccione Jornada</option>
                    <?php foreach ($jornadas as $jornada): ?>
                        <option value="<?= esc($jornada['id']) ?>" <?= old('jornada') == $jornada['id'] ? 'selected' : '' ?>>
                            <?= esc($jornada['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                  </select> 
                </div>

                <div class="form-group col-md-4">
                  <label for="grado">Grado</label>
                  <select class="form-control select2" id="grado" name="grado">
                    <option value="">Selecciona...</option>
                    <?php foreach ($grados as $grado): ?>
                        <option value="<?= esc($grado['id']) ?>" <?= old('grado') == $grado['id'] ? 'selected' : '' ?>>
                            <?= esc($grado['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label for="grupo">Grupo</label>
                  <select class="form-control select2" id="grupo" name="grupo">
                    <option value="">Selecciona...</option>
                  </select>
                </div>

                <div class="form-group col-md-4">
                  <label for="fecha_matricula">Fecha de Matrícula</label>
                  <input type="date" class="form-control" id="fecha_matricula" name="fecha_matricula" value="<?= esc(old('fecha_matricula')) ?>">
                </div>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
              </div>
            </div>

            <!-- TAB: Sistema -->
            <div class="tab-pane fade" id="system" role="tabpanel">
              <h5 class="text-primary">Acceso al Sistema</h5>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="selectStatus">Estado del Sistema</label>
                  <select class="form-control" id="selectStatus" name="status">
                    <option value="active" <?= old('status') == 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= old('status') == 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                  </select>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                <button type="submit" class="btn btn-success">Guardar Usuario</button>
              </div>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // Función: Cargar grupos por grado
    function cargarGruposPorGrado(gradoId) {
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
    $('#grado').on('change', function () {
        cargarGruposPorGrado($(this).val());
    });

    // Función: Navegación entre pestañas
    function cambiarPestaña(direccion) {
        let actual = document.querySelector('.nav-tabs .nav-link.active').parentElement;
        let destino = (direccion === 'next') ? actual.nextElementSibling : actual.previousElementSibling;
        if (destino) destino.querySelector('.nav-link').click();
    }

    document.querySelectorAll('.next-tab').forEach(btn => btn.addEventListener('click', () => cambiarPestaña('next')));
    document.querySelectorAll('.prev-tab').forEach(btn => btn.addEventListener('click', () => cambiarPestaña('prev')));

    // Mostrar modal si hay errores
    const form = document.getElementById('addUserForm');
    if (form && form.querySelector('input.errors-insert, select.errors-insert, textarea.errors-insert')) {
        $('#addUserModal').modal('show'); // Abre modal directo
        console.log('Modal abierto por errores de validación.');
    }
});



</script>