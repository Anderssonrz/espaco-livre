<?php

include_once("conexao.php");

session_start();

if (!empty($_GET['id'])) {
    $id_vaga = $_GET['id']; // Renomeei para deixar mais claro

    // Primeiro, vamos verificar se existem reservas associadas a esta vaga
    $sqlVerificarReservas = "SELECT COUNT(*) AS total_reservas FROM reservas WHERE id_vaga = '$id_vaga'";
    $resultadoVerificacao = $conexao->query($sqlVerificarReservas);
    $rowReservas = $resultadoVerificacao->fetch_assoc();

    if ($rowReservas['total_reservas'] > 0) {
        // Se houver reservas, vamos deletá-las primeiro
        $sqlDeletarReservas = "DELETE FROM reservas WHERE id_vaga = '$id_vaga'";
        if ($conexao->query($sqlDeletarReservas)) {
            // Agora que as reservas foram deletadas, podemos deletar a vaga
            $sqlDeletarVaga = "DELETE FROM vagas WHERE id = '$id_vaga'";
            if ($conexao->query($sqlDeletarVaga)) {
                $_SESSION['msg'] = "<p style='color:green;'>Vaga e suas reservas foram apagadas com sucesso!</p>";
            } else {
                $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar a vaga: " . $conexao->error . "</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar as reservas da vaga: " . $conexao->error . "</p>";
        }
    } else {
        // Se não houver reservas, podemos deletar a vaga diretamente
        $sqlDeletarVaga = "DELETE FROM vagas WHERE id = '$id_vaga'";
        if ($conexao->query($sqlDeletarVaga)) {
            $_SESSION['msg'] = "<p style='color:green;'>Vaga apagada com sucesso!</p>";
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Erro ao apagar a vaga: " . $conexao->error . "</p>";
        }
    }
    header("Location: listaVagas.php?"); // Assumindo que você tem uma página de listagem de vagas
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Erro: ID da vaga não fornecido!</p>";
    header("Location: listagemVagas.php?");
}

?>