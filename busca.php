<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Encontre Seu Estacionamento - Airbnb de Estacionamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

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
    <p>&copy; 2024 Airbnb de Estacionamento. Todos os direitos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
