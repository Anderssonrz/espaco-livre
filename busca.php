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


<header class="bg-primary text-white text-center py-5">
    <h1>Encontre o Estacionamento Ideal para Você</h1>
    <p>Reserve um espaço de estacionamento perto do seu destino.</p>
</header>

<main class="container my-5">
    <section>
        <h2>Pesquisar Estacionamentos</h2>
        <form class="row g-3">
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="Digite sua localização ou destino" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </section>

    <section class="mt-5">
        <h2>Estacionamentos em Destaque</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Estacionamento 1">
                    <div class="card-body">
                        <h5 class="card-title">Estacionamento Central</h5>
                        <p class="card-text">Localização: Centro da Cidade</p>
                        <p class="card-text">Preço: R$ 20/dia</p>
                        <a href="#" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Estacionamento 2">
                    <div class="card-body">
                        <h5 class="card-title">Estacionamento Parque</h5>
                        <p class="card-text">Localização: Parque da Cidade</p>
                        <p class="card-text">Preço: R$ 15/dia</p>
                        <a href="#" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Estacionamento 3">
                    <div class="card-body">
                        <h5 class="card-title">Estacionamento Shopping</h5>
                        <p class="card-text">Localização: Shopping Mall</p>
                        <p class="card-text">Preço: R$ 25/dia</p>
                        <a href="#" class="btn btn-primary">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-dark text-white text-center py-4">
    <p>&copy; 2024 Espaco Livre. Todos os direitos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
