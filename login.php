<?php
//require_once("conexao-bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Usuário</title>
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS personalizado -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- Bootstrap JS Bundle (incluso o Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <style>
    /* Estilo para o formulário */
    .login-form-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 0 auto;
    }

    .form-header {
      font-size: 24px;
      font-weight: bold;
      color: #333;
    }

    /* Ajustes para os botões */
    .btn-primary,
    .btn-secondary {
      width: 100%;
    }

    /* Estilo para a navbar */
    nav {
      background-color: #f8f9fa;
    }

    /* Estilo para links */
    a {
      color: #5E9BCF;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    /* Customização para a checkbox */
    .form-check-label {
      font-size: 14px;
    }
  </style>
</head>

<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">Espaço<br>Livre</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#hero">Sobre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#user">Suporte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-black" href="login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Formulário de Login -->
  <div class="container mt-5">
    <div class="login-form-container">
      <h2 class="form-header text-center mb-4">Entrar</h2>
      <form action="/" method="post">
        <!-- Campo de Email -->
        <div class="mb-3">
          <label for="login-email" class="form-label">Email</label>
          <input type="email" id="login-email" class="form-control" required>
        </div>

        <!-- Campo de Senha -->
        <div class="mb-3">
          <label for="login-password" class="form-label">Senha</label>
          <input type="password" id="login-password" class="form-control" required>
        </div>

        <!-- Checkbox de "Lembrar de mim" e link de "Esqueceu a senha" -->
        <div class="d-flex justify-content-between mb-3">
          <div>
            <input type="checkbox" id="remember-me">
            <label for="remember-me" class="form-check-label">Lembrar de mim</label>
          </div>
          <a href="#" class="form-check-label">Esqueceu a senha?</a>
        </div>

        <!-- Botão -->
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
        <a href="registro.php" class="btn btn-secondary mt-3 w-100">Cadastrar-se</a>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>