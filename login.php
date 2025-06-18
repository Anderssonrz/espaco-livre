<?php
// O session_start() deve ser a PRIMEIRA coisa no arquivo.
session_start();
require_once("conexao.php"); // Sua conexão MySQLi ($conexao)

$feedback = null; // Variável para armazenar a mensagem de feedback

// --- LÓGICA DE CADASTRO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnCadastrar'])) {

  // 1. Coleta e valida os dados do formulário
  $nome = trim($_POST['nome'] ?? '');
  $cpf = trim($_POST['cpf'] ?? '');
  $telefone = trim($_POST['telefone'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $senha = $_POST['senha'] ?? '';
  // Considere adicionar um campo "Confirmar Senha" no seu HTML e a verificação aqui

  $erros = [];
  if (empty($nome)) {
    $erros[] = "O campo Nome é obrigatório.";
  }
  if (empty($cpf)) {
    $erros[] = "O campo CPF é obrigatório.";
  }
  if (empty($telefone)) {
    $erros[] = "O campo Telefone é obrigatório.";
  }
  if (empty($email)) {
    $erros[] = "O campo Email é obrigatório.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "O formato do Email é inválido.";
  }
  if (empty($senha)) {
    $erros[] = "O campo Senha é obrigatório.";
  } elseif (strlen($senha) < 8) {
    $erros[] = "A senha deve ter no mínimo 8 caracteres.";
  }

  if (!empty($erros)) {
    $feedback = ['type' => 'danger', 'message' => implode("<br>", $erros)];
  } else {
    // 2. Se a validação inicial passou, verifica se email ou CPF já existem
    $stmt_check = mysqli_prepare($conexao, "SELECT email, cpf FROM usuarios WHERE email = ? OR cpf = ?");
    mysqli_stmt_bind_param($stmt_check, "ss", $email, $cpf);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $existing_user = mysqli_fetch_assoc($result_check);
    mysqli_stmt_close($stmt_check);

    if ($existing_user) {
      if ($existing_user['email'] === $email) {
        $feedback = ['type' => 'danger', 'message' => 'Este e-mail já está em uso. Tente outro ou faça login.'];
      } elseif ($existing_user['cpf'] === $cpf) {
        $feedback = ['type' => 'danger', 'message' => 'Este CPF já pertence a outra conta.'];
      }
    } else {
      // 3. Se não há duplicados, insere o novo usuário
      $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

      $sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conexao, $sql);
      mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf, $telefone, $email, $senha_hash);

      if (mysqli_stmt_execute($stmt)) {
        // SUCESSO! Define a mensagem e redireciona
        $_SESSION['feedback_redirect'] = ['type' => 'success', 'message' => 'Cadastro realizado com sucesso! Por favor, faça o login.'];
        header("Location: login.php");
        exit();
      } else {
        $feedback = ['type' => 'danger', 'message' => 'Erro ao inserir no banco: ' . mysqli_error($conexao)];
      }
      mysqli_stmt_close($stmt);
    }
  }
}

// Verifica se há uma mensagem de feedback vinda de um redirecionamento
if (isset($_SESSION['feedback_redirect'])) {
  $feedback = $_SESSION['feedback_redirect'];
  unset($_SESSION['feedback_redirect']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./assets/css/login.css" />
  <title>Acessar | Espaço Livre</title>
  <style>
    /* Pequeno ajuste para o alerta não empurrar tanto o conteúdo */
    .signin-signup .alert {
      margin-bottom: 0.5rem;
      width: 100%;
      max-width: 380px;
    }

    /* Estilos básicos para alertas, inspirados no Bootstrap */
    .alert {
      position: relative;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      border: 1px solid transparent;
      border-radius: 0.375rem;
      width: 100%;
      max-width: 380px;
      font-size: 0.9rem;
      text-align: center;
    }

    .alert-success {
      color: #0f5132;
      background-color: #d1e7dd;
      border-color: #badbcc;
    }

    .alert-danger {
      color: #842029;
      background-color: #f8d7da;
      border-color: #f5c2c7;
    }

    .alert-warning {
      color: #664d03;
      background-color: #fff3cd;
      border-color: #ffc107;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form id="login-usuario-form" class="sign-in-form" method="POST">
          <h2 class="title">Entrar</h2>

          <div id="msgAlertErroLogin"></div>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" id="login_email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" id="login_senha" placeholder="Senha" required />
          </div>
          <input type="submit" value="Login" class="btn solid" />
        </form>

        <form action="login.php" method="POST" class="sign-up-form">
          <h2 class="title">Cadastre-se</h2>

          <div id="msgAlertCadastro"></div>

          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="nome" id="nome" placeholder="Nome Completo" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-id-card"></i>
            <input type="text" name="cpf" id="CPF" placeholder="CPF" required value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="text" name="telefone" id="telefone" placeholder="Telefone" required value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="signup_email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" id="signup_senha" placeholder="Senha (mín. 8 caracteres)" required minlength="8" />
          </div>
          <input type="submit" name="btnCadastrar" class="btn" value="Cadastrar" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Novo por aqui?</h3>
          <p>Clique abaixo para criar sua conta e encontrar a vaga perfeita!</p>
          <button class="btn transparent" id="sign-up-btn">Cadastrar</button>
        </div>
        <img src="assets/img_site/tablet.jpg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Já possui uma conta?</h3>
          <p>Clique abaixo para acessar sua conta e gerenciar suas vagas e reservas.</p>
          <button class="btn transparent" id="sign-in-btn">Entrar</button>
        </div>
        <img src="assets/img_site/celular.jpg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="./assets/js/login.js"></script>
  <script>
    $(document).ready(function() {
      // Máscaras para os campos de telefone e CPF
      $('#telefone').mask('(00) 00000-0000');
      $('#CPF').mask('000.000.000-00', {
        reverse: true
      });

      // --- LÓGICA DE EXIBIÇÃO DE FEEDBACK ---
      <?php if ($feedback): ?>
        // Cria a mensagem de alerta com as classes do Bootstrap
        const feedbackHtml = '<div class="alert alert-<?= htmlspecialchars($feedback['type']) ?> p-2 small" role="alert"><?= addslashes($feedback['message']) ?></div>';

        <?php if (isset($_POST['btnCadastrar'])): // Se foi uma tentativa de CADASTRO que gerou o feedback 
        ?>
          // Mostra a mensagem no formulário de CADASTRO e mantém a tela de cadastro
          $('#msgAlertCadastro').html(feedbackHtml);
          $('.container').addClass("sign-up-mode");
        <?php else: // Se o feedback veio de um redirect (sucesso no cadastro) ou erro de login 
        ?>
          // Mostra a mensagem no formulário de LOGIN e mantém a tela de login
          $('#msgAlertErroLogin').html(feedbackHtml);
          $('.container').removeClass("sign-up-mode");
        <?php endif; ?>
      <?php endif; ?>
    });
  </script>
</body>

</html>