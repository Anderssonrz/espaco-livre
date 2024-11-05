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
                <li class="nav-item">
                    <button class="btn btn-outline-secondary" id="theme-toggle">Tema</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Código JavaScript para alternar temas -->
<script>
    const themeToggleButton = document.getElementById('theme-toggle');

    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }

    themeToggleButton.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
</script>


    <!-- Hero Section -->

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