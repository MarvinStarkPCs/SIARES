<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Estudiante</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --verde: #2A6322;
      --verde-claro: #d4f7c5;
      --blanco: #ffffff;
    }

    body {
      font-family: 'Ubuntu', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,50,0,0.6)),
                  url('<?= base_url('img/banner.jpg') ?>') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .container {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
      padding: 15px;
    }

    .card {
      background: rgba(0, 0, 0, 0.65);
      backdrop-filter: blur(12px);
      border: none;
      border-radius: 20px;
      color: var(--blanco);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 850px;
      overflow: hidden;
      opacity: 0;
      transform: translateY(50px);
      animation: slideUp 0.8s ease forwards;
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .card-header {
      background: transparent;
      border-bottom: 2px solid var(--verde-claro);
      text-align: center;
      padding: 25px 15px;
    }

    .card-header h4 {
      color: var(--verde-claro);
      font-weight: 700;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    }

    .card-body {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
      flex-wrap: wrap;
    }

    .logo-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-container img {
      max-width: 230px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
      transition: transform 0.4s ease;
    }

    .logo-container img:hover {
      transform: scale(1.05);
    }

    .form-container {
      flex: 2;
      min-width: 300px;
    }

    label {
      font-weight: bold;
      color: var(--verde-claro);
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    input, select {
      border-radius: 10px;
      border: none;
      outline: none;
      padding: 10px 12px;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.9);
      color: #333;
      transition: all 0.3s ease;
      width: 100%;
    }

    input:focus, select:focus {
      background: var(--blanco);
      box-shadow: 0 0 8px var(--verde-claro);
    }

    .btn-success {
      background: var(--verde-claro);
      color: var(--verde);
      font-weight: 700;
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      transition: 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .btn-success:hover {
      background: #baf3a5;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .card-body {
        flex-direction: column;
        text-align: center;
      }

      .logo-container img {
        max-width: 180px;
        margin-bottom: 20px;
      }

      .btn-success {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4><i class="fa-solid fa-user-graduate me-2"></i>Registro de Estudiante</h4>
      </div>

      <div class="card-body px-4 py-4">
        <div class="logo-container">
          <img src="<?= base_url('img/logo_siares.jpeg') ?>" alt="Logo SIARES">
        </div>

        <div class="form-container">
          
          <!-- ✅ Mensajes de éxito o error -->
          <?php if (session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fa-solid fa-circle-check me-2"></i><?= session('success') ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php elseif (session('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fa-solid fa-triangle-exclamation me-2"></i> Corrige los siguientes errores:
              <ul class="mb-0 mt-2">
                <?php foreach (session('errors') as $error): ?>
                  <li><?= esc($error) ?></li>
                <?php endforeach; ?>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <!-- ✅ Formulario -->
          <form action="<?= base_url('estudiantes/guardar') ?>" method="post">
            <?= csrf_field() ?>

            <div class="row mb-3">
              <div class="col-md-6">
                <label><i class="fa-solid fa-user"></i> Nombres</label>
                <input type="text" name="nombres" class="form-control"
                       placeholder="Ingresa tus nombres" value="<?= old('nombres') ?>" required>
              </div>
              <div class="col-md-6">
                <label><i class="fa-solid fa-user"></i> Apellidos</label>
                <input type="text" name="apellidos" class="form-control"
                       placeholder="Ingresa tus apellidos" value="<?= old('apellidos') ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label><i class="fa-solid fa-id-card"></i> Documento</label>
                <input type="text" name="documento" class="form-control"
                       placeholder="Número de documento" value="<?= old('documento') ?>" required>
              </div>
              <div class="col-md-6">
                <label><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control"
                       placeholder="correo@ejemplo.com" value="<?= old('email') ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="form-group col-md-4">
                <label>Grado</label>
                <select class="form-control" id="gradoFormNew" name="grado" required>
                  <option value="">Selecciona...</option>
                  <?php foreach ($grados as $g): ?>
                    <option value="<?= $g['id'] ?>" <?= old('grado') == $g['id'] ? 'selected' : '' ?>>
                      <?= esc($g['nombre']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label>Grupo</label>
                <select class="form-control" id="grupoFormNew" name="grupo" required></select>
              </div>

              <div class="form-group col-md-4">
                <label>Jornada</label>
                <select class="form-control" name="jornada" required>
                  <option value="">Seleccione Jornada</option>
                  <?php foreach ($jornadas as $j): ?>
                    <option value="<?= $j['id'] ?>" <?= old('jornada') == $j['id'] ? 'selected' : '' ?>>
                      <?= esc($j['nombre']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success px-5 py-2">
                <i class="fa-solid fa-paper-plane me-2"></i>Registrar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery & Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
     // Cargar grupos por grado dinámicamente
     $('#gradoFormNew').on('change', function() {
        let gradoId = $(this).val();
        let grupoSelect = $('#grupoFormNew');
        grupoSelect.html('<option>Cargando...</option>');

        if (!gradoId)
          return grupoSelect.html('<option value="">Selecciona un grado</option>');

        $.post("<?= base_url('usermanagement/showComboBox') ?>", {
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
  </script>
</body>
</html>
