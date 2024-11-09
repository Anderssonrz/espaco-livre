<?php
//require_once("conexao-bd.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
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

        /* Estilo para o formulário */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para os campos */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
        }

        /* Adicionando um pouco de espaço entre as seções */
        .section-header {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        /* Separação das seções */
        .section-divider {
            margin: 30px 0;
            border-top: 1px solid #ccc;
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

    <!-- Formulário de Cadastro de Usuário -->
    <div class="container mt-5">
        <div class="form-container">
            <h3 class="text-center">Cadastro de Usuário</h3>

            <form>
                <!-- Seção 1 - Dados Pessoais -->
                <div class="section-header">Dados Pessoais</div>

                <div class="form-group">
                    <label for="dataCadastro" class="form-label label-obrigatorio">Data Cadastro</label>
                    <input type="date" id="dataCadastro" name="dataCadastro" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="idCliente" class="form-label">Código Cliente</label>
                    <input type="text" id="idCliente" name="idCliente" class="form-control" required readonly>
                </div>

                <div class="form-group">
                    <label for="pessoaTipo" class="form-label label-obrigatorio">Pessoa Física/Jurídica</label>
                    <select id="pessoaTipo" name="pessoaTipo" class="form-control" required>
                        <option value="" disabled selected>Selecione</option>
                        <option value="Física">Pessoa Física</option>
                        <option value="Jurídica">Pessoa Jurídica</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cpfCnpj" class="form-label label-obrigatorio">CPF/CNPJ</label>
                    <input type="text" id="cpfCnpj" name="cpfCnpj" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nomeRazaoSocial" class="form-label label-obrigatorio">Nome/Razão Social</label>
                    <input type="text" id="nomeRazaoSocial" name="nomeRazaoSocial" class="form-control" required>
                </div>

                <div class="section-divider"></div>

                <!-- Seção 2 - Documentos -->
                <div class="section-header">Documentos</div>

                <div class="form-group">
                    <label for="rg" class="form-label label-obrigatorio">RG</label>
                    <input type="text" id="rg" name="rg" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="cnh" class="form-label label-obrigatorio">CNH</label>
                    <input type="text" id="cnh" name="cnh" class="form-control" required>
                </div>

                <div class="section-divider"></div>

                <!-- Seção 3 - Endereço -->
                <div class="section-header">Endereço</div>

                <div class="form-group">
                    <label for="estado" class="form-label label-obrigatorio">Estado</label>
                    <input type="text" id="estado" name="estado" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="cidade" class="form-label label-obrigatorio">Cidade</label>
                    <input type="text" id="cidade" name="cidade" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="bairro" class="form-label label-obrigatorio">Bairro</label>
                    <input type="text" id="bairro" name="bairro" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="rua" class="form-label label-obrigatorio">Rua</label>
                    <input type="text" id="rua" name="rua" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="numero" class="form-label label-obrigatorio">Número</label>
                    <input type="text" id="numero" name="numero" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="cep" class="form-label label-obrigatorio">CEP</label>
                    <input type="text" id="cep" name="cep" class="form-control" required>
                </div>

                <div class="section-divider"></div>

                <!-- Seção 4 - Contato -->
                <div class="section-header">Contato</div>

                <div class="form-group">
                    <label for="telefone" class="form-label label-obrigatorio">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label label-obrigatorio">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="section-divider"></div>

                <!-- Seção 5 - Vaga e Veículo -->
                <div class="section-header">Vaga e Veículo</div>

                <div class="form-group">
                    <label for="idVaga" class="form-label label">Código Vaga</label>
                    <input type="text" id="idVaga" name="idVaga" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="idVeiculo" class="form-label label">Código Veículo</label>
                    <input type="text" id="idVeiculo" name="idVeiculo" class="form-control" required>
                </div>
                
                <!-- Botão de Envio -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <button type="reset" class="btn btn-secondary">Limpar Formulário</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>

</html>