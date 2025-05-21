<!DOCTYPE html>
<?php
session_start();
include_once("conexao.php");

// Verifique se o ID do usuário logado está na sessão
if (isset($_SESSION['id'])) {
    $usuario_logado_id = $_SESSION['id'];

    // Consulte o banco de dados para obter o nome do usuário logado
    $query_logado = $conexao->query("SELECT id, nome FROM usuarios WHERE id = $usuario_logado_id");

    if ($usuario_logado = $query_logado->fetch_assoc()) {
        // Exiba o usuário logado como a opção selecionada
        "<option value=\"{$usuario_logado['id']}\" selected>{$usuario_logado['nome']}</option>";
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

$sql_pesquisa = "SELECT * FROM `reservas` WHERE id_usuario = $usuario_logado_id"; // Define a consulta padrão

//if (isset($_POST['btnPesquisarVagas'])) {
    //$pesq = filter_input(INPUT_POST, 'id_vaga', FILTER_SANITIZE_NUMBER_INT);
   // if ($pesq) {
    //    $sql_pesquisa = "SELECT * FROM `vagas` WHERE `id` = $pesq";
   // } else {
     //   $_SESSION['msg'] = "<p class='text-warning'>Por favor, insira um ID para pesquisar.</p>";
    //}
//}

$resultado = $conexao->query($sql_pesquisa);

if (isset($_POST['btnRetornar'])) {
    header("Location: listagemVagas.php");
    exit(); // Importante adicionar exit() após o redirecionamento
}
?>


<!DOCTYPE html>
<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>

<body>
  <?php require_once 'components/header.php'; ?>
    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p> -->
            </div>
        </div>
    </header>

    
    <div class="content">
        <section class="py-4">
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="mb-4">
                        <a href="cadastrarVaga.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Adicionar Nova Vaga
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reservas Cadastradas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered w-100 table-expanded">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Usuário</th>
                                            <th scope="col">Vaga</th>
                                            <th scope="col">UF</th>
                                            <th scope="col">Cidade</th>
                                            <th scope="col">Bairro</th>
                                            <th scope="col">N.º</th>
                                            <th scope="col">N.º Dias</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Data reserva</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php listarVagas($conexao, $sql_pesquisa); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>        
    </div>
    
    <footer class="py-5 bg-dark mt-5">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    
</body>
</html>

<?php
    function listarVagas($conexao, $sql_pesquisa)
    {
        $result = mysqli_query($conexao, $sql_pesquisa);
        while ($linha = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $linha['id_reserva'] . "</td>";
            echo "<td>" . $linha['id_usuario'] . "</td>";
            echo "<td>" . $linha['id_vaga'] . "</td>";
            echo "<td>" . $linha['id_uf'] . "</td>";
            echo "<td>" . $linha['cidade'] . "</td>";
            echo "<td>" . $linha['bairro'] . "</td>";
            echo "<td>" . $linha['numero'] . "</td>";
            echo "<td>" . $linha['quant_dias'] . "</td>";
            echo "<td>" . $linha['valor_reserva'] . "</td>";
            echo "<td>" . $linha['data_reserva'] . "</td>";
            echo "<td>
                    <a class='btn btn-sm btn-warning' href='editReserva.php?id=" . $linha['id_reserva'] . "' id='editar' title='Editar'>
                        <i class='bi bi-pencil'>Editar</i>
                    </a>
                  </td>";
            echo "<td>
                    <a class='btn btn-sm btn-danger' href='deleteReserva.php?id=" . $linha['id_reserva'] . "' id='deletar' title='Delete' onclick=\"return confirm('Tem certeza que deseja excluir esta vaga?')\">
                        <i class='bi bi-trash-fill'>Excluir</i>
                    </a>
                  </td>";
            echo "</tr>";
        }
    }
?>
