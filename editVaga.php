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

$titulo = "upload de foto_vaga";
?>

<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de vaga</title>
</head>
<body>
    <?php require_once 'components/headerQuatro.php'; ?><br><br><br><br><br>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p> -->
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Vaga código: <?php echo $linha_vaga['id']; ?></h2><br>

        <form action="saveEditVaga.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $linha_vaga['id']; ?>">
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
                    <select name="id_uf" class="form-select" aria-label="Default select example" required>
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
                    <label for="foto_vaga" class="form-label">Selecione a nova imagem (opcional)</label>
                    <input type="file" name="foto_vaga" accept="assets/image/*" class="form-control" />
                    <input type="hidden" name="foto_vaga_antiga" value="<?php echo $linha_vaga['foto_vaga']; ?>">
                    <?php if (!empty($linha_vaga['foto_vaga'])): ?>
                        <p>Foto atual: <?php echo basename($linha_vaga['foto_vaga']); ?></p>
                        <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" value="<?php echo $linha_vaga['preco']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_usuario" class="form-label">Usuário</label><br>
                     <select name="id_usuario" class="form-select" aria-label="Default select example" required>
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
                <div class="col-md-4">
                    <label for="dataCadastro" class="form-label">Data Cadastro</label>
                    <input type="date" class="form-control" id="dataCadastro" name="dataCadastro" value="<?php echo htmlspecialchars($linha_vaga['dataCadastro']); ?>" readonly>
                    <small class="form-text text-muted">A data de cadastro não pode ser alterada.</small>
                </div>
            </div>

            <button type="submit" name="btnCadastrar" class="btn btn-primary">Salvar Alterações</button>
            <button type="button" class="btn btn-danger">Cancelar</button>
        </form>
     </div><br><br> 
        

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Direitos autorais &copy; Your Website 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

