<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color:red;'>ID do usuário inválido!</p>";
    header("Location: listaUsuarios.php"); 
    exit();
}

$nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW); 
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW);   
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_UNSAFE_RAW); 
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
if ($email) {
    $email_validado = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email_validado) {
        $_SESSION['msg'] = "<p style='color:red;'>Email inválido!</p>";
        header("Location: editaUsuario.php?id=" . $id); 
        exit();
    }
}

$senha = $_POST['senha'];

// Consulta para obter a senha atual do banco de dados
$sql_senha_atual = "SELECT senha FROM usuarios WHERE id = ?";
$stmt_senha_atual = mysqli_prepare($conexao, $sql_senha_atual);
mysqli_stmt_bind_param($stmt_senha_atual, "i", $id);
mysqli_stmt_execute($stmt_senha_atual);
$result_senha_atual = mysqli_stmt_get_result($stmt_senha_atual);
$row_senha_atual = mysqli_fetch_assoc($result_senha_atual);
$senha_banco = $row_senha_atual['senha'];
mysqli_stmt_close($stmt_senha_atual);

$data_cadastro = filter_input(INPUT_POST, 'dataCadastro');

$atualizacao_sucesso = false; // Variável para rastrear o sucesso da atualização

$update_usuarios_sql = "UPDATE usuarios SET nome=?, cpf=?, telefone=?, email=?, dataCadastro=? WHERE id = ?";
$stmt = mysqli_prepare($conexao, $update_usuarios_sql);
mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf, $telefone, $email, $data_cadastro, $id);

if (mysqli_stmt_execute($stmt)) {
    $atualizacao_sucesso = true;
} else {
    error_log("\n Erro ao editar usuário (dados básicos): " . mysqli_error($conexao), 3, "error.log");
}
mysqli_stmt_close($stmt);

// Atualizar a senha apenas se um novo valor foi fornecido
if (!empty($senha)) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $update_senha_sql = "UPDATE usuarios SET senha=? WHERE id = ?";
    $stmt_senha = mysqli_prepare($conexao, $update_senha_sql);
    mysqli_stmt_bind_param($stmt_senha, "si", $senha_hash, $id);
    if (mysqli_stmt_execute($stmt_senha)) {
        $atualizacao_sucesso = true;
    } else {
        error_log("\n Erro ao editar usuário (senha): " . mysqli_error($conexao), 3, "error.log");
    }
    mysqli_stmt_close($stmt_senha);
}

if ($atualizacao_sucesso) {
    $_SESSION['msg'] = "<p style='color:green;'>Usuário atualizado com sucesso!</p>";
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Erro ao editar o usuário!</p>";
}

header("Location: dadosPessoaisUsuario.php");
exit();
?>