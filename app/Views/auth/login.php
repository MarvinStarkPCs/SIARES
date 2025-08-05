<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - SIARES</title>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
 <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"> -->

    <!-- CSS de Select2 (si lo usas) -->

    <!-- Custom styles for this template -->
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url( 'css/partials/loader.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/partials/alert.css') ?>" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <style>
    :root {
      --verde: #2A6322;
      --verde-claro: #d4f7c5;
      --blanco: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Ubuntu', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,50,0,0.5)), url('./img/banner.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
    }

    .login-box {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      max-width: 400px;
      width: 100%;
      color: var(--blanco);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: var(--verde-claro);
      text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: none;
      outline: none;
      font-size: 1rem;
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background-color: var(--verde-claro);
      color: var(--verde);
      font-weight: bold;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .btn-submit:hover {
      background-color: #c1f2b0;
      transform: scale(1.03);
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #d4f7c5;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 500px) {
      .login-box {
        padding: 30px 20px;
      }

      .btn-submit {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

 <?= view('partials/alert') ?>

  <div class="login-box">
    <h2>Iniciar sesión</h2>
    <form method="post" action="<?= base_url('authenticate') ?>">
      <div class="form-group">
        <label for="email">Correo institucional</label>
        <input type="email" id="email" name="email" required placeholder="ejemplo@instituto.edu.co">
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>

      <button type="submit" class="btn-submit">Entrar</button>
    </form>

    <a href="/" class="back-link">← Volver al inicio</a>
  </div>
    <!-- Scripts -->

    <script src="<?= base_url('assets/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>


    <!-- Custom alerts -->
    <script src="<?= base_url('js/demo/alert_custom.js') ?>"></script>
</body>
</html>
