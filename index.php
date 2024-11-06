<?php
//require_once("conexao-bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espaço Livre</title>
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- CSS personalizado -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- JS -->
  <link href="assets/js/main.js" rel="stylesheet">


</head>


<body>

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
  </div>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero bg-light text-center py-5">
      <div class="container">
        <h1 class="display-4">Localize Vagas de Estacionamento</h1>
        <p class="lead">Encontre e reserve o estacionamento perfeito para você.</p>
        <main class="container my-5">
          <section>
            <form class="row g-3" action="busca.php" method="GET">
              <div class="col-md-10">
                <input type="text" class="form-control" placeholder="Digite sua localização ou destino" required name="localizacao">
              </div>
              <div class="col-md-1">
                <button type="submit" class="btn btn-primary btn-lg">Buscar</button>
              </div>
            </form>
          </section>
      </div>
    </div>
  </section>

  <section class="user">
    <!-- Features Section -->
    <div class="container my-5">
      <div class="row">
        <div class="col-md-4 text-center">
          <h3>Fácil de Usar</h3>
          <p>Reserve seu estacionamento em apenas alguns cliques.</p>
        </div>
        <div class="col-md-4 text-center">
          <h3>Preços Competitivos</h3>
          <p>Compare os preços e encontre a melhor oferta.</p>
        </div>
        <div class="col-md-4 text-center">
          <h3>Suporte 24/7</h3>
          <p>Estamos aqui para ajudar sempre que precisar.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-light text-center py-4">
    <div class="container">
      <p>&copy; 2024 Espaco Livre. Todos os direitos reservados.</p>
      <a href="#">Termos de Serviço</a> | <a href="#">Política de Privacidade</a>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Arquivos JS do fornecedor -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Arquivo JS principal do modelo -->
  <script src="assets/js/main.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</body>

</html>