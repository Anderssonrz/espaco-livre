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
  <!-- CSS personalizado -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <!-- Bootstrap JS Bundle (incluso o Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

  <!-- Seção Hero -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url(assets/img/slide/map.jpg);">
          <div class="carousel-container">
            <div class="container text-center py-5">
              <h1 class="display-4">Localize Vagas de Estacionamento</h1>
              <p class="lead animate__animated animate__fadeInUp">Encontre e reserve o estacionamento perfeito para você.</p>
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
              </main>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>
    </div>
  </section><!-- Fim da Seção Hero -->

  <!-- Seção de Recursos -->
  <section id="user" class="user">
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

  <!-- Rodapé -->
  <footer class="bg-light text-center py-4">
    <div class="container">
      <p>&copy; 2024 Espaço Livre. Todos os direitos reservados.</p>
      <a href="#">Termos de Serviço</a> | <a href="#">Política de Privacidade</a>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Script principal -->
  <script src="assets/js/main.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
