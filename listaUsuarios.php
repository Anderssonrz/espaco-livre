<!DOCTYPE html>
<?php
session_start();
include_once("conexao.php");

$sql_pesquisa = "SELECT * FROM `usuarios`"; // Define a consulta padrão

if (isset($_POST['btnPesquisarUsuarios'])) {
    $pesq = filter_input(INPUT_POST, 'id_usuario', FILTER_SANITIZE_NUMBER_INT);
    if ($pesq) {
        $sql_pesquisa = "SELECT * FROM `usuarios` WHERE `id` = $pesq";
    } else {
        $_SESSION['msg'] = "<p class='text-warning'>Por favor, insira um ID para pesquisar.</p>";
    }
}

$resultado = $conexao->query($sql_pesquisa);

if (isset($_POST['btnRetornar'])) {
    header("Location: listaUsuarios.php");
    exit(); // Importante adicionar exit() após o redirecionamento
}

?>

<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
</head>
<body>
     <?php require_once 'components/headerTres.php'; ?><br><br><br><br><br>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p> -->
            </div>
        </div>
    </header>

    <div class="content">
        <!-- <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h2>Listagem de Usuários</h2>
                    <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie os usuários cadastrados</p>
                </div>
            </div>
        </header> -->

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <form action="" method="POST" class="form-inline">
                            <label for="id_usuario" class="form-label"><b>Pesquisar usuário:</b></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="id_usuario" id="id_usuario" placeholder="Código do usuário" />
                                <button type="submit" name="btnPesquisarUsuarios" class="btn btn-primary">
                                    <i class="bi bi-search"> Pesquisar</i>
                                </button>
                                <button type="submit" name="btnRetornar" class="btn btn-secondary">
                                    <i class="bi bi-reply-fill">Voltar</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <section class="py-5">
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="mb-4">
                        <a href="cadastrarUsuario.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Adicionar Novo Usuário
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                                <h5 class="card-title">Usuários Cadastrados</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">CPF</th>
                                            <th scope="col">Telefone</th>
                                            <th scope="col">E-mail</th>
                                            <th scope="col">Senha</th>
                                            <th scope="col">Data cadastro</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php listarUsuarios($conexao, $sql_pesquisa); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center text-white">Copyright &copy; Seu Website 2025</p>
            </div>
        </footer>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </div>

</body>
</html>

<?php
    function listarUsuarios($conexao, $sql_pesquisa)
    {
        $result = mysqli_query($conexao, $sql_pesquisa);
        while ($linha = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($linha['id']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['cpf']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
            echo "<td>" . '********' . "</td>"; // Não exibir a senha completa
            echo "<td>" . htmlspecialchars($linha['dataCadastro']) . "</td>";
            echo "<td>
                          <a class='btn btn-sm btn-warning' href='editUsuario.php?id=" . $linha['id'] . "' id='editar' title='Editar'>
                              <i class='bi bi-pencil'>Editar</i>
                          </a>
                  </td>";
            echo "<td>
                          <a class='btn btn-sm btn-danger' href='deleteUsuario.php?id=" . $linha['id'] . "' id='deletar' title='Delete' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?')\">
                              <i class='bi bi-trash-fill'>Excluir</i>
                          </a>
                  </td>";
            echo "</tr>";
        }
    }
?>

