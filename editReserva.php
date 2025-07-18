<!DOCTYPE html>
<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$select_reserva = "SELECT * FROM reservas WHERE reservas.id_reserva = '$id'";

$result_reserva = mysqli_query($conexao, $select_reserva);
$linha_reserva = mysqli_fetch_assoc($result_reserva);
?>

<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição dados da reserva</title>
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
        <h2>Reserva código: <?php echo $linha_reserva['id_reserva']; ?></h2><br>

        <form action="saveEditReserva.php" method="POST" enctype="multipart/form-data">
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
            

                <div class="col-md-6">
                    <label for="id_reserva" class="form-label">Código da reserva</label><br>
                    <select name="id_reserva" class="form-select" required>
                        <option value="">Selecione a Vaga</option>
                        <?php
                        if (isset($_GET['id'])) {
                            $id_vaga_selecionada = $_GET['id'];
                            $query = $conexao->query("SELECT id, descricao FROM vagas WHERE id = $id_vaga_selecionada");
                            if ($vaga = $query->fetch_assoc()) {
                                echo "<option value=\"{$vaga['id']}\" selected>{$vaga['id']} - {$vaga['descricao']}</option>";
                            } else {
                                echo "<option value=\"\">Vaga não encontrada</option>";
                            }
                        } else {
                            $query = $conexao->query("SELECT id, descricao FROM vagas ORDER BY id ASC");
                            while ($option = $query->fetch_assoc()) {
                                echo "<option value=\"{$option['id']}\">{$option['id']} - {$option['descricao']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div><br>

            <div class="row mb-3">
            <div class="col-md-4">
                    <label for="id_uf" class="form-label">UF:</label><br>
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
                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $linha_reserva['cidade']; ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $linha_reserva['bairro']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $linha_reserva['endereco']; ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="number" class="form-control" id="numero" name="numero" value="<?php echo $linha_reserva['numero']; ?>">
                </div>
                <div class="col-md-5">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $linha_reserva['complemento']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="quant_dias" class="form-label">Quantidade de dias</label>
                    <input type="number" class="form-control" id="quant_dias" name="quant_dias" step="1" value="<?php echo $linha_reserva['quant_dias']; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="valor_reserva" class="form-label">Valor da diária</label>
                    <input type="number" class="form-control" id="valor_reserva" name="valor_reserva" step="0.01" value="<?php echo $linha_reserva['valor_reserva']; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="data_reserva" class="form-label">Data Reserva</label>
                    <input type="date" class="form-control" id="data_reserva" name="data_reserva" value="<?php echo $linha_reserva['data_reserva']; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="r">Reservado</option>
                        <option value="l">Liberado</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="btnCadastrar">Reservar Vaga</button>
            <button type="button" onclick="limparFormulario()" class="btn btn-primary">Limpar</button>
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