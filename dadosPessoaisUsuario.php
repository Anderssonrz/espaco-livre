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

$sql_pesquisa = "SELECT * FROM `usuarios` WHERE id = $usuario_logado_id"; // Define a consulta padrão

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
    header("Location: listagemUsuarios.php");
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
    <title>Dados Pessoais</title>
</head>

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
                    <div class="mb-4"><br>
                        
                    </div>
                    <div class="card">
                        <div class="card-body">
                                <h5 class="card-title">Seus Dados Cadastrados</h5>
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
                                            <th scope="col">Data Cadastro</th>
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
            echo "</tr>";
        }
    }
?>
