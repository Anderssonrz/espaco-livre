<!DOCTYPE html>

<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$select_vaga = "SELECT vagas.*, estados.*, usuarios.* 
                FROM vagas 
                INNER JOIN estados ON vagas.id_uf = estados.id 
                INNER JOIN usuarios ON vagas.id_usuario = usuarios.id
                WHERE vagas.id = '$id'";

$result_vaga = mysqli_query($conexao, $select_vaga);
$linha_vaga = mysqli_fetch_assoc($result_vaga);

// $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
// $select_estados = "SELECT * FROM estados WHERE id = '$id'";
// $result_estados = mysqli_query($conexao, $select_estados);
// $linha_estados = mysqli_fetch_assoc($result_estados);
?>

<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página de Edição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php 
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

?>
    <div class="container mt-4">
        <h2>Cadastro de Vaga</h2><br>

        <form action="saveEditVaga.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição da Vaga</label>
            <div contenteditable="true" id="descricao" name="descricao" style="border: 1px solid #ccc; padding: 10px; min-height: 100px;"><?php echo $linha_vaga['descricao']; ?></div>
                <input type="hidden" name="descricao" id="descricao_hidden">
            </div>
                <script>
                    const descricaoDiv = document.getElementById('descricao');
                    const descricaoHidden = document.getElementById('descricao_hidden');
                    descricaoDiv.addEventListener('input', () => {
                    descricaoHidden.value = descricaoDiv.innerHTML;
                    });
                </script>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_uf" class="form-label">UF - Unidade Federativa</label><br>
                    <select name="id_uf" required>
                        <?php
                        $query = $conn->query("SELECT * FROM estados ORDER BY nome ASC");
                        $registros = $query->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($registros as $option) {
                            $selected = ($option['id'] == $linha_vaga['id_uf']) ? 'selected' : '';
                            echo "<option value=\"{$option['id']}\" {$selected}>{$option['uf']} - {$option['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $linha_vaga['cidade']; ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $linha_vaga['bairro']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $linha_vaga['endereco']; ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="number" class="form-control" id="numero" name="numero" value="<?php echo $linha_vaga['numero']; ?>">
                </div>
                <div class="col-md-5">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $linha_vaga['complemento']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Selecione a imagem</label>
                    <input type="file" name="foto_vaga" accept="image/*" class="form-control" value="<?php echo $linha_vaga['foto_vaga']; ?>" required/>
                </div>
                <div class="col-md-2">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" value="<?php echo $linha_vaga['preco']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="lat" class="form-label">Latitude</label>
                    <input type="number" class="form-control" id="lat" name="lat" value="<?php echo $linha_vaga['lat']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="lng" class="form-label">Longitude</label>
                    <input type="number" class="form-control" id="lng" name="lng" value="<?php echo $linha_vaga['lng']; ?>">
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
                            $selected = ($option['id'] == $linha_vaga['id_usuario']) ? 'selected' : '';
                            echo "<option value=\"{$option['id']}\" {$selected}>{$option['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <button type="submit" name="btnCadastrar" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
     
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
        $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
        $foto_vaga = filter_input(INPUT_POST, 'foto_vaga', FILTER_SANITIZE_STRING);
        $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT);
        $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
        $lng = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_STRING);
        $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
        $id_uf = filter_input(INPUT_POST, 'id_uf');
               

        
        $update_vaga = "UPDATE vagas SET descricao='$descricao', cidade='$cidade', bairro='$bairro', endereco='$endereco', numero='$numero', complemento='$complemento', 
        foto_vaga='$foto_vaga', preco='$preco', lat='$lat', lng='$lng', id_usuario='$id_usuario', id_uf='$id_uf'
        WHERE id = '$id'";
        
        error_log("\n Erro no editar vaga: " . $update_vaga, 3, "file.log");
               
        $result_vaga = mysqli_query($conexao, $update_vaga);
        
        if (mysqli_affected_rows($conexao)) {
            $_SESSION['msg'] = "<p style='color:green;'>Vaga editado com sucesso!</p>";
            header("Location: listagemVagas.php");
        } else {
            $_SESSION['msg'] = "<p style='color:red;'>Vaga não editada!</p>";
            
        }
        header("Location: listagemVagas.php?");
        
