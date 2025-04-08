<!DOCTYPE html>

<?php
session_start();
include_once("conexao.php");

$id_loja = filter_input(INPUT_POST, 'id_loja', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome_loja', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$update_loja = "UPDATE loja SET nome_loja='$nome', cidade='$cidade', bairro='$bairro', rua='$rua', numero='$numero', cep='$cep', telefone='$telefone', email='$email'
WHERE id_loja = '$id_loja'";

error_log("\n Erro no editar loja: " . $update_loja, 3, "file.log");
       
$result_loja = mysqli_query($conexao, $update_loja);

if (mysqli_affected_rows($conexao)) {
    $_SESSION['msg'] = "<p style='color:green;'>Usuário editado com sucesso!</p>";
    header("Location: listagemLojas.php");
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Usuário não foi editado com sucesso.</p>";
    
}
header("Location: listagemLojas.php?");
?>