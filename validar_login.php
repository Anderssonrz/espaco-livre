<?php
session_start();
require_once("conexao.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(empty($dados['email'])) {
    echo json_encode(['erro' => true, 'msg' => "Erro: Preencha o campo email."]);
    exit;
} elseif(empty($dados['senha'])) {
    echo json_encode(['erro' => true, 'msg' => "Erro: Preencha o campo senha."]);
    exit;
}

$query_usuario = "SELECT id, nome, email, senha, nivel_acesso FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $conn->prepare($query_usuario);
$stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($dados['senha'], $usuario['senha'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];

        echo json_encode(['erro' => false, 'msg' => 'Login realizado com sucesso!']);
    } else {
        echo json_encode(['erro' => true, 'msg' => 'Senha incorreta.']);
    }
} else {
    echo json_encode(['erro' => true, 'msg' => 'Usuário não encontrado.']);
}
