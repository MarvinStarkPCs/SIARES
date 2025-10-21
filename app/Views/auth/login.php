<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - SIARES</title>

  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('assets/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('css/partials/loader.css') ?>" rel="stylesheet">
  <link href="<?= base_url('css/partials/alert.css') ?>" rel="stylesheet">

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

    /* --- ANIMACIONES --- */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes backgroundMove {
      0% { background-position: center; }
      50% { background-position: center 10px; }
      100% { background-position: center; }
    }

    @keyframes floatLogo {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    /* --- BODY --- */
    body {
      font-family: 'Ubuntu', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,50,0,0.5)), url('./img/banner.jpg') no-repeat center center fixed;
      background-size: cover;
      animation: fadeIn 1.2s ease-out, backgroundMove 10s infinite ease-in-out alternate;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
    }

    /* --- CONTENEDOR LOGIN --- */
    .login-box {
      background: rgba(0, 0, 0, 0.65);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      max-width: 400px;
      width: 100%;
      color: var(--blanco);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      animation: slideUp 1s ease forwards;
      text-align: center;
    }

    /* --- LOGO --- */
    .login-box img {
      width: 110px;
      height: auto;
      margin-bottom: 20px;
      border-radius: 50%;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      animation: fadeIn 1.5s ease, floatLogo 4s ease-in-out infinite;
    }

    .login-box h2 {
      margin-bottom: 25px;
      color: var(--verde-claro);
      text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
      animation: fadeIn 1.5s ease;
    }

    /* --- CAMPOS DE FORMULARIO --- */
    .form-group {
      margin-bottom: 20px;
      text-align: left;
      animation: fadeIn 2s ease;
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
      transition: all 0.3s ease;
    }

    .form-group input:focus {
      box-shadow: 0 0 10px var(--verde-claro);
      transform: scale(1.02);
    }

    /* --- BOTÓN --- */
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
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      animation: fadeIn 2.3s ease;
    }

    .btn-submit:hover {
      background-color: #c1f2b0;
      transform: scale(1.05);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4);
    }

    /* --- LINK ATRÁS --- */
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #d4f7c5;
      text-decoration: none;
      font-size: 0.9rem;
      opacity: 0;
      animation: fadeIn 2.6s forwards;
    }

    .back-link:hover {
      text-decoration: underline;
      color: #e0ffce;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 500px) {
      .login-box {
        padding: 30px 20px;
      }

      .btn-submit {
        font-size: 1rem;
      }

      .login-box img {
        width: 90px;
      }
    }
  </style>
</head>
<body>

  <?= view('partials/alert') ?>

  <div class="login-box">
    <img src="./img/logo_siares.jpeg" alt="Logo SIARES">
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

  <script src="<?= base_url('assets/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
  <script src="<?= base_url('js/demo/alert_custom.js') ?>"></script>

</body>
</html>
