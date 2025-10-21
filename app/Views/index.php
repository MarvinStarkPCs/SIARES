<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIARES - Instituto Técnico Industrial "Lucio Pabón Nuñez"</title>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
      background: url('./img/banner.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      position: relative;
      overflow: hidden;
      animation: fadeInBody 2s ease forwards;
    }

    @keyframes fadeInBody {
      from { opacity: 0; transform: scale(1.02); }
      to { opacity: 1; transform: scale(1); }
    }

    .contenido {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      max-width: 800px;
      color: var(--blanco);
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
      animation: slideUp 1.2s ease forwards;
      opacity: 0;
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      color: var(--verde-claro);
      animation: fadeInText 1.5s ease forwards;
    }

    h2 {
      font-size: 1.3rem;
      margin-bottom: 20px;
      font-weight: 400;
      color: #e1ffe0;
      animation: fadeInText 2s ease forwards;
    }

    p {
      font-size: 1.2rem;
      line-height: 1.8;
      margin-bottom: 30px;
      color: #f1fff0;
      animation: fadeInText 2.5s ease forwards;
    }

    @keyframes fadeInText {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .btn-login {
      display: inline-block;
      background-color: var(--verde-claro);
      color: var(--verde);
      padding: 14px 32px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      font-size: 1.1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      transition: background 0.3s ease, transform 0.2s ease;
      animation: fadeInButton 3s ease forwards;
    }

    @keyframes fadeInButton {
      from { opacity: 0; transform: scale(0.9); }
      to { opacity: 1; transform: scale(1); }
    }

    .btn-login:hover {
      background-color: #c1f2b0;
      transform: scale(1.05);
    }

    .redes {
      margin-top: 25px;
      animation: fadeInSocial 3.5s ease forwards;
    }

    @keyframes fadeInSocial {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .redes a {
      color: var(--verde-claro);
      margin: 0 10px;
      font-size: 1.8rem;
      transition: transform 0.3s ease, color 0.3s ease;
      text-decoration: none;
    }

    .redes a:hover {
      transform: scale(1.2);
      color: #fff;
    }

    footer {
      position: absolute;
      bottom: 15px;
      width: 100%;
      text-align: center;
      color: #e0ffe0;
      font-size: 0.9rem;
      animation: fadeInFooter 4s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInFooter {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @media (max-width: 600px) {
      .contenido {
        padding: 25px 20px;
      }

      h1 {
        font-size: 2rem;
      }

      h2 {
        font-size: 1.1rem;
      }

      p {
        font-size: 1rem;
      }

      .btn-login {
        font-size: 1rem;
        padding: 12px 24px;
      }
    }
  </style>
</head>
<body>

  <div class="contenido">
    <h1>SIARES</h1>
    <h2>Instituto Técnico Industrial "Lucio Pabón Nuñez" – Ocaña</h2>
    <p>
      El <strong>SIARES (Sistema de Información para la Administración de los Residuos Sólidos de la Institución)</strong> es una plataforma que resalta el compromiso ambiental de nuestra institución. Promueve el reciclaje, la conciencia ecológica y la participación activa de los estudiantes.
      <br><br>
      🌿 Cada acción suma. Cada estudiante cuenta. Cada botella reciclada construye futuro.
    </p>

    <a href="login" class="btn-login">Ingresar al sistema</a>

    <div class="redes">
      <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook"></i></a>
      <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
    </div>
  </div>

  <footer>
    &copy; 2025 Instituto Técnico Industrial "Lucio Pabón Nuñez" – Proyecto SIARES
  </footer>

</body>
</html>
