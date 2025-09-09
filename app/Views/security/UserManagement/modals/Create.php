<!-- Modal de Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('admin/usermanagement/add') ?>" method="post" id="addUserForm">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Agregar Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- NAV TABS -->
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link <?= !old('role_id') || session('errors-insert') ? 'active' : '' ?>" data-toggle="tab" href="#client">Información Básica</a></li>
            <li class="nav-item <?= (old('role_id')=="2")?'':'d-none' ?>" id="tabMatricula"><a class="nav-link" data-toggle="tab" href="#matricula">Matrícula</a></li>
            <li class="nav-item <?= (old('role_id')=="3")?'':'d-none' ?>" id="tabAsignacion"><a class="nav-link" data-toggle="tab" href="#asignacion">Asignación</a></li>
            <li class="nav-item"><a class="nav-link <?= old('role_id') && !session('errors-insert') ? 'active' : '' ?>" data-toggle="tab" href="#system">Sistema</a></li>
          </ul>

          <div class="tab-content pt-3">

            <!-- TAB: Información Básica -->
            <div class="tab-pane fade show <?= !old('role_id') || session('errors-insert') ? 'active' : '' ?>" id="client">
              <div class="row">
                <div class="form-group col-md-4">
                  <label>Nombre</label>
                  <input type="text" class="form-control <?= session('errors-insert.name') ? 'is-invalid' : '' ?>"
                         name="name" value="<?= old('name') ?>" required>
                  <?php if(session('errors-insert.name')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.name') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Documento</label>
                  <input type="number" class="form-control <?= session('errors-insert.documento') ? 'is-invalid' : '' ?>"
                         name="documento" value="<?= old('documento') ?>" required>
                  <?php if(session('errors-insert.documento')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.documento') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Email</label>
                  <input type="email" class="form-control <?= session('errors-insert.email') ? 'is-invalid' : '' ?>"
                         name="email" value="<?= old('email') ?>" required>
                  <?php if(session('errors-insert.email')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.email') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Teléfono</label>
                  <input type="text" class="form-control <?= session('errors-insert.telefono') ? 'is-invalid' : '' ?>"
                         name="telefono" value="<?= old('telefono') ?>">
                  <?php if(session('errors-insert.telefono')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.telefono') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Dirección</label>
                  <input type="text" class="form-control <?= session('errors-insert.direccion') ? 'is-invalid' : '' ?>"
                         name="direccion" value="<?= old('direccion') ?>">
                  <?php if(session('errors-insert.direccion')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.direccion') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Género</label>
                  <select class="form-control <?= session('errors-insert.genero') ? 'is-invalid' : '' ?>"
                          name="genero" required>
                    <option value="">Selecciona...</option>
                    <option value="MASCULINO" <?= old('genero')=='MASCULINO'?'selected':'' ?>>Masculino</option>
                    <option value="FEMENINO" <?= old('genero')=='FEMENINO'?'selected':'' ?>>Femenino</option>
                  </select>
                  <?php if(session('errors-insert.genero')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.genero') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha de nacimiento</label>
                  <input type="date" class="form-control <?= session('errors-insert.fecha_nacimiento') ? 'is-invalid' : '' ?>"
                         name="fecha_nacimiento" value="<?= old('fecha_nacimiento') ?>" required>
                  <?php if(session('errors-insert.fecha_nacimiento')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.fecha_nacimiento') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Tipo de usuario</label>
                  <select class="form-control <?= session('errors-insert.role_id') ? 'is-invalid' : '' ?>"
                          id="inputTipoUsuario" name="role_id" required>
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $role): ?>
                      <option value="<?= esc($role['id']) ?>" <?= old('role_id')==$role['id']?'selected':'' ?>>
                        <?= esc($role['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.role_id')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.role_id') ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="text-right">
                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
              </div>
            </div>

            <!-- TAB: Matrícula -->
            <div class="tab-pane fade <?= old('role_id')=="2"?'show active':'' ?>" id="matricula">
              <div class="row">
                <div class="form-group col-md-4">
                  <label>Jornada</label>
                  <select class="form-control <?= session('errors-insert.jornada') ? 'is-invalid' : '' ?>"
                          name="jornada">
                    <option value="">Seleccione Jornada</option>
                    <?php foreach ($jornadas as $j): ?>
                      <option value="<?= $j['id'] ?>" <?= old('jornada')==$j['id']?'selected':'' ?>>
                        <?= esc($j['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.jornada')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.jornada') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Grado</label>
                  <select class="form-control <?= session('errors-insert.grado') ? 'is-invalid' : '' ?>"
                          id="gradoFormNew" name="grado">
                    <option value="">Selecciona...</option>
                    <?php foreach ($grados as $g): ?>
                      <option value="<?= $g['id'] ?>" <?= old('grado')==$g['id']?'selected':'' ?>>
                        <?= esc($g['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.grado')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.grado') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Grupo</label>
                  <select class="form-control <?= session('errors-insert.grupo') ? 'is-invalid' : '' ?>"
                          id="grupoFormNew" name="grupoFormNew"></select>
                  <?php if(session('errors-insert.grupo')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.grupo') ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
              </div>
            </div>

            <!-- TAB: Asignación -->
          <div class="tab-pane fade <?= old('role_id')=="3"?'show active':'' ?>" id="asignacion">
  <div class="row">
    
    <!-- Jornada -->
    <div class="form-group col-md-6">
      <label>Jornada</label>
      <select class="form-control <?= session('errors-insert.jornada') ? 'is-invalid' : '' ?>"
              name="jornada_asignacion">
        <option value="">Seleccione Jornada</option>
        <?php foreach ($jornadas as $j): ?>
          <option value="<?= $j['id'] ?>" <?= old('jornada')==$j['id']?'selected':'' ?>>
            <?= esc($j['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?php if(session('errors-insert.jornada')): ?>
        <div class="invalid-feedback"><?= session('errors-insert.jornada') ?></div>
      <?php endif; ?>
    </div>

    <!-- Grados / Grupos -->
    <div class="form-group col-md-6">
      <label>Grados / Grupos</label>
      <select class="form-control <?= session('errors-insert.grados') ? 'is-invalid' : '' ?>"
              id="gradosGrupos" name="grados[]" multiple>
        <?php foreach ($grados_grupos as $item): ?>
          <option value="<?= $item['id_grupo'] ?>" 
                  <?= in_array($item['id_grupo'], old('grados')??[]) ? 'selected' : '' ?>>
            <?= esc($item['grados_grupos']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?php if(session('errors-insert.grados')): ?>
        <div class="invalid-feedback d-block"><?= session('errors-insert.grados') ?></div>
      <?php endif; ?>
      
    </div>

  </div>

  <!-- Botones -->
  <div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
    <button type="button" class="btn btn-primary next-tab">Siguiente</button>
  </div>
</div>


            <!-- TAB: Sistema -->
            <div class="tab-pane fade <?= old('role_id') && !session('errors-insert') ? 'show active':'' ?>" id="system">
              <div class="form-group col-md-4">
                <label>Estado del Sistema</label>
                <select class="form-control <?= session('errors-insert.status') ? 'is-invalid' : '' ?>"
                        name="status" required>
                  <option value="active" <?= old('status')=='active'?'selected':'' ?>>Activo</option>
                  <option value="inactive" <?= old('status')=='inactive'?'selected':'' ?>>Inactivo</option>
                </select>
                <?php if(session('errors-insert.status')): ?>
                  <div class="invalid-feedback"><?= session('errors-insert.status') ?></div>
                <?php endif; ?>
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

<?php if (session('errors-insert')): ?>
<script>
$(document).ready(function() {
  $('#addUserModal').modal('show');

  // Activar pestaña correcta según el rol
  let role = "<?= old('role_id') ?>";
  if (role == "2") {
    $('.nav-tabs a[href="#client"]').tab('show');
  } else if (role == "3") {
    $('.nav-tabs a[href="#client"]').tab('show');
  } else {
    $('.nav-tabs a[href="#client"]').tab('show');
  }
});
</script>
<?php endif; ?>

<script>
$(function() {
  // Inicializar Select2
  $('#gradosGrupos').select2({
    width: '100%',
    placeholder: "Seleccione grados y grupos"
  });

  // Mostrar tabs según rol seleccionado
  function actualizarTabsPorRol(roleId) {
    $('#tabMatricula, #tabAsignacion').addClass('d-none');
    if (roleId == 2) $('#tabMatricula').removeClass('d-none');
    else if (roleId == 3) $('#tabAsignacion').removeClass('d-none');
  }

  $('#inputTipoUsuario').on('change', function() {
    actualizarTabsPorRol($(this).val());
  });

  // Navegación entre tabs
  $('.next-tab').on('click', function() {
    let $active = $('.nav-tabs .nav-link.active').parent();
    $active.nextAll(':visible').first().find('.nav-link').tab('show');
  });
  $('.prev-tab').on('click', function() {
    let $active = $('.nav-tabs .nav-link.active').parent();
    $active.prevAll(':visible').first().find('.nav-link').tab('show');
  });

  // Cargar grupos por grado
  $('#gradoFormNew').on('change', function() {
    let gradoId = $(this).val();
    let grupoSelect = $('#grupoFormNew');
    grupoSelect.html('<option>Cargando...</option>');

    if (!gradoId) return grupoSelect.html('<option value="">Selecciona un grado</option>');

    $.post("<?= base_url('admin/usermanagement/showComboBox') ?>", {
      tabla: 'grupos',
      campo: 'grado_id',
      id: gradoId,
      <?= csrf_token() ?>: "<?= csrf_hash() ?>"
    }, function(data) {
      grupoSelect.empty().append('<option value="">Selecciona...</option>');
      if (data.length) {
        data.forEach(g => grupoSelect.append(new Option(g.nombre, g.id)));
      } else {
        grupoSelect.append('<option>No hay grupos</option>');
      }
    }, 'json');
  });

  // Reset modal al cerrar
  $('#addUserModal').on('hidden.bs.modal', function() {
    this.querySelector('form').reset();
    $('#grupoFormNew').html('');
    $('#gradosGrupos').val(null).trigger('change');
  });

  // Inicializar visibilidad de tabs al cargar
  actualizarTabsPorRol($('#inputTipoUsuario').val());
});
</script>
