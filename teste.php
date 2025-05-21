<?php
include_once("conexao.php");

// Iniciar a sessão para verificar se o usuário está logado
session_start();


// Filtros
$filtros = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
$filtro_cidade = $filtros['filter']['cidade'] ?? '';

// Condições SQL
$condicoes = [];

if (strlen($filtro_cidade)) {
  $condicoes[] = 'cidade LIKE "%' . str_replace(' ', '%', $filtro_cidade) . '%"';
}

// Cláusula Where
$where = !empty($condicoes) ? 'WHERE ' . implode(' AND ', $condicoes) : '';
?>


<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Página inicial do sistema de reservas de vagas" />
  <meta name="author" content="Seu Nome ou Nome da Empresa" />
  <title>Espaço Livre</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/custom.css" rel="stylesheet" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav justify-content-center">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <h4>HOME</h4>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <?php if (isset($_SESSION['id']) && $_SESSION['nivel_acesso'] == 2): ?>
            <li class="nav-item"><a class="nav-link" href="areaRestrita.php">Página Restrita</a></li>
          <?php else: ?>
            <li><a href="login.php"></a></li>
          <?php endif; ?>
        </ul>

        <form class="d-flex">
          <?php
          if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
            echo "<div class='dropdown'>";
            echo "<button class='btn btn-outline-dark dropdown-toggle' type='button' id='userDropdown' data-bs-toggle='dropdown' aria-expanded='false'>";
            echo "<i class='bi bi-person-fill me-1'></i> " . $_SESSION['nome'];
            echo "</button>";
            echo "<ul class='dropdown-menu dropdown-menu-end' aria-labelledby='userDropdown'>";
            echo "<li><a class='dropdown-item' href='buscaVagas.php'>Perfil do usuário</a></li>";
            echo "<li><hr class='dropdown-divider'></li>";
            echo "<li><a class='dropdown-item' href='sair.php'>Sair</a></li>";
            echo "</ul>";
            echo "</div>";
          } else {
            echo "<button type='button' class='btn btn-outline-dark' data-bs-toggle='modal' data-bs-target='#loginModal'>";
            echo "<i class='bi bi-person me-1'></i> Acessar";
            echo "</button>";
          }
          ?>
        </form>
      </div>

    </div>
  </nav>

  <header class="bg-dark py-1">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1>Encontre o espaço perfeito para seu veículo</h1>





















      </div>

    </div>
  </header>


  <div class="container px-4 px-lg-5 mt-5">

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="mb-3">
            <form method="GET" action="">
              <label for="cidade" class="form-label">Digite o nome da sua cidade</label>
              <div class="input-group">
                <input type="text" class="form-control mb-2" id="cidade" name="filter[cidade]"
                  autocomplete="off" value="<?= $filtro_cidade ?? '' ?>">

                <button class="btn btn-primary mb-2" type="submit">Filtrar</button>
                <a href="index.php" class="btn btn-outline-secondary mb-2">Limpar</a>
              </div>
            </form>




















          </div>
        </div>
      </div>







    </div>


      <!-- Cards das vagas -->
    <section class="py-5">
      <h2 class="fw-bolder mb-4">Vagas Disponíveis</h2>
      <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">
        <?php
        $sql_pesquisa = "SELECT * FROM `vagas` " . $where;
        $result = mysqli_query($conexao, $sql_pesquisa);
        while ($linha = mysqli_fetch_assoc($result)) {
        ?>

          <div class="col mb-5">
            <div class="card h-100">
              <?php
              $caminhoImagem = !empty($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg'; ?>
              <img class="card-img-top" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Imagem da vaga" style="height: 300px; object-fit: cover;" />



              <div class="card-body p-4">
                <div class="text-center">
                  <h5 class="fw-bolder"><?php echo $linha['descricao'] ?></h5>
                  <div class="d-flex justify-content-center small text-warning mb-2">
                    <?php

                    for ($i = 0; $i < 5; $i++) {
                      echo '<div class="bi-star-fill"></div>';
                    }
                    ?>
                  </div>
                  <span>R$<?php echo number_format($linha['preco'], 2, ',', '.') ?> por dia</span>
                  <br>
                  <small class="text-muted"><?php echo $linha['cidade'] ?>, <?php echo $linha['bairro'] ?></small>
                </div>
              </div>
              <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <!-- <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="reservar_vaga.php?id=<?php echo $linha['id'] ?>">Reservar Vaga</a></div> -->
              </div>
            </div>
          </div>
        <?php } ?>
        <?php if (mysqli_num_rows($result) > 0) { ?>
          <div class="col-12 text-center mt-4">
            <!-- <a href="listagemVagas.php" class="btn btn-outline-secondary">Ver Mais Vagas</a> -->
          </div>
        <?php } else { ?>
          <div class="col-12 text-center mt-4">
            <p class="lead">Nenhuma vaga disponível no momento.</p>
          </div>
        <?php } ?>
      </div>




  </div>

  </section>


  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Espaço Livre 2025</p>
    </div>
  </footer>

  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">LOGIN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="login-usuario-form">
            <span id="msgAlertErroLogin"></span>
            <div class="mb-3">
              <label for="email" class="col-form-label">Digite seu e-mail:</label>
              <input type="text" name="email" class="form-control" id="email" placeholder="E-mail">
            </div>
            <div class="mb-3">
              <label for="senha" class="col-form-label">Digite sua senha:</label>
              <input type="password" name="senha" class="form-control" id="senha" autocomplete="on" placeholder="Senha">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary" id="btnLogin">Acessar</button>
          <p class="mt-2"><a href="cadastrarUsuario.php">Criar uma conta</a></p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/custom.js"></script>
  <script>
    // Seu script custom.js pode conter a lógica para o login via AJAX
    document.addEventListener('DOMContentLoaded', function() {
      const btnLogin = document.getElementById('btnLogin');
      const loginForm = document.getElementById('login-usuario-form');
      const msgAlertErroLogin = document.getElementById('msgAlertErroLogin');

      if (btnLogin && loginForm && msgAlertErroLogin) {
        btnLogin.addEventListener('click', async (e) => {
          e.preventDefault();

          const dadosForm = new FormData(loginForm);

          const response = await fetch("validar_login.php", { // Crie este arquivo para validar o login
            method: "POST",
            body: dadosForm,
          });

          const data = await response.json();

          if (data.erro) {
            msgAlertErroLogin.innerHTML = `<div class="alert alert-danger">${data.msg}</div>`;
          } else {
            // Login bem-sucedido, redirecionar ou atualizar a página
            window.location.href = "index.php"; // Redireciona para a página inicial
          }
        });
      }
    });
  </script>





</body>

</html>