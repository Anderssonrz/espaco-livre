<!DOCTYPE html>
<?php
//---------------------------------------------------------------------------------------------
require_once("conexao.php");

if (isset($_POST['btnCadastrar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha por segurança

    $sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $cpf, $telefone, $email, $senha);

    if (mysqli_stmt_execute($stmt)) {
        echo "<p style='color:green;'>Registro inserido com sucesso!</p>";
        header("Location: index.php"); // Redirecionamento correto
        exit();
    } else {
        echo "<p style='color:red;'>Erro ao inserir o registro: " . mysqli_error($conexao) . "</p>";
    }

    mysqli_stmt_close($stmt);
    
}

?>

<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Listagem vagas</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Página Inicial</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    </ul>
            </div>
        </div>
    </nav>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1>Cadastro de usuário</h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Bem Vindo!</p> -->
            </div>
        </div>
    </header>
    
<div class="container d-flex align-items-center" style="min-height: 50vh;">
    <div class="w-50" style="margin: 0 auto;">
        <form action="" method="POST" id="formularioUsuario">
            <div class="row md-3">
                <div class="col-md-8">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-4">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>
            </div>

            <div class="row md-3">
                <div class="col-md-4">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone">
                </div>
                <div class="col-md-8">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="row md-3">
                <div class="col-md-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
            </div>

            <div class="row md-3">
                <div class="col-md-6">
                    <button type="submit" name="btnCadastrar" class="btn btn-success">Cadastrar Usuário</button>
                    <button type="button" onclick="limparFormulario()" class="btn btn-primary">Limpar</button>
                </div>
            </div>

        </form>
    </div>
</div>

    <footer class="py-5 bg-dark mt-5">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>