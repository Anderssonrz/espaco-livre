<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Locação de Vagas</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS personalizado -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Locação de Vagas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro.php">Cadastrar Vaga</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="busca.php">Buscar Vagas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Container principal -->
    <div class="container mt-5">

        <!-- Carrossel de Imagens -->
        <div id="vagaCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="assets/images/vaga1.jpg" class="d-block w-100" alt="Vaga 1">
            </div>
            <div class="carousel-item">
              <img src="assets/images/vaga2.jpg" class="d-block w-100" alt="Vaga 2">
            </div>
            <div class="carousel-item">
              <img src="assets/images/vaga3.jpg" class="d-block w-100" alt="Vaga 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#vagaCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#vagaCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próxima</span>
          </button>
        </div>

        <!-- Card de Informações da Vaga -->
        <div class="card mb-3" style="width: 18rem;">
          <img src="assets/images/vaga1.jpg" class="card-img-top" alt="Imagem da Vaga">
          <div class="card-body">
            <h5 class="card-title">Vaga no Centro</h5>
            <p class="card-text">Preço: R$15/hora. Localização: Av. Paulista, São Paulo.</p>
            <a href="detalhes_vaga.php" class="btn btn-primary">Ver Detalhes</a>
          </div>
        </div>

        <!-- Formulário de Cadastro de Vaga -->
        <h3 class="mt-5">Cadastrar Vaga</h3>
        <form action="cadastro.php" method="POST" class="p-4 border rounded">
          <div class="mb-3">
            <label for="localizacao" class="form-label">Localização</label>
            <input type="text" class="form-control" id="localizacao" name="localizacao" required>
          </div>
          <div class="mb-3">
            <label for="preco" class="form-label">Preço por Hora</label>
            <input type="number" class="form-control" id="preco" name="preco" required>
          </div>
          <div class="mb-3">
            <label for="disponibilidade" class="form-label">Disponibilidade</label>
            <input type="text" class="form-control" id="disponibilidade" name="disponibilidade">
          </div>
          <button type="submit" class="btn btn-success">Cadastrar Vaga</button>
        </form>

        <!-- Botão e Modal para Cadastro de Usuário -->
        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#cadastroModal">
          Cadastre-se
        </button>

        <!-- Modal -->
        <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cadastroModalLabel">Cadastro de Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="cadastro.php" method="POST">
                  <div class="mb-3">
                    <label for="username" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Botão com Tooltip -->
        <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Clique para ver mais informações">
          Vaga Info
        </button>

    </div>

    <!-- Bootstrap JavaScript com Popper.js para interatividade -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript personalizado -->
    <script src="assets/js/script.js"></script>

    <script>
      // Ativar tooltips ao carregar a página
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    </script>

</body>
</html>
