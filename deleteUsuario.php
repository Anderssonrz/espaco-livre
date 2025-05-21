<?php

include_once("conexao.php");

session_start();

if (!empty($_GET['id'])) {
    $id_usuario = $_GET['id']; // Renomeei para deixar mais claro

    // Primeiro, vamos verificar se existem vagas associadas a este usuário
    $sqlVerificarVagas = "SELECT COUNT(*) AS total_vagas FROM vagas WHERE id_usuario = '$id_usuario'";
    $resultadoVerificacao = $conexao->query($sqlVerificarVagas);
    $rowVagas = $resultadoVerificacao->fetch_assoc();

    if ($rowVagas['total_vagas'] > 0) {
        // Se houver vagas, vamos deletá-las primeiro
        $sqlDeletarVagas = "DELETE FROM vagas WHERE id_usuario = '$id_usuario'";
        if ($conexao->query($sqlDeletarVagas)) {
            // Agora que as vagas foram deletadas, podemos deletar o usuário
            $sqlDeletarUsuario = "DELETE FROM usuarios WHERE id = '$id_usuario'";
            if ($conexao->query($sqlDeletarUsuario)) {
                $_SESSION['msg'] = "<p style='color:green;'>Usuário e suas vagas foram apagados com sucesso!</p>";
            } else {
                $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar o usuário: " . $conexao->error . "</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar as vagas do usuário: " . $conexao->error . "</p>";
        }
    } else {
        // Se não houver vagas, podemos deletar o usuário diretamente
        $sqlDeletarUsuario = "DELETE FROM usuarios WHERE id = '$id_usuario'";
        if ($conexao->query($sqlDeletarUsuario)) {
            $_SESSION['msg'] = "<p style='color:green;'>Usuário apagado com sucesso!</p>";
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar o usuário: " . $conexao->error . "</p>";
        }
    }
    header("Location: listagemUsuarios.php?");
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Erro: ID do usuário não fornecido!</p>";
    header("Location: listagemUsuarios.php?");
}

?>