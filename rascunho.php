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
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Página para visualizar e gerenciar usuários cadastrados." />
    <meta name="author" content="Seu Nome ou Nome da Empresa" />
    <title>Lista de Usuários</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px; /* Largura da sidebar */
            background-color: #f8f9fa; /* Cor de fundo da sidebar */
            padding-top: 56px; /* Ajuste para a altura da navbar */
            border-right: 1px solid #dee2e6;
            z-index: 100; /* Garante que a sidebar fique acima de outros elementos */
        }

        .sidebar .nav-link {
            padding: 12px 16px;
            color: #333;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }

        .content {
            margin-left: 0px; /* Espaço para a sidebar */
            padding: 20px;
        }

        /* Estilos para telas menores */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 56px; /* Altura da navbar */
                left: -250px; /* Esconde a sidebar inicialmente */
                width: 250px;
                transition: left 0.3s ease-in-out;
            }

            .sidebar.show {
                left: 0; /* Mostra a sidebar quando a classe 'show' é adicionada */
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            /* Botão para mostrar/ocultar a sidebar em telas menores */
            .navbar-toggler {
                margin-left: auto; /* Empurra o toggler para a direita */
            }     
            
           

        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                        <a class="nav-link" href="index.php">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastrarVaga.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="areaRestritaUsuario.php"></a>
                    </li>
                </ul>
            </div>
            <div>
           
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="p-4">
            <div>
                <!-- <a class="nav-link" href="index.php"><h4>Página Inicial</h4></a><br> -->
            </div>
            <h4>Listas de Registros</h4>
            <ul class="nav flex-column">
               
                <li class="nav-item">
                    <a class="nav-link" href="listaUsuarios.php">Usuários cadastrados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listaVagas.php">Vagas cadastradas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listaReservas.php">Reservas cadastradas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sair.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content">
              
            <section class="py-5">
                <div class="container px-4 px-lg-5 mt-5">
                  
                    <div class="card">
                        <div class="card-body">
                                <h5 class="card-title">Seus Dados Cadastrados</h5>
                            <div class="table-responsive">
                                <table>
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
        echo "<td> CÓDIGO: </td>";
        echo "<td>" . htmlspecialchars($linha['id']) . "</td>";
        echo "</tr>";
        echo "<tr>   </tr>"; // Linha em branco entre Código e Nome
        echo "<tr>";
        echo "<td> NOME: </td>";
        echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
        echo "<td> CPF: </td>";
        echo "<td>" . htmlspecialchars($linha['cpf']) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td> TELEFONE: </td>";
        echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
        echo "<td> E-MAIL: </td>";
        echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td> SENHA: </td>";
        echo "<td>" . '********' . "</td>"; // Não exibir a senha completa
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td>";
        echo "<a class='btn btn-sm btn-warning' href='editUsuario.php?id=" . $linha['id'] . "' title='Editar'>";
        echo "<i class='bi bi-pencil'>Editar</i>";
        echo "</a>";
        echo " ";
        echo "<a class='btn btn-sm btn-danger' href='deleteUsuario.php?id=" . $linha['id'] . "' title='Excluir' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?')\">";
        echo "<i class='bi bi-trash-fill'>Excluir</i>";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
        echo "<tr></tr>"; // Linha extra para espaçamento após os botões (opcional)
    }
    echo "</tbody>";
    echo "</table>";
}
?>