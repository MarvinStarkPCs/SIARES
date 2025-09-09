<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Registro de Materiales</h5>
    </div>
    <div class="card-body">
      
      <form id="formReciclaje">

        <!-- Grados / Grupos -->
        <div class="form-group">
          <label>Grados / Grupos</label>
          <select id="gradosGrupos" name="grupo_id" class="form-control" required>
            <option value="">Seleccione Grado/Grupo</option>
            <?php foreach ($grados_grupos as $item): ?>
              <option value="<?= $item['grupo_id'] ?>"><?= esc($item['grado_grupo']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Estudiantes (dinámico) -->
        <div class="form-group">
          <label>Estudiante</label>
          <select name="estudiante_id" id="estudiante_id" class="form-control" required>
            <option value="">Seleccione primero Jornada y Grado</option>
          </select>
        </div>

        <!-- Datos del estudiante -->
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="grado">Grado</label>
            <input type="text" id="grado" class="form-control" readonly>
          </div>
          <div class="form-group col-md-3">
            <label for="grupo">Grupo</label>
            <input type="text" id="grupo" class="form-control" readonly>
          </div>
          <div class="form-group col-md-3">
            <label for="jornada_txt">Jornada</label>
            <input type="text" id="jornada_txt" class="form-control" readonly>
          </div>
          <div class="form-group col-md-3">
            <label for="estudiante_txt">Estudiante</label>
            <input type="text" id="estudiante_txt" class="form-control" readonly>
          </div>
          <input type="hidden" id="matricula" name="matricula">
        </div>

        <hr>

        <!-- Selector de período -->
        <div class="form-group">
          <label for="periodo_id">Selecciona un período:</label>
          <select name="periodo_id" id="periodo_id" class="form-control" required>
            <?php foreach ($periodos as $p): ?>
              <option value="<?= $p['id'] ?>"><?= esc($p['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Material y Peso -->
        <div class="form-row align-items-end">
          <div class="form-group col-md-5">
            <label for="material">Tipo de Material</label>
            <select id="material" name="material_id" class="form-control" required>
              <option value="">Seleccione</option>
              <?php foreach ($materiales as $mat): ?>
                <option value="<?= $mat['id'] ?>"><?= $mat['nombre'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="peso">Peso (g)</label>
            <input type="number" id="peso" min="1" class="form-control" placeholder="0" required>
          </div>
          <div class="form-group col-md-2">
            <button type="button" class="btn btn-success btn-block" id="agregarBtn">+</button>
          </div>
        </div>

        <!-- Tabla materiales -->
        <div class="card mt-3 shadow">
          <div class="card-header bg-dark text-white">
            <h6 class="mb-0">Materiales Registrados</h6>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped mb-0" id="tablaMateriales">
              <thead class="thead-light">
                <tr>
                  <th>Grado</th>
                  <th>Grupo</th>
                  <th>Jornada</th>
                  <th>Estudiante</th>
                  <th>Material</th>
                  <th>Peso (g)</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

        <!-- Guardar -->
        <div class="mt-3 text-right">
          <button type="button" class="btn btn-primary" id="guardarBtn">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {


  $('#estudiante_id').select2({
        placeholder: "Escribe para buscar...",
        allowClear: true,
        width: 'resolve' // hace que tome el ancho del select original
      });
  // ---------- Cargar estudiantes dinámicamente ----------
  $("#gradosGrupos").on("change", function () {
    let grupo_id = $(this).val();
    if (!grupo_id) {
      $("#estudiante_id").html('<option value="">Seleccione primero Grado/Grupo</option>');
      return;
    }
    $.ajax({
      url: "<?= base_url('docente/reciclaje/getEstudiantes') ?>",
      type: "GET",
      data: { grupo_id: grupo_id },
      dataType: "json",
      success: function (resp) {
        let options = '<option value="">Seleccione Estudiante</option>';
        $.each(resp, function (i, est) {
          options += `<option value="${est.matricula_id}" 
                        data-grado="${est.grado}" 
                        data-grupo="${est.grupo}" 
                        data-jornada="${est.jornada}" 
                        data-matricula="${est.matricula_id}"
                        data-nombre="${est.nombre_estudiante}">
                        ${est.nombre_estudiante} - ${est.documento}
                      </option>`;
        });
        $("#estudiante_id").html(options);
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudieron cargar los estudiantes."
        });
      }
    });
  });

  // ---------- Rellenar datos al elegir estudiante ----------
  $("#estudiante_id").on("change", function () {
    let sel = $(this).find("option:selected");
    $("#grado").val(sel.data("grado") || "");
    $("#grupo").val(sel.data("grupo") || "");
    $("#jornada_txt").val(sel.data("jornada") || "");
    $("#estudiante_txt").val(sel.data("nombre") || "");
    $("#matricula").val(sel.data("matricula") || "");
  });

  // ---------- Agregar material al grid ----------
  $("#agregarBtn").on("click", function () {
    let grado = $("#grado").val();
    let grupo = $("#grupo").val();
    let jornada = $("#jornada_txt").val();
    let estudiante = $("#estudiante_txt").val();
    let matricula = $("#matricula").val();
    let material_id = $("#material").val();
    let material_txt = $("#material option:selected").text();
    let peso = parseFloat($("#peso").val());

    if (!matricula) {
      Swal.fire("Atención", "Debes seleccionar un estudiante.", "warning");
      return;
    }
    if (!material_id) {
      Swal.fire("Atención", "Debes seleccionar un material.", "warning");
      return;
    }
    if (!peso || peso <= 0) {
      Swal.fire("Atención", "Debes ingresar un peso válido.", "warning");
      return;
    }

    // Validar duplicados
    let existe = false;
    $("#tablaMateriales tbody tr").each(function () {
      let mat = $(this).find('input[name="material_id[]"]').val();
      let matri = $(this).find('input[name="matricula[]"]').val();
      if (mat === material_id && matri === matricula) {
        existe = true;
        return false;
      }
    });
    if (existe) {
      Swal.fire("Atención", "Este material ya fue registrado para el estudiante.", "warning");
      return;
    }

    // Agregar fila
    let fila = `
      <tr>
        <td>${grado}<input type="hidden" name="grado[]" value="${grado}"></td>
        <td>${grupo}<input type="hidden" name="grupo[]" value="${grupo}"></td>
        <td>${jornada}<input type="hidden" name="jornada[]" value="${jornada}"></td>
        <td>${estudiante}<input type="hidden" name="estudiante[]" value="${estudiante}">
            <input type="hidden" name="matricula[]" value="${matricula}">
        </td>
        <td>${material_txt}<input type="hidden" name="material_id[]" value="${material_id}"></td>
        <td>${peso}<input type="hidden" name="peso[]" value="${peso}"></td>
        <td><button type="button" class="btn btn-danger btn-sm borrarBtn">X</button></td>
      </tr>
    `;
    $("#tablaMateriales tbody").append(fila);

    $("#material").val("");
    $("#peso").val("");
  });

  // ---------- Eliminar fila ----------
  $(document).on("click", ".borrarBtn", function () {
    $(this).closest("tr").remove();
  });

  // ---------- Guardar datos ----------
  $("#guardarBtn").on("click", function () {
    let filas = [];
    $("#tablaMateriales tbody tr").each(function () {
      filas.push({
        matricula_id: $(this).find('input[name="matricula[]"]').val(),
        material_id: $(this).find('input[name="material_id[]"]').val(),
        peso_total: $(this).find('input[name="peso[]"]').val(),
        periodo_id: $("#periodo_id").val()
      });
    });

    if (filas.length === 0) {
      Swal.fire("Atención", "No hay materiales agregados para guardar.", "warning");
      return;
    }

    $.ajax({
      url: "<?= base_url('docente/reciclaje/guardarMateriales') ?>",
      type: "POST",
      data: { materiales: filas },
      dataType: "json",
      success: function (resp) {
        console.log(resp);
        if (resp.success) {

          Swal.fire("Éxito", "Materiales guardados correctamente.", "success") ;
        } else {
          Swal.fire("Error", resp.msg || "No se pudo guardar.");
        }
      },
      error: function () {
        Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
      }
    });
  });

});


</script>



<?= $this->endSection() ?>
