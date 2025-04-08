<!DOCTYPE html>

<?php
include_once ("conexao.php");

if (isset($_POST["btnCadastrar"])) {
//--------------------------------------------CHECKBOX-----------------------------------------------
$produto = null;

if (isset($_POST['categoria']))
    $produto = $_POST['categoria'];


if ($produto !== null) {
    for ($i = 0; $i < count($produto); $i++) {
        echo "<p>{$produto[$i]}</p>";

    }
}
//---------------------------------------------------------------------------------------------------

//-------------------------------------------IMAGEM--------------------------------------------------
$titulo = "Upload de imagens";


if (isset($_FILES["imagem"]) && !empty($_FILES["imagem"])) {
    move_uploaded_file($_FILES["imagem"]["tmp_name"], "./img/" . $_FILES["imagem"]["name"]);
    echo "<p>upload realizado</p>";
}
//---------------------------------------------------------------------------------------------------
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="check.php" method="post" enctype="multipart/form-data">
        <h5>Categoria:</h5>

        <div class="col-md-4">
            <input type="checkbox" name="categoria[]" value="Eletronico"> Eletrónico<br>
            <input type="checkbox" name="categoria[]" value="Telefonia"> Telefonia<br>
            <input type="checkbox" name="categoria[]" value="Informatica"> Informática<br>
            <input type="checkbox" name="categoria[]" value="Acessorios"> Acessórios<br>
        </div>
        <br><br>
        <div class="col-md-4">
            <label>Selecionar imagem</label>
            <input type="file" name="imagem" accept="image/*" class="form-control" /><br>
        </div>
        <br><br>
        <button type="submit" name="btnCadastrar" id="submit">
            <h6>Cadastrar</h6><button>

    </form>





</body>

</html>
<!-- 