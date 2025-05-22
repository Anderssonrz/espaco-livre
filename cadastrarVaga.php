<!DOCTYPE html>
<?php
//------------------------------------------------------------------------------------------
require_once("conexao.php");
session_start();

if (isset($_POST['btnCadastrar'])) {
    $descricao = $_POST['descricao'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $preco = $_POST['preco'];
    $id_usuario = $_POST['id_usuario'];
    $id_uf = $_POST['id_uf'];

    // Processamento do upload da foto
    $foto_vaga = ""; // Inicializa a variável
    if (isset($_FILES["foto_vaga"]) && $_FILES["foto_vaga"]["error"] == 0) {
        $pasta_destino = "assets/img/"; // Pasta onde as fotos serão salvas
        $nome_arquivo = uniqid() . "_" . $_FILES["foto_vaga"]["name"]; // Gera um nome único
        $caminho_completo = $pasta_destino . $nome_arquivo;

        if (move_uploaded_file($_FILES["foto_vaga"]["tmp_name"], $caminho_completo)) {
            $foto_vaga = $caminho_completo; // Salva o caminho completo no banco de dados
            "<p>Foto da vaga enviada com sucesso para: " . $caminho_completo . "</p>";
        } else {
            "<p class='text-danger'>Erro ao salvar a foto da vaga.</p>";
        }
    } else {
        "<p class='text-warning'>Nenhuma foto da vaga foi enviada ou ocorreu um erro.</p>";
    }

    $id_usuario_logado = $_SESSION['id'];

    // Inserir os dados da vaga no banco de dados
    $sql = "INSERT INTO vagas (descricao, cidade, bairro, endereco, numero, complemento, foto_vaga, preco, id_usuario, id_uf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssssissdii", $descricao, $cidade, $bairro, $endereco, $numero, $complemento, $foto_vaga, $preco, $id_usuario, $id_uf);

    if (mysqli_stmt_execute($stmt)) {
        "<p class='text-success'>Registro inserido com sucesso!</p>";
        // Você pode redirecionar para outra página aqui, se desejar
        // header("Location: listagemProdutos.php");
        // exit;
    } else {
        "<p class='text-danger'>Erro ao inserir o registro: " . mysqli_error($conexao) . "</p>";
    }

    mysqli_stmt_close($stmt);
}

$titulo = "Salvar foto da vaga";
?>


<!DOCTYPE html>
<html lang="pt-br">
<?php
$pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
require_once 'components/head.php';   // <head> com CSS/meta/ …
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Vaga</title>
</head>

<body>
    <?php require_once 'components/header.php'; ?><br><br><br><br><br>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
            </div>
        </div>
    </header>

    <div class="content">
        <div class="container mt-4">
            <form action="" method="POST" id="formularioVaga" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição da Vaga:</label>
                    <textarea type="text" class="form-control" id="descricao" name="descricao" rows="3" required></textarea>

                    <p style="color: black; font-size: 16px; font-family: 'Times New Roman'">
                        Use o campo Descrição para descrever informações que você considera importante compartilha sobre sua vaga,
                        isso irá complentar os dados solicitados neste formulário.<br>

                        Exemplo:<br>
                        Medidas da vaga em centímetros, ALT X LAG X COMPR.<br>
                        Vaga com restrições a veículos com altura superior a 2 metros.<br>
                        Vaga incompatível com veículos longos, dificultando a manobra.<br>
                        O portão de entrada somente com abertura manual, etc...<br>
                    </p>
                </div><br>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="id_uf" class="form-label">UF:</label><br>
                        <select name="id_uf" class="form-select" aria-label="Default select example" required>
                            <option value="">Selecione o Estado</option>
                            <?php
                            $query = $conexao->query("SELECT * FROM estados ORDER BY nome ASC");
                            while ($option = $query->fetch_assoc()) {
                                echo "<option value=\"{$option['id']}\">{$option['uf']} - {$option['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="cidade" class="form-label">Cidade:</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                    <div class="col-md-4">
                        <label for="bairro" class="form-label">Bairro:</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="endereco" class="form-label">Endereço:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" required>
                    </div>
                    <div class="col-md-2">
                        <label for="numero" class="form-label">Número:</label>
                        <input type="number" class="form-control" id="numero" name="numero">
                    </div>
                    <div class="col-md-5">
                        <label for="complemento" class="form-label">Complemento:</label>
                        <input type="text" class="form-control" id="complemento" name="complemento">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="foto_vaga" class="form-label">Selecione uma imagem da vaga:</label>
                        <input type="file" name="foto_vaga" class="form-control" accept="assets/image/*" required />
                    </div>
                    <div class="col-md-2">
                        <label for="preco" class="form-label">Valor da diária:</label>
                        <input type="text" class="form-control" id="preco" name="preco" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_usuario" class="form-label">Usuário:</label><br>
                        <select name="id_usuario" class="form-select">
                            <?php
                            // Verifique se o ID do usuário logado está na sessão
                            if (isset($_SESSION['id'])) {
                                $usuario_logado_id = $_SESSION['id'];

                                // Consulte o banco de dados para obter o nome do usuário logado
                                $query_logado = $conexao->query("SELECT id, nome FROM usuarios WHERE id = $usuario_logado_id");

                                if ($usuario_logado = $query_logado->fetch_assoc()) {
                                    // Exiba o usuário logado como a opção selecionada
                                    echo "<option value=\"{$usuario_logado['id']}\" selected>{$usuario_logado['nome']}</option>";
                                }

                                // Opcional: Se você ainda quiser permitir a seleção de outros usuários (com cuidado!),
                                // você pode adicionar uma opção padrão ou listar os outros usuários aqui.
                                // Exemplo de opção padrão:
                                // echo "<option value=\"\" disabled>-- Selecione --</option>";

                                // Se você NÃO quiser permitir a seleção de outros usuários,
                                // você pode até mesmo desabilitar o select:
                                // echo '</select><input type="hidden" name="id_usuario" value="' . $usuario_logado['id'] . '">';
                                // e remover o restante do código dentro do <select>.

                            } else {
                                // Caso o ID do usuário não esteja na sessão (o que não deveria acontecer
                                // se o usuário estiver logado), você pode exibir uma mensagem ou
                                // redirecionar o usuário para a página de login.
                                echo "<option value=\"\" disabled>Usuário não identificado</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="btnCadastrar" class="btn btn-primary">Cadastrar Vaga</button>
                <button type="reset" onclick="limparFormulario()" class="btn btn-secondary">Limpar</button>
                <a href="buscaVagas.php" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>

    <?php require_once 'components/footer.php'; ?>

    <script>
        $(document).ready(function() {
            $('#cep').mask('00000-000');
            $('#preco').mask('000.000,00', {
                reverse: true
            });
        });
    </script>
</body>

</html>