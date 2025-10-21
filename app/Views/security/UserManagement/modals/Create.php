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
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#client" id="tabInfoBasica">Información Básica</a>
            </li>
            <li class="nav-item d-none" id="tabMatricula">
              <a class="nav-link" data-toggle="tab" href="#matricula">Matrícula</a>
            </li>
            <li class="nav-item d-none" id="tabAsignacion">
              <a class="nav-link" data-toggle="tab" href="#asignacion">Asignación</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#system" id="tabSistema">Sistema</a>
            </li>
          </ul>

          <div class="tab-content pt-3">

            <!-- TAB: Información Básica -->
            <div class="tab-pane fade show active" id="client">
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
                  <label>Apellido</label>
                  <input type="text" class="form-control <?= session('errors-insert.last_name') ? 'is-invalid' : '' ?>"
                         name="last_name" value="<?= old('last_name') ?>" required>
                  <?php if(session('errors-insert.last_name')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.last_name') ?></div>
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
            <div class="tab-pane fade" id="matricula">
              <div class="row">
                <div class="form-group col-md-4">
                  <label>Jornada</label>
                  <select class="form-control <?= session('errors-insert.jornada_id') ? 'is-invalid' : '' ?>"
                          name="jornada_id" id="jornadaMatricula">
                    <option value="">Seleccione Jornada</option>
                    <?php foreach ($jornadas as $j): ?>
                      <option value="<?= $j['id'] ?>" <?= old('jornada_id')==$j['id']?'selected':'' ?>>
                        <?= esc($j['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.jornada_id')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.jornada_id') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Grado</label>
                  <select class="form-control <?= session('errors-insert.grado_id') ? 'is-invalid' : '' ?>"
                          id="gradoFormNew" name="grado_id">
                    <option value="">Selecciona...</option>
                    <?php foreach ($grados as $g): ?>
                      <option value="<?= $g['id'] ?>" <?= old('grado_id')==$g['id']?'selected':'' ?>>
                        <?= esc($g['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.grado_id')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.grado_id') ?></div>
                  <?php endif; ?>
                </div>

                <div class="form-group col-md-4">
                  <label>Grupo</label>
                  <select class="form-control <?= session('errors-insert.grupo_id') ? 'is-invalid' : '' ?>"
                          id="grupoFormNew" name="grupo_id">
                    <option value="">Selecciona un grado primero</option>
                  </select>
                  <?php if(session('errors-insert.grupo_id')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.grupo_id') ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary prev-tab">Anterior</button>
                <button type="button" class="btn btn-primary next-tab">Siguiente</button>
              </div>
            </div>

            <!-- TAB: Asignación -->
            <div class="tab-pane fade" id="asignacion">
              <div class="row">
                
                <!-- Jornada -->
                <div class="form-group col-md-6">
                  <label>Jornada</label>
                  <select class="form-control <?= session('errors-insert.jornada_asignacion') ? 'is-invalid' : '' ?>"
                          name="jornada_asignacion" id="jornadaAsignacion">
                    <option value="">Seleccione Jornada</option>
                    <?php foreach ($jornadas as $j): ?>
                      <option value="<?= $j['id'] ?>" <?= old('jornada_asignacion')==$j['id']?'selected':'' ?>>
                        <?= esc($j['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <?php if(session('errors-insert.jornada_asignacion')): ?>
                    <div class="invalid-feedback"><?= session('errors-insert.jornada_asignacion') ?></div>
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
            <div class="tab-pane fade" id="system">
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
});
</script>
<?php endif; ?>

<script>
$(function() {
  let isInitializing = false;
  
  // Inicializar Select2
  $('#gradosGrupos').select2({
    width: '100%',
    placeholder: "Seleccione grados y grupos"
  });

  // Mostrar tabs según rol seleccionado
  function actualizarTabsPorRol(roleId) {
    $('#tabMatricula, #tabAsignacion').addClass('d-none');
    if (roleId == 2) {
      $('#tabMatricula').removeClass('d-none');
    } else if (roleId == 3) {
      $('#tabAsignacion').removeClass('d-none');
    }
  }

  // Cargar grupos por grado
  function cargarGruposPorGrado(gradoId, grupoSeleccionado = null) {
    let grupoSelect = $('#grupoFormNew');
    
    if (!gradoId) {
      grupoSelect.html('<option value="">Selecciona un grado primero</option>');
      return;
    }

    grupoSelect.html('<option>Cargando...</option>').prop('disabled', true);

    $.post("<?= base_url('admin/usermanagement/showComboBox') ?>", {
      tabla: 'grupos',
      campo: 'grado_id',
      id: gradoId,
      <?= csrf_token() ?>: "<?= csrf_hash() ?>"
    }, function(data) {
      grupoSelect.empty().append('<option value="">Selecciona...</option>').prop('disabled', false);
      
      if (data && data.length) {
        data.forEach(function(g) {
          let option = new Option(g.nombre, g.id);
          if (grupoSeleccionado && g.id == grupoSeleccionado) {
            option.selected = true;
          }
          grupoSelect.append(option);
        });
      } else {
        grupoSelect.append('<option value="">No hay grupos disponibles</option>');
      }
    }, 'json').fail(function() {
      grupoSelect.html('<option value="">Error al cargar grupos</option>').prop('disabled', false);
    });
  }

  // Evento change del select de grado
  $('#gradoFormNew').on('change', function() {
    if (!isInitializing) {
      cargarGruposPorGrado($(this).val());
    }
  });

  // Evento change del tipo de usuario
  $('#inputTipoUsuario').on('change', function() {
    let roleId = $(this).val();
    actualizarTabsPorRol(roleId);
    
    // Limpiar campos según el rol
    if (roleId == 2) {
      // Si cambió a Estudiante, limpiar campos de Asignación
      $('#jornadaAsignacion').val('');
      $('#gradosGrupos').val(null).trigger('change');
    } else if (roleId == 3) {
      // Si cambió a Profesor, limpiar campos de Matrícula
      $('#jornadaMatricula').val('');
      $('#gradoFormNew').val('');
      $('#grupoFormNew').html('<option value="">Selecciona un grado primero</option>');
    } else {
      // Si no es ni Estudiante ni Profesor, limpiar todo
      $('#jornadaMatricula, #jornadaAsignacion, #gradoFormNew').val('');
      $('#grupoFormNew').html('<option value="">Selecciona un grado primero</option>');
      $('#gradosGrupos').val(null).trigger('change');
    }
  });

  // Navegación entre tabs
  $('.next-tab').on('click', function() {
    let $active = $('.nav-tabs .nav-link.active').parent();
    let $next = $active.nextAll(':visible').first();
    if ($next.length) {
      $next.find('.nav-link').tab('show');
    }
  });

  $('.prev-tab').on('click', function() {
    let $active = $('.nav-tabs .nav-link.active').parent();
    let $prev = $active.prevAll(':visible').first();
    if ($prev.length) {
      $prev.find('.nav-link').tab('show');
    }
  });

  // Reset modal al cerrar
  $('#addUserModal').on('hidden.bs.modal', function() {
    if (!<?= session('errors-insert') ? 'true' : 'false' ?>) {
      this.querySelector('form').reset();
      $('#grupoFormNew').html('<option value="">Selecciona un grado primero</option>');
      $('#gradosGrupos').val(null).trigger('change');
      actualizarTabsPorRol('');
    }
  });

  // Inicialización al cargar la página
  $(document).ready(function() {
    isInitializing = true;
    
    // Actualizar visibilidad de tabs
    let roleId = $('#inputTipoUsuario').val();
    actualizarTabsPorRol(roleId);
    
    // Si hay un grado seleccionado (por old()), cargar sus grupos
    let gradoSeleccionado = "<?= old('grado_id') ?>";
    let grupoSeleccionado = "<?= old('grupo_id') ?>";
    
    if (gradoSeleccionado && roleId == 2) {
      cargarGruposPorGrado(gradoSeleccionado, grupoSeleccionado);
    }
    
    isInitializing = false;
  });
});
</script>