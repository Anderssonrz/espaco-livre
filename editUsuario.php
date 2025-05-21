<!DOCTYPE html>
<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$select_usuario = "SELECT * FROM usuarios WHERE id = '$id'";

$result_usuario = mysqli_query($conexao, $select_usuario);
$linha_usuario = mysqli_fetch_assoc($result_usuario);

?>

<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <body>
    <?php require_once 'components/headerQuatro.php'; ?><br><br><br><br><br>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p> -->
            </div>
        </div>
    </header>
    
    <div class="container mt-4">
        <h2>Usuário código: <?php echo $linha_usuario['id']; ?></h2><br>

        <form action="saveEditUsuario.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $linha_usuario['id']; ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($linha_usuario['nome']); ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo htmlspecialchars($linha_usuario['cpf']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($linha_usuario['telefone']); ?>">
                </div>
                <div class="col-md-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($linha_usuario['email']); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="senha" class="form-label">Senha (Deixe em branco para não alterar)</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Nova senha">
                    <small class="form-text text-muted">Se você não digitar uma nova senha, a senha atual permanecerá a mesma.</small>
                </div>
                <div class="col-md-4">
                    <label for="dataCadastro" class="form-label">Data Cadastro</label>
                    <input type="date" class="form-control" id="dataCadastro" name="dataCadastro" value="<?php echo htmlspecialchars($linha_usuario['dataCadastro']); ?>" readonly>
                    <small class="form-text text-muted">A data de cadastro não pode ser alterada.</small>
                </div>
            </div>

            <button type="submit" name="btnEditar" class="btn btn-primary">Salvar Alterações</button>
            <button type="button" class="btn btn-danger">Cancelar</button>
        </form>
    </div><br><br> 
        

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Direitos autorais &copy; Your Website 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>