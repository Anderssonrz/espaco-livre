<!DOCTYPE html>

<?php
session_start();
include_once("conexao.php");

$id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
$data_cadastro = filter_input(INPUT_POST, 'data_cadastro');
$preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT);
$descontos = filter_input(INPUT_POST, 'descontos', FILTER_SANITIZE_NUMBER_FLOAT);
$id_loja = filter_input(INPUT_POST, 'id_loja', FILTER_SANITIZE_NUMBER_INT);
// $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
// $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);

$update_produto = "UPDATE cad_produto SET nome='$nome', descricao='$descricao', quantidade='$quantidade', data_cadastro='$data_cadastro', preco='$preco', descontos='$descontos'
WHERE id_produto = '$id_produto'";

error_log("\n Erro no editar loja: " . $update_produto, 3, "file.log");
       
$result_produto = mysqli_query($conexao, $update_produto);

if (mysqli_affected_rows($conexao)) {
    $_SESSION['msg'] = "<p style='color:green;'>Produto editado com sucesso!</p>";
    header("Location: listagemLojas.php");
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Produto não foi editado com sucesso.</p>";
    
}
header("Location: listagemProdutos.php?");
?>