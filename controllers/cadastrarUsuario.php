<!DOCTYPE html>
<?php
//---------------------------------------------------------------------------------------------
require_once("conexao.php");

if (isset($_POST['btnCadastrar'])) {
    $coluna = [
        'nome' => $_POST['nome'],
        'cpf' => $_POST['cpf'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],               
    ];  
    
    cadastrarUsuario($conexao, $coluna);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container d-flex align-items-center" style="min-height: 100vh;">
    <div class="w-50" style="margin: 0 auto;">
        <h2>Cadastro de Usuário</h2><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row md-3">
                <div class="col-md-8">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-4">        
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>       
            </div><br>
            
            <div class="row md-3">
                <div class="col-md-4">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone">
                </div>
                <div class="col-md-8">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div><br>

            <div class="row md-3">
                <div class="col-md-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
            </div><br>

            <div class="row md-3">
                <div class="col-md-4">
                    <button type="submit" name="btnCadastrar" class="btn btn-success">Cadastrar Usuário</button>
                </div>    
            </div>

        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
function cadastrarUsuario($conexao, $coluna)
{
    $nome = $coluna['nome'];
    $cpf = $coluna['cpf']; // Corrected key
    $telefone = $coluna['telefone'];
    $email = $coluna['email'];
    $senha = $coluna['senha'];
    
    $sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha)
            VALUES ('$nome', '$cpf', '$telefone', '$email', '$senha')";

    if (mysqli_query($conexao, $sql)) {
        echo "Registro inserido com sucesso!";
        header("Location: listagemProdutos.php"); // Corrected redirect
        exit; // Important to stop further execution
    } else {
        echo "Erro ao inserir o registro: " . mysqli_error($conexao);
    }
}
?>