<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Veículos</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        /* Estilo para campos com valores predefinidos */
        .predefinido {
            background-color: #f5f5f5; /* Cor de fundo cinza claro */
            cursor: not-allowed; /* Cursor de "não permitido" */
        }

        /* Estilo para labels obrigatórios */
        .label-obrigatorio::after {
            content: " *";
            color: red;
        }
    </style>
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

    <!-- Formulário de Cadastro de Veículo -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3>Cadastro de Veículos</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <!-- ID do Veículo (com contador automático no futuro) -->
                        <div class="col-12 col-md-4">
                            <label for="idVeiculo" class="form-label">Código do Veículo</label>
                            <input type="text" id="idVeiculo" name="idVeiculo" class="form-control" required readonly>
                        </div>

                        <!-- ID do Cliente (com contador automático no futuro) -->
                        <div class="col-12 col-md-4">
                            <label for="idCliente" class="form-label">Código do Cliente</label>
                            <input type="text" id="idCliente" name="idCliente" class="form-control" required readonly>
                        </div>

                        <!-- Nome do Proprietário -->
                        <div class="col-12 col-md-4">
                            <label for="nomeProprietario" class="form-label label-obrigatorio">Nome do Proprietário</label>
                            <input type="text" id="nomeProprietario" name="nomeProprietario" class="form-control" list="clientes" required>
                            <datalist id="clientes">
                                <option value="Cliente 1"></option>
                                <option value="Cliente 2"></option>
                            </datalist>
                        </div>

                        <!-- Fabricante -->
                        <div class="col-12 col-md-4">
                            <label for="fabricante" class="form-label label-obrigatorio">Fabricante</label>
                            <input type="text" id="fabricante" name="fabricante" class="form-control" required>
                        </div>

                        <!-- Categoria -->
                        <div class="col-12 col-md-4">
                            <label for="categoria" class="form-label label-obrigatorio">Categoria</label>
                            <select id="categoria" name="categoria" class="form-control" required>
                                <option value="" disabled selected>Selecione a categoria</option>
                                <option value="Carro">Carro</option>
                                <option value="Moto">Moto</option>
                                <option value="Caminhão">Caminhão</option>
                                <option value="Van">Van</option>
                            </select>
                        </div>

                        <!-- Tipo de Modelo -->
                        <div class="col-12 col-md-4">
                            <label for="tipoModelo" class="form-label label-obrigatorio">Tipo de Modelo</label>
                            <select id="tipoModelo" name="tipoModelo" class="form-control" required>
                                <option value="" disabled selected>Selecione o tipo de modelo</option>
                                <option value="Sedan">Sedan</option>
                                <option value="Hatch">Hatch</option>
                                <option value="Esportivo">Esportivo</option>
                                <option value="SUV">SUV</option>
                                <option value="Picape">Picape</option>
                            </select>
                        </div>

                        <!-- RENAVAM -->
                        <div class="col-12 col-md-4">
                            <label for="renavam" class="form-label label-obrigatorio">RENAVAM</label>
                            <input type="text" id="renavam" name="renavam" class="form-control" required>
                        </div>

                        <!-- Placa -->
                        <div class="col-12 col-md-4">
                            <label for="placa" class="form-label label-obrigatorio">Placa</label>
                            <input type="text" id="placa" name="placa" class="form-control" placeholder="Ex: ABC-1234" pattern="[A-Z]{3}-[0-9]{4}" required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Formato de placa inválido')">
                        </div>

                        <!-- Ano/Modelo -->
                        <div class="col-12 col-md-4">
                            <label for="anoModelo" class="form-label label-obrigatorio">Ano/Modelo</label>
                            <input type="number" id="anoModelo" name="anoModelo" class="form-control" min="1980" max="2024" required>
                        </div>

                        <!-- Cor  -->
                        <div class="col-12 col-md-4">
                            <label for="cor" class="form-label label-obrigatorio">Cor</label>
                            <select id="cor" name="cor" class="form-control" required>
                                <option value="" disabled selected>Selecione a cor</option>
                                <option value="Branco">Branco</option>
                                <option value="Preto">Preto</option>
                                <option value="Prata">Prata</option>
                                <option value="Vermelho">Vermelho</option>
                                <option value="Azul">Azul</option>
                                <option value="Cinza">Cinza</option>
                                <option value="Verde">Verde</option>
                                <option value="Amarelo">Amarelo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botão de Envio -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Cadastrar Veículo</button>
                            <button type="reset" class="btn btn-secondary">Limpar Formulário</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2024 Espaço Livre. Todos os direitos reservados.</p>
            <a href="#">Termos de Serviço</a> | <a href="#">Política de Privacidade</a>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
