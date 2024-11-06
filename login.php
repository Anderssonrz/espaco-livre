<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login e Cadastro · Estacionamento</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Espaço<br>Livre</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

<body class="bg-light">
  <div class="container container-custom">
    <div class="row">
      <!-- Login Form -->
      <div class="col-md-6">
        <div class="form-section">
          <h2 class="form-header text-center mb-4">Entrar</h2>
          <form action="/" method="post">
            <div class="mb-3">
              <label for="login-email" class="form-label">Email</label>
              <input type="email" id="login-email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="login-password" class="form-label">Senha</label>
              <input type="password" id="login-password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div>
                <input type="checkbox" id="remember-me">
                <label for="remember-me">Lembrar de mim</label>
              </div>
              <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
          </form>
        </div>
      </div>

      <!-- Cadastro Form -->
      <div class="col-md-6">
        <div class="form-section">
          <h2 class="form-header text-center mb-4">Cadastre-se</h2>
          <form action="/" method="post">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="first-name" class="form-label">Nome</label>
                <input type="text" id="first-name" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="last-name" class="form-label">Sobrenome</label>
                <input type="text" id="last-name" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="signup-email" class="form-label">Email</label>
              <input type="email" id="signup-email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="signup-password" class="form-label">Senha</label>
              <input type="password" id="signup-password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>