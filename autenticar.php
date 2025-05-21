<?php
session_start();
require_once 'conexao.php'; // Arquivo com a conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $nome;
            $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];
            header("Location: index.php"); // Redirecionar para a página principal
            exit();
        } else {
            header("Location: login.php?erro=1"); // Redirecionar de volta para o login com erro
            exit();
        }
    } else {
        header("Location: login.php?erro=1"); // Redirecionar de volta para o login com erro
        exit();
    }

    $stmt->close();
    $conexao->close();
} else {
    header("Location: login.php"); // Se acessar diretamente, redirecionar para o login
    exit();
}
?>