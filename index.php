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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- CSS personalizado -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Espaço<br>Livre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Suporte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary text-black" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero bg-light text-center py-5">
    <div class="container">
        <h1 class="display-4">Localize Vagas de Estacionamento</h1>
        <p class="lead">Encontre e reserve o estacionamento perfeito para você.</p>
        <a class="btn btn-primary btn-lg" href="https://www.google.com.br/maps/preview" role="button">Buscar</a>
    </div>
</div>

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

<!-- Footer -->
<footer class="bg-light text-center py-4">
    <div class="container">
        <p>&copy; 2024 Espaco Livre. Todos os direitos reservados.</p>
        <a href="#">Termos de Serviço</a> | <a href="#">Política de Privacidade</a>
    </div>
</footer>

</body>
</html>
