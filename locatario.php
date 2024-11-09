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

    <style>
        /* Estilo para campos com valores predefinidos */
        .predefinido {
            background-color: #f5f5f5;
            /* Cor de fundo cinza claro */
            cursor: not-allowed;
            /* Cursor de "não permitido" */
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

    <!-- Formulário de Cadastro de Vaga -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3>Cadastro de Vaga</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <!-- Data de Cadastro -->
                        <div class="col-12 col-md-4">
                            <label for="dataCadastro" class="form-label label-obrigatorio">Data Cadastro</label>
                            <input type="date" id="dataCadastro" name="dataCadastro" class="form-control" required>
                        </div>

                        <!-- ID Vaga  -->
                        <div class="col-12 col-md-4">
                            <label for="idVaga" class="form-label ">Código Vaga</label>
                            <input type="text" id="idVaga" name="idVaga" class="form-control" required readonly>
                            <!-- (com contador automático no futuro) -->

                        </div>

                        <!-- ID Cliente -->
                        <div class="col-12 col-md-4">
                            <label for="idCliente" class="form-label">Código Cliente</label>
                            <input type="text" id="idCliente" name="idCliente" class="form-control" required>
                        </div>

                        <!-- Nome Cliente -->
                        <div class="col-12 col-md-4">
                            <label for="nomeCliente" class="form-label label-obrigatorio">Nome Cliente</label>
                            <input type="text" id="nomeCliente" name="nomeCliente" class="form-control" required>
                        </div>

                        <!-- Quantidade de Vagas -->
                        <div class="col-12 col-md-4">
                            <label for="quantVagas" class="form-label label-obrigatorio">Quantidade de Vagas</label>
                            <input type="number" id="quantVagas" name="quantVagas" class="form-control" required min="1">
                        </div>

                        <!-- Medidas -->
                        <div class="col-12 col-md-4">
                            <label for="medidas" class="form-label label-obrigatorio">Medidas</label>
                            <input type="text" id="medidas" name="medidas" class="form-control" required>
                        </div>

                        <!-- Cobertura -->
                        <div class="col-12 col-md-4">
                            <label for="cobertura" class="form-label label-obrigatorio">Cobertura</label>
                            <select id="cobertura" name="cobertura" class="form-control" required>
                                <option value="" disabled selected>Selecione a cobertura</option>
                                <option value="Aberto">Aberto</option>
                                <option value="Coberto">Coberto</option>
                            </select>
                        </div>

                        <!-- Fechado -->
                        <div class="col-12 col-md-4">
                            <label for="fechado" class="form-label label-obrigatorio">Fechado</label>
                            <select id="fechado" name="fechado" class="form-control" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>

                        <!-- Monitorado -->
                        <div class="col-12 col-md-4">
                            <label for="monitorado" class="form-label label-obrigatorio">Monitorado</label>
                            <select id="monitorado" name="monitorado" class="form-control" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="Sim">Sim</option>
                                <option value="Não">Não</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botão de Envio -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Cadastrar Vaga</button>
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