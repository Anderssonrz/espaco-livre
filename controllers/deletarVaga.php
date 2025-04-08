<?php

include_once("conexao.php");

session_start();
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM vagas WHERE id = '$id'";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM vagas WHERE id = '$id'";
        $resultDelete = $conexao->query($sqlDelete);
    }
    header("Location: listagemVagas.php?");
}

?>