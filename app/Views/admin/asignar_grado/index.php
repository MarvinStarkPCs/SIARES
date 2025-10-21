<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow mb-4">
  <div class="card-header py-3 bg-dark-blue d-flex justify-content-between align-items-center">
    <h6 class="m-0 fw-bold text-primary">Resultados</h6>
  </div>

  <!-- 🔎 Filtros -->
  <div class="card-body" id="filtroCollapse">
    <form class="row g-3 justify-content-center">
      <!-- Documento -->
      <div class="col-md-3">
        <label for="documento" class="form-label">
          <i class="fas fa-id-card me-1 text-primary"></i> Número de documento
        </label>
        <input type="number" id="documento" class="form-control" placeholder="Ingrese documento">
      </div>
    </form>

    <div class="row justify-content-center mt-3">
      <div class="col-md-2 text-center">
        <button type="button" class="btn btn-warning w-100" id="btnBuscar">
          <i class="fas fa-search me-1"></i> Buscar
        </button>
      </div>
      <div class="col-md-2 text-center">
        <button type="button" class="btn btn-secondary w-100" id="btnLimpiar">
          <i class="fas fa-broom me-1"></i> Limpiar
        </button>
      </div>
    </div>
  </div>

  <!-- 📊 Resultados con Grid -->
  <div class="card-body">
    <div id="resultadosContainer" class="mt-4"></div>
  </div>
</div>

<!-- 📌 Modal Grupos -->
<div class="modal fade" id="modalAsignaturas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark-blue text-white">
        <h5 class="modal-title">Grupos del Profesor</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="formAsignaturas">
        <div class="modal-body">
          <input type="hidden" id="profesor_id" name="profesor_id">

          <!-- Grados / Grupos -->
          <div class="form-group col-md-6">
            <label>Grados / Grupos</label>
            <select class="form-control" id="gradosGrupos" name="grados[]" multiple>
              <?php foreach ($grados_grupos as $item): ?>
                <option value="<?= $item['id_grupo'] ?>">
                  <?= esc($item['grados_grupos']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

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
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 🎨 Estilos -->
<style>
  .form-label { font-weight: 600; color: #333; }
  .form-control { border-radius: 8px; height: 42px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); }
  .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78,115,223,.25);
  }
  .card.bg-dark-blue { background-color: #1c1f26 !important; color: #fff; }
  
  /* Estilos para el card del profesor */
  .profesor-card {
    border: 2px solid #e3e6f0;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    background: #fff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
  }
  
  .profesor-header {
    border-bottom: 2px solid #4e73df;
    padding-bottom: 15px;
    margin-bottom: 20px;
  }
  
  .profesor-nombre {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
  }
  
  .profesor-info {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 15px;
  }
  
  .info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #5a5c69;
    font-size: 0.95rem;
  }
  
  .info-item i {
    color: #4e73df;
    width: 20px;
  }
  
  /* Grid de grupos */
  .grupos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 15px;
    margin-top: 15px;
  }
  
  .grupo-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    padding: 18px;
    color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .grupo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.25);
  }
  
  .grupo-grado {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .grupo-detalle {
    font-size: 0.95rem;
    opacity: 0.95;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 5px;
  }
  
  .jornada-badge {
    display: inline-block;
    background: rgba(255,255,255,0.25);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-top: 8px;
  }
  
  .btn-editar-grupos {
    margin-top: 15px;
  }
  
  .no-resultados {
    text-align: center;
    padding: 40px;
    color: #858796;
  }
  
  .no-resultados i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #dddfeb;
  }
</style>

<!-- 🔌 Script -->
<script>
$(document).ready(function() {
  console.log("✅ jQuery está cargado!");

  // Inicializar Select2
  $('#gradosGrupos').select2({
    placeholder: "Selecciona grupos",
    allowClear: true,
    width: '100%',
    dropdownParent: $('#modalAsignaturas')
  });

  // 👉 Buscar profesor por documento
  $('#btnBuscar').on('click', function () {
    const documento = $('#documento').val().trim();
    if (!documento) {
      mostrarAlerta('warning','Por favor ingrese el número de documento.');
      return;
    }

    $.ajax({
      url: "./asignaciones/buscar",
      type: "POST",
      data: {
        documento: documento,
        <?= csrf_token() ?>: "<?= csrf_hash() ?>"
      },
      dataType: "json",
      success: function (data) {
        console.log("Respuesta recibida:", data);
        
        const container = $('#resultadosContainer');
        container.empty();

        if (data.length) {
          data.forEach(item => {
            const html = generarCardProfesor(item);
            container.append(html);
          });
        } else {
          container.html(`
            <div class="no-resultados">
              <i class="fas fa-search"></i>
              <h5>No se encontraron resultados</h5>
              <p>Intenta con otro número de documento</p>
            </div>
          `);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        mostrarAlerta('error','Error en la búsqueda.');
      }
    });
  });

  // 👉 Función para generar el HTML del card del profesor
  function generarCardProfesor(item) {
    // Parsear los grupos asignados
    const gruposArray = item.grupos_asignados 
      ? item.grupos_asignados.split(',').map(g => g.trim()) 
      : [];
    
    let gruposHTML = '';
    if (gruposArray.length > 0) {
      gruposArray.forEach(grupo => {
        // Extraer información del grupo (ejemplo: "Grado 8° - Grupo 2 - Jornada Mañana")
        const partes = grupo.split(' - ');
        const grado = partes[0] || 'Grado';
        const grupoNum = partes[1] || 'Grupo';
        const jornada = partes[2] || 'Jornada';
        
        gruposHTML += `
          <div class="grupo-card">
            <div class="grupo-grado">
              <i class="fas fa-graduation-cap"></i>
              ${grado}
            </div>
            <div class="grupo-detalle">
              <i class="fas fa-users"></i>
              ${grupoNum}
            </div>
            <div class="jornada-badge">
              <i class="fas fa-clock"></i> ${jornada}
            </div>
          </div>
        `;
      });
    } else {
      gruposHTML = '<p class="text-muted">No hay grupos asignados</p>';
    }

    return `
      <div class="profesor-card">
        <div class="profesor-header">
          <div class="profesor-nombre">
            <i class="fas fa-user-tie me-2"></i>${item.nombre_profesor}
          </div>
          <div class="profesor-info">
            <div class="info-item">
              <i class="fas fa-id-card"></i>
              <span><strong>Documento:</strong> ${item.documento}</span>
            </div>
            <div class="info-item">
              <i class="fas fa-envelope"></i>
              <span>${item.email || '—'}</span>
            </div>
            <div class="info-item">
              <i class="fas fa-phone"></i>
              <span>${item.telefono || '—'}</span>
            </div>
          </div>
        </div>
        
        <div>
          <h6 class="mb-3"><i class="fas fa-chalkboard-teacher me-2"></i>Grupos Asignados:</h6>
          <div class="grupos-grid">
            ${gruposHTML}
          </div>
        </div>
        
        <button class="btn btn-warning btn-editar-grupos btnAsignaturas" 
          data-id="${item.profesor_id}" 
          data-grupos="${item.grupos_asignados}">
          <i class="fas fa-edit me-1"></i> Editar Grupos
        </button>
      </div>
    `;
  }

  // 👉 Limpiar búsqueda
  $('#btnLimpiar').on('click', function () {
    $('#documento').val('');
    $('#resultadosContainer').empty();
  });

  // 👉 Abrir modal y cargar grupos del profesor
  $(document).on('click', '.btnAsignaturas', function () {
    const profesorId = $(this).data('id');
    const gruposStr = $(this).attr('data-grupos') || '';

    $('#profesor_id').val(profesorId);
    $('#gradosGrupos').val([]).trigger('change');

    if (gruposStr) {
      const gruposArr = gruposStr.split(',').map(id => id.trim());
      $('#gradosGrupos').val(gruposArr).trigger('change');
    }

    $('#modalAsignaturas').modal('show');
  });

  // 👉 Guardar cambios
  $('#formAsignaturas').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: "./asignaciones/guardarAsignaturas",
      type: "POST",
      data: $(this).serialize() + "&<?= csrf_token() ?>=<?= csrf_hash() ?>",
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          mostrarAlerta('success', response.msg || 'Grupos actualizados correctamente');
          $('#modalAsignaturas').modal('hide');

          setTimeout(() => {
            location.reload();
          }, 2000);
        } else if (response.status === 'error') {
          // Mostrar mensaje de error con los grupos en conflicto
          const mensaje = response.msg.replace(/\n/g, '<br>');
          
          Swal.fire({
            icon: 'warning',
            title: '⚠️ Grupos ya asignados',
            html: mensaje,
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#f6c23e',
            width: '600px'
          });
        }
      },
      error: function (xhr) {
        let errorMsg = 'Error al guardar los grupos';
        
        if (xhr.responseJSON && xhr.responseJSON.msg) {
          errorMsg = xhr.responseJSON.msg;
        }
        
        mostrarAlerta('error', errorMsg);
      }
    });
  });
});
</script>

<?= $this->endSection() ?>