<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg'] = "<p style='color:red;'>ID da vaga inválido!</p>";
    header("Location: listaVagas.php");
    exit();
}

//$descricao = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW); 
$descricao = filter_input(INPUT_POST,'descricao', FILTER_UNSAFE_RAW);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_UNSAFE_RAW);    
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_UNSAFE_RAW);    
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_UNSAFE_RAW);  
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_UNSAFE_RAW); 
$preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
$id_uf_raw = filter_input(INPUT_POST, 'id_uf', FILTER_UNSAFE_RAW); 

$foto_vaga = ""; // Inicializa a variável para a nova foto

// Processamento do upload da nova foto (se houver)
if (isset($_FILES["foto_vaga"]) && $_FILES["foto_vaga"]["error"] == 0) {
    $pasta_destino = "assets/img/";
    $nome_arquivo = uniqid() . "_" . $_FILES["foto_vaga"]["name"];
    $caminho_completo = $pasta_destino . $nome_arquivo;

    if (move_uploaded_file($_FILES["foto_vaga"]["tmp_name"], $caminho_completo)) {
        $foto_vaga = $caminho_completo;
        // Aqui você pode adicionar a lógica para excluir a foto antiga, se desejar
    } else {
        $_SESSION['msg'] = "<p style='color:red;'>Erro ao salvar a nova foto da vaga!</p>";
        header("Location: editVaga.php?id=" . $id);
        exit();
    }
} else {
    // Se nenhuma nova foto foi enviada, mantém a foto antiga (assumindo campo hidden no form)
    $foto_vaga = filter_input(INPUT_POST, 'foto_vaga_antiga', FILTER_UNSAFE_RAW);
    // Se não houver campo hidden, use a consulta (com prepared statement):
    if (empty($foto_vaga)) {
        $select_foto_antiga = "SELECT foto_vaga FROM vagas WHERE id = ?";
        $stmt_foto_antiga = mysqli_prepare($conexao, $select_foto_antiga);
        mysqli_stmt_bind_param($stmt_foto_antiga, "i", $id);
        mysqli_stmt_execute($stmt_foto_antiga);
        $result_foto_antiga = mysqli_stmt_get_result($stmt_foto_antiga);
        $row_foto_antiga = mysqli_fetch_assoc($result_foto_antiga);
        $foto_vaga = $row_foto_antiga['foto_vaga'];
        mysqli_stmt_close($stmt_foto_antiga);
    }
}

$update_vaga = "UPDATE vagas SET descricao=?, cidade=?, bairro=?, endereco=?, numero=?, complemento=?,
                    foto_vaga=?, preco=?, id_usuario=?, id_uf=?
                    WHERE id = ?";

$stmt = mysqli_prepare($conexao, $update_vaga);
// Assumindo que id_uf é um inteiro
mysqli_stmt_bind_param($stmt, "sssssssdiii", $descricao, $cidade, $bairro, $endereco, $numero, $complemento, $foto_vaga, $preco, $id_usuario, $id_uf_raw, $id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['msg'] = "<p style='color:green;'>Vaga editada com sucesso!</p>";
    header("Location: listaVagas.php");
} else {
    $_SESSION['msg'] = "<p style='color:red;'>Erro ao editar a vaga!</p>";
    error_log("\n Erro ao editar vaga: " . mysqli_error($conexao), 3, "error.log");
    header("Location: listaVagas.php?id=" . $id);
}

header("Location: dadosVagaUsuario.php");
exit();
?>