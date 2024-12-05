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
                    <label for="nomeRazaoSocial" class="form-label label-obrigatorio">Nome completo</label>
                    <input type="text" id="nomeRazaoSocial" name="nomeRazaoSocial" class="form-control" required>
                </div>
                
                    <div class="form-group">
                    <label for="nascimento" class="form-label label-obrigatorio">Data de nascimento</label>
                    <input type="date" id="nascimento" name="nascimento" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="cpfCnpj" class="form-label label-obrigatorio">CPF</label>
                    <input type="text" id="cpfCnpj" name="cpfCnpj" class="form-control" required>
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

                <div class="form-group">
                    <label for="complemento" class="form-label label-obrigatorio">Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefone" class="form-label label-obrigatorio">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" required>
                </div>
                
                

                <div class="section-divider"></div>

                <!-- Seção 4 - Login -->
                <div class="section-header">Login</div>


                <div class="form-group">
                    <label for="email" class="form-label label-obrigatorio">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha" class="form-label label-obrigatorio">Digite uma senha</label>
                    <input type="senha" id="senha" name="senha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="novamente" class="form-label label-obrigatorio">Digite sua senha novamente</label>
                    <input type="novamente" id="novamente" name="novamente" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dataCadastro" class="form-label label-obrigatorio">Data de Cadastro</label>
                    <input type="date" id="dataCadastro" name="dataCadastro" class="form-control" required>
                </div>

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
    <script>
        // Obtendo a data atual
        const dataAtual = new Date();

        // Formatando a data para o formato YYYY-MM-DD
        const dataFormatada = dataAtual.toISOString().split('T')[0];

        // Definindo o valor do input de data
        document.getElementById('dataCadastro').value = dataFormatada;
    </script>
</body>

</html>