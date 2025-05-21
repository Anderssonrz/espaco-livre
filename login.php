<?php
require_once("conexao.php");

if (isset($_POST['btnCadastrar'])) {
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $telefone = $_POST['telefone'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conexao, $sql);
  mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf, $telefone, $email, $senha);

  if (mysqli_stmt_execute($stmt)) {
    header("Location: login.php?cadastro=sucesso");
    exit();
  } else {
    $msgErroCadastro = "Erro ao inserir: " . mysqli_error($conexao);
  }

  mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./assets/css/login.css" />
  <title>Espaço Livre</title>
</head>

<body>
  <div class="container">
    <!-- FORMULÁRIOS -->
    <div class="forms-container">
      <div class="signin-signup">

        <!-- FORMULÁRIO DE LOGIN -->
        <form id="login-usuario-form" class="sign-in-form" method="POST">
          <h2 class="title">Entrar</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" id="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" id="senha" placeholder="Senha" required />
          </div>
          <div id="msgAlertErroLogin"></div>
          <input type="submit" value="Login" class="btn solid" />
        </form>

        <!-- FORMULÁRIO DE CADASTRO -->
        <form action="login.php" method="POST" class="sign-up-form">
          <h2 class="title">Cadastre-se</h2>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="nome" id="nome" placeholder="Nome Completo" required />
          </div>

          <div class="input-field">
            <i class="fas fa-id-card"></i>
            <input type="text" name="cpf" id="CPF" placeholder="CPF" required />
          </div>

          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" required />
          </div>

          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required />
          </div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" id="senha" placeholder="Senha" required />
          </div>

          <input type="submit" name="btnCadastrar" class="btn" value="Cadastrar" />

          <?php
          if (!empty($msgErroCadastro)) {
            echo "<div class='alert alert-danger'>$msgErroCadastro</div>";
          }
          ?>
        </form>
      </div>
    </div>

    <!-- PAINÉIS DE TROCA DE TELA -->
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Novo por aqui?</h3>
          <p>Click abaixo para cadastrar</p>
          <button class="btn transparent" id="sign-up-btn">Cadastrar</button>
        </div>
        <img src="assets/img_site/tablet.jpg" class="image" alt="" />
      </div>

      <div class="panel right-panel">
        <div class="content">
          <h3>Já possui cadastro?</h3>
          <p>Click abaixo para entrar</p>
          <button class="btn transparent" id="sign-in-btn">Entrar</button>
        </div>
        <img src="assets/img_site/celular.jpg" class="image" alt="" />
      </div>
    </div>
  </div>

  <?php
  if (isset($_GET['cadastro']) && $_GET['cadastro'] == 'sucesso') {
    echo "<div class='alert alert-success'>Cadastro realizado com sucesso! Faça login.</div>";
  }
  ?>

  <!-- SCRIPTS -->
  <script src="./assets/js/login.js"></script>
    <!-- Maskara do cadatro -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#telefone').mask('(00) 00000-0000');
      $('#CPF').mask('000.000.000-00', {
        reverse: true
      });
    });
  </script>
</body>

</html>