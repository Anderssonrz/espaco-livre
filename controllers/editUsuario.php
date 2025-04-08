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
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página de Edição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php 
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

?>
    <div class="container mt-4">
        <h2>Cadastro de Vaga</h2><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $linha_usuario['nome']; ?>" required>
            </div>

            
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $linha_usuario['cpf']; ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $linha_usuario['telefone']; ?>">
                </div>
                <div class="col-md-5">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $linha_usuario['email']; ?>">
                </div>
            </div>            

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $linha_usuario['senha']; ?>">
                </div>   
                <div class="col-md-4">
                    <label for="dataCadastro" class="form-label">Data Cadastro</label>
                    <input type="date" class="form-control" id="dataCadastro" name="dataCadastro" value="<?php echo $linha_usuario['dataCadastro']; ?>">
                </div>              
            </div>

            

            <button type="submit" name="btnCadastrar" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
     
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        $data_cadastro = filter_input(INPUT_POST, 'dataCadastro');
               

        
        $update_usuarios = "UPDATE usuarios SET nome='$nome', cpf='$cpf', telefone='$telefone', email='$email', senha='$senha', dataCadastro='$data_cadastro' WHERE id = '$id'";
        
        error_log("\n Erro ao editar usuario: " . $update_usuario, 3, "file.log");
               
        $result_usuario = mysqli_query($conexao, $update_usuario);
        
        if (mysqli_affected_rows($conexao)) {
            $_SESSION['msg'] = "<p style='color:green;'>Usuário editado com sucesso!</p>";
            header("Location: listagemVagas.php");
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Usuário não editada!</p>";
            
        }
        header("Location: listagemUsuarios.php?");
        
