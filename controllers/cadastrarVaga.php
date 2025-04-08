<!DOCTYPE html>
<?php
//------------------------------------------------------------------------------------------
require_once("conexao.php");

if (isset($_POST['btnCadastrar'])) {
    $coluna = [
        'descricao' => $_POST['descricao'],
        'cidade' => $_POST['cidade'],
        'bairro' => $_POST['bairro'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento'],
        'foto_vaga' => $_FILES['foto_vaga']['name'], // Use $_FILES['foto_vaga']['name']
        'preco' => $_POST['preco'],
        'lat' => $_POST['lat'],
        'lng' => $_POST['lng'],
        'id_usuario' => $_POST['id_usuario'],
        'id_uf' => $_POST['id_uf'],
    ];

    // Upload da foto
    $targetDir = "./img/";
    $targetFile = $targetDir . basename($_FILES["foto_vaga"]["name"]);
    move_uploaded_file($_FILES["foto_vaga"]["tmp_name"], $targetFile);

    cadastrarVaga($conexao, $coluna);
}

// Existe inserteza se a sintaxe está correta
$produto = isset($_POST['categoria']) ? $_POST['categoria'] : null;

if ($produto !== null) {
    foreach ($produto as $item) {
        echo "<p>{$item}</p>";
    }
}

$titulo = "Salvar foto da vaga";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro de Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Cadastro de Vaga</h2><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição da Vaga</label>
                <textarea type="text" class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_uf" class="form-label">Unidade Federativa</label><br>
                    <select name="id_uf" required>
                        <?php
                        $query = $conn->query("SELECT * FROM estados ORDER BY nome ASC");
                        $registros = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($registros as $option) {
                            echo "<option value=\"{$option['id']}\">{$option['uf']} - {$option['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="number" class="form-control" id="numero" name="numero">
                </div>
                <div class="col-md-5">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Selecione a imagem</label>
                    <input type="file" name="foto_vaga" accept="image/*" class="form-control" required/>
                </div>
                <div class="col-md-2">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="lat" class="form-label">Latitude</label>
                    <input type="number" class="form-control" id="lat" name="lat">
                </div>
                <div class="col-md-4">
                    <label for="lng" class="form-label">Longitude</label>
                    <input type="number" class="form-control" id="lng" name="lng">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_usuario" class="form-label">Usuário</label><br>
                    <select name="id_usuario" required>
                        <?php
                        $query = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");
                        $registros = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($registros as $option) {
                            echo "<option value=\"{$option['id']}\">{$option['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <button type="submit" name="btnCadastrar" class="btn btn-primary">Cadastrar Vaga</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
function cadastrarVaga($conexao, $coluna)
{
    $descricao = $coluna['descricao'];
    $uf = $coluna['id_uf']; // Corrected key
    $cidade = $coluna['cidade'];
    $bairro = $coluna['bairro'];
    $endereco = $coluna['endereco'];
    $numero = $coluna['numero'];
    $complemento = $coluna['complemento'];
    $foto_vaga = $coluna['foto_vaga'];
    $preco = $coluna['preco'];
    $lat = $coluna['lat'];
    $lng = $coluna['lng'];
    $id_usuario = $coluna['id_usuario'];

    $sql = "INSERT INTO vagas (descricao, id_uf, cidade, bairro, endereco, numero, complemento, foto_vaga, preco, lat, lng, id_usuario)
            VALUES ('$descricao', '$uf', '$cidade', '$bairro', '$endereco', '$numero', '$complemento', '$foto_vaga', '$preco', '$lat', '$lng', '$id_usuario')";

    if (mysqli_query($conexao, $sql)) {
        echo "Registro inserido com sucesso!";
        header("Location: listagemProdutos.php"); // Corrected redirect
        exit; // Important to stop further execution
    } else {
        echo "Erro ao inserir o registro: " . mysqli_error($conexao);
    }
}
?>