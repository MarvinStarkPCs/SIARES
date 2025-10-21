<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow mb-4">
  <div class="card-header py-3 bg-dark-blue d-flex justify-content-between align-items-center">
    <h6 class="m-0 fw-bold text-primary">Resultados</h6>
  </div>

  <!-- 🔎 Filtros -->
  <div class="card-body" id="filtroCollapse" style="display: block;">
    <form class="row g-3 justify-content-center">
      <!-- Documento -->
      <div class="col-md-3">
        <label for="documento" class="form-label">
          <i class="fas fa-id-card me-1 text-primary"></i> Número de documento
        </label>
        <input type="number" id="documento" class="form-control" placeholder="Ingrese documento">
      </div>
      <!-- Grado -->
      <div class="col-md-3">
        <label for="grado" class="form-label">
          <i class="fas fa-user-graduate me-1 text-success"></i> Grado
        </label>
        <select id="grado" class="form-control select2">
          <option value="">Selecciona...</option>
          <?php foreach ($grados as $grado): ?>
            <option value="<?= esc($grado['id']) ?>"><?= esc($grado['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <!-- Grupo -->
      <div class="col-md-3">
        <label for="grupo" class="form-label">
          <i class="fas fa-users me-1 text-warning"></i> Grupo
        </label>
        <select id="grupo" class="form-control select2">
          <option value="">-- Seleccione --</option>
        </select>
      </div>
      <!-- Jornada -->
      <div class="col-md-3">
        <label for="jornada" class="form-label">
          <i class="fas fa-clock me-1 text-danger"></i> Jornada
        </label>
        <select id="jornada" class="form-control select2">
          <option value="">-- Seleccione --</option>
          <?php foreach ($jornadas as $jornada): ?>
            <option value="<?= esc($jornada['id']) ?>"><?= esc($jornada['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </form>

    <div class="row justify-content-center mt-3">
      <div class="col-md-2 text-center">
        <button type="button" class="btn btn-primary w-100" id="btnBuscar">
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

  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-3">
        <label for="periodo" class="form-label">
          <i class="fas fa-calendar me-1 text-danger"></i> Periodo
        </label>
        <select id="periodo" class="form-control select2">
          <option value="">-- Seleccione --</option>
          <?php foreach ($periodos as $periodo): ?>
            <option value="<?= esc($periodo['nombre']) ?>"><?= esc($periodo['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="button" class="btn btn-success w-100" id="btnExportarExcel">
          <i class="fas fa-file-excel me-1"></i> Exportar a Excel
        </button>
      </div>
    </div>

    <!-- 📊 Tabla -->
    <div class="table-responsive mt-4">
      <table id="dataTable2" class="table table-bordered" width="100%" cellspacing="0">
        <thead class="bg-primary text-white">
          <tr>
            <th>Documento</th>
            <th>Estudiante</th>
            <th>Curso</th>
            <th>Periodo</th>
            <th>Jornada</th>
            <th>Material</th>
            <th>Peso(G)</th>
          </tr>
        </thead>
        <tbody id="tablaResultados">
          <!-- tbody vacío para que lo maneje DataTables -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 🎨 Estilos -->
<style>
  .form-label {
    font-weight: 600;
    color: #333;
  }
  .form-control {
    border-radius: 8px;
    height: 42px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }
  .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78,115,223,.25);
  }
  .select2-container--default .select2-selection--single {
    border-radius: 8px;
    height: 42px;
    padding: 8px 12px;
    border: 1px solid #ced4da;
  }
  .card.bg-dark-blue {
    background-color: #1c1f26 !important;
    color: #fff;
  }
</style>

<!-- 🔌 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {

  $('#periodo').on('change', function () {
    let table = $('#dataTable2').DataTable();
    var valor = $(this).val();
    table.search(valor).draw();
    $('.dataTables_filter input').val(valor);
  });

  // 📥 Exportar a Excel
  $('#btnExportarExcel').on('click', function() {
    let table = $('#dataTable2').DataTable();
    let datos = table.rows({search: 'applied'}).data().toArray();

    if (datos.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Sin datos',
        text: 'No hay resultados para exportar. Realice una búsqueda primero.',
      });
      return;
    }

    // Preparar datos para Excel
    let excelData = [];
    
    // Agregar encabezados
    excelData.push(['Documento', 'Estudiante', 'Curso', 'Periodo', 'Jornada', 'Material', 'Peso(G)']);
    
    // Agregar filas de datos
    datos.forEach(row => {
      excelData.push(row);
    });

    // Crear libro de trabajo
    let wb = XLSX.utils.book_new();
    let ws = XLSX.utils.aoa_to_sheet(excelData);

    // Ajustar ancho de columnas
    ws['!cols'] = [
      {wch: 15}, // Documento
      {wch: 30}, // Estudiante
      {wch: 10}, // Curso
      {wch: 15}, // Periodo
      {wch: 15}, // Jornada
      {wch: 20}, // Material
      {wch: 10}  // Peso
    ];

    // Agregar hoja al libro
    XLSX.utils.book_append_sheet(wb, ws, 'Resultados');

    // Generar nombre de archivo con fecha
    let fecha = new Date().toISOString().slice(0, 10);
    let nombreArchivo = `resultados_${fecha}.xlsx`;

    // Descargar archivo
    XLSX.writeFile(wb, nombreArchivo);

    Swal.fire({
      icon: 'success',
      title: 'Exportación exitosa',
      text: `Se descargó el archivo ${nombreArchivo}`,
      timer: 2000,
      showConfirmButton: false
    });
  });

  // 🔄 Restaurar datos al cargar la página
  const data = JSON.parse(localStorage.getItem('resultadosData'));
  const filtros = JSON.parse(localStorage.getItem('resultadosFiltros'));

  if (data && filtros) {
    $('#documento').val(filtros.documento || '');
    $('#grado').val(filtros.grado || '').trigger('change');
    $('#grupo').val(filtros.grupo || '').trigger('change');
    $('#jornada').val(filtros.jornada || '').trigger('change');

    let tabla = $('#dataTable2').DataTable();
    tabla.clear();

    data.forEach(item => {
      tabla.row.add([
        item.Documento,
        item.Estudiante,
        item.Grado + item.Grupo,
        item.Periodo,
        item.Jornada,
        item.Material,
        item.Peso,
      ]);
    });

    tabla.draw();
  }

  // 👉 Buscar
  $('#btnBuscar').on('click', function () {
    const documento = $('#documento').val().trim();
    const grado = $('#grado').val();
    const grupo = $('#grupo').val();
    const jornada = $('#jornada').val();

    if (documento && (grado || grupo || jornada)) {
      Swal.fire({
        icon: 'warning',
        title: 'Filtros inválidos',
        text: 'Debe buscar solo por documento o solo por grado/grupo/jornada, no ambos.',
      });
      return;
    }

    if (!documento && (!grado || !grupo || !jornada)) {
      Swal.fire({
        icon: 'warning',
        title: 'Faltan filtros',
        text: 'Ingrese un documento o seleccione grado, grupo y jornada.',
      });
      return;
    }

    if (documento) {
      $('#grado, #grupo, #jornada').val('').trigger('change');
    }

    if (!documento && (grado && grupo && jornada)) {
      $('#documento').val('');
    }

    $.ajax({
      url: "./results/buscar",
      type: "POST",
      data: {
        documento: documento,
        grado: grado,
        grupo: grupo,
        jornada: jornada,
        <?= csrf_token() ?>: "<?= csrf_hash() ?>"
      },
      dataType: "json",
      success: function (data) {
        if (!data.length) {
          Swal.fire({
            icon: 'info',
            title: 'No se encontraron resultados',
            text: 'Intente con otros filtros.',
          });
        }
        let tabla = $('#dataTable2').DataTable();
        tabla.clear();

        console.log("Respuesta del servidor:", data);

        if (data.length) {
          data.forEach(item => {
            tabla.row.add([
              item.Documento,
              item.Estudiante,
              item.Grado + item.Grupo,
              item.Periodo,
              item.Jornada,
              item.Material,
              item.Peso,
            ]);
          });
        }

        tabla.draw();

        localStorage.setItem('resultadosData', JSON.stringify(data));
        localStorage.setItem('resultadosFiltros', JSON.stringify({
          documento: documento,
          grado: grado,
          grupo: grupo,
          jornada: jornada
        }));
      }
    });
  });

  // 🧹 Limpiar filtros
  $('#btnLimpiar').on('click', function () {
    $('#documento, #grado, #grupo, #jornada, #periodo').val('').trigger('change');
    let tabla = $('#dataTable2').DataTable();
    tabla.clear().draw();

    localStorage.removeItem('resultadosData');
    localStorage.removeItem('resultadosFiltros');
  });

  // Dependencia grado -> grupo
  $('#grado').on('change', function() {
    cargarGruposPorGrado($(this).val());
  });

  function cargarGruposPorGrado(gradoId) {
    const grupoSelect = $('#grupo');
    grupoSelect.empty().append('<option value="">Cargando...</option>');

    if (!gradoId) {
      grupoSelect.html('<option value="">Selecciona un grado</option>');
      return;
    }

    $.ajax({
      url: "../usermanagement/showComboBox",
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
});
</script>

<?= $this->endSection() ?>