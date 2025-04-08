<?php
// require_once("conexao-bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <!-- Título -->
<?php
  $pageTitle = 'Acesse sua Conta - Espaço Livre';
  include 'head.php';
?>

    <!-- Head -->
  <?php include 'head.php'; ?>

<body>


  <!-- Navbar -->
  <?php include 'navbar.php'; ?>

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