<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Registro de Materiales</h5>
    </div>
    <div class="card-body">

      <!-- Búsqueda de estudiante -->
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="documento">Tarjeta de Identidad</label>
          <input type="text" id="documento" class="form-control" placeholder="Número de documento">
        </div>
        <div class="form-group col-md-2 d-flex align-items-end">
          <button type="button" class="btn btn-info btn-block" id="buscarBtn">Buscar</button>
        </div>
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
          <label for="jornada">Jornada</label>
          <input type="text" id="jornada" class="form-control" readonly>
        </div>
        <div class="form-group col-md-3">
          <label for="estudiante">Estudiante</label>
          <input type="text" id="estudiante" class="form-control" readonly>
        </div>
        <input type="hidden" id="matricula" readonly>
      </div>

      <hr>

      <!-- Selector de período -->
      <div class="form-group">
        <label for="periodo_id">Selecciona un período:</label>
        <select name="periodo_id" id="periodo_id" class="form-control">
            <?php foreach ($periodos as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= esc($p['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
      </div>

      <!-- Campos Material y Peso -->
      <div class="form-row align-items-end">
        <div class="form-group col-md-5">
          <label for="material">Tipo de Material</label>
          <select id="material" name="material_id" class="form-control">
            <option value="">Seleccione</option>
            <?php foreach ($materiales as $mat): ?>
              <option value="<?= $mat['id'] ?>"><?= $mat['nombre'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group col-md-3">
          <label for="peso">Peso (g)</label>
          <input type="number" id="peso" min="1" class="form-control" placeholder="0">
        </div>
        <div class="form-group col-md-2">
          <button type="button" class="btn btn-success btn-block" id="agregarBtn">+</button>
        </div>
      </div>

      <!-- Grid -->
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

      <!-- Botón Guardar -->
      <div class="mt-3 text-right">
        <button type="button" class="btn btn-primary" id="guardarBtn">
          <i class="fas fa-save"></i> Guardar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- jQuery + SweetAlert2 -->
<script>
  // ---------- Función central: obtener datos del formulario ----------
  function getDatosEstudiante() {
    return {
      grado: $("#grado").val(),
      grupo: $("#grupo").val(),
      jornada: $("#jornada").val(),
      estudiante: $("#estudiante").val(),
      matricula_id: $("#matricula").val(),
      periodo_id: $("#periodo_id").val()
    };
  }

  // ---------- Buscar estudiante ----------
  $("#buscarBtn").on("click", function () {
    let documento = $("#documento").val();
    if (!documento.trim()) {
      Swal.fire({ icon: "info", title: "Atención", text: "Ingrese la tarjeta de identidad." });
      return;
    }

    $.getJSON("<?= base_url('docente/reciclaje/buscar') ?>/" + documento, function (data) {
      if (data.success) {
        $("#grado").val(data.estudiante.grado);
        $("#grupo").val(data.estudiante.grupo);
        $("#jornada").val(data.estudiante.jornada);
        $("#estudiante").val(data.estudiante.nombre);
        $("#matricula").val(data.estudiante.matricula_id);

        Swal.fire({ icon: "success", title: "Estudiante encontrado", text: "Se cargaron los datos.", timer: 2000, showConfirmButton: false });
      } else {
        Swal.fire({ icon: "warning", title: "No encontrado", text: "No existe estudiante con ese documento." });
      }
    }).fail(function () {
      Swal.fire({ icon: "error", title: "Error", text: "Hubo un problema al consultar el estudiante." });
    });
  });

  // ---------- Agregar material ----------
  $("#agregarBtn").on("click", function () {
    let datos = getDatosEstudiante();
    let material = $("#material option:selected").text();
    let materialId = $("#material").val();
    let peso = $("#peso").val();

    if (!datos.matricula_id || !materialId || !peso) {
      Swal.fire({ icon: "warning", title: "Campos incompletos", text: "Debe buscar estudiante, seleccionar período y completar material y peso." });
      return;
    }

    // Evitar duplicados
    let existe = false;
    $("#tablaMateriales tbody tr").each(function () {
      let matIdFila = $(this).find("td:eq(4)").data("matid");
      if (matIdFila == materialId) existe = true;
    });

    if (existe) {
      Swal.fire({ icon: "warning", title: "Material duplicado", text: "Este material ya está registrado." });
      return;
    }

    let fila = `
      <tr>
        <td>${datos.grado}</td>
        <td>${datos.grupo}</td>
        <td>${datos.jornada}</td>
        <td>${datos.estudiante}</td>
        <td data-matid="${materialId}">${material}</td>
        <td>${peso}</td>
        <td><button class="btn btn-sm btn-danger eliminarBtn">Eliminar</button></td>
      </tr>
    `;
    $("#tablaMateriales tbody").append(fila);

    // 🔒 Bloquear período al agregar el primer material
    if ($("#tablaMateriales tbody tr").length === 1) {
      $("#periodo_id").prop("disabled", true);
      Swal.fire({ icon: "info", title: "Período bloqueado", text: "El período ya no se puede cambiar hasta guardar o eliminar todos los materiales." });
    }

    $("#material").val("");
    $("#peso").val("");

    Swal.fire({ icon: "success", title: "Agregado", text: "El material fue agregado.", timer: 1200, showConfirmButton: false });
  });

  // ---------- Eliminar fila ----------
  $(document).on("click", ".eliminarBtn", function () {
    let fila = $(this).closest("tr");
    Swal.fire({
      title: "¿Eliminar material?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar"
    }).then((r) => {
      if (r.isConfirmed) {
        fila.remove();

        // 🔓 Si la tabla queda vacía, desbloquear período
        if ($("#tablaMateriales tbody tr").length === 0) {
          $("#periodo_id").prop("disabled", false);
        }
      }
    });
  });

  // ---------- Guardar materiales ----------
  $("#guardarBtn").on("click", function () {
    let materiales = [];
    let datos = getDatosEstudiante();

    $("#tablaMateriales tbody tr").each(function () {
      materiales.push({
        matricula_id: datos.matricula_id,
        periodo_id: datos.periodo_id,
        material_id: $(this).find("td:eq(4)").data("matid"),
        peso: $(this).find("td:eq(5)").text()
      });
    });

    if (materiales.length === 0) {
      Swal.fire({ icon: "warning", title: "Nada que guardar", text: "Agregue al menos un material." });
      return;
    }
    console.log(materiales);

    $.ajax({
      url: "<?= base_url('docente/reciclaje/guardar') ?>",
      method: "POST",
      data: { materiales: materiales },
      dataType: "json",
      success: function (resp) {
        if (resp.success) {
          Swal.fire({ icon: "success", title: "Guardado", text: "Los materiales fueron registrados.", timer: 2000, showConfirmButton: false });
          $("#tablaMateriales tbody").empty();

          // 🔓 Desbloquear período al limpiar la tabla
          $("#periodo_id").prop("disabled", false);
        } else {
          Swal.fire({ icon: "error", title: "Error", text: resp.message || "No se pudieron guardar los materiales." });
        }
      },
      error: function () {
        Swal.fire({ icon: "error", title: "Error", text: "Hubo un problema en el servidor." });
      }
    });
  });
</script>


<?= $this->endSection() ?>
