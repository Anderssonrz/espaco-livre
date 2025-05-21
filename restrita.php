<?php
include_once("conexao.php");
session_start();

// Verificar se o usuário está logado
// if (!isset($_SESSION['email'])) {
//     header("Location: login.php");
//     exit();
// }

// Verificar o nível de acesso (opcional, se você tiver diferentes níveis de restrição)
// $nivel_acesso_necessario = 2; // Exemplo: apenas usuários com nível de acesso 2 podem acessar

// if ($_SESSION['nivel_acesso'] < $nivel_acesso_necessario) {
//     echo "Acesso negado. Você não tem permissão para acessar esta página.";
//     exit();
// }
?>

<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Listagem de Usuários</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">HOME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                </ul>
            </div>
        </div>
    </nav>

    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1>Listagem de Usuários</h1>
                <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie os usuários cadastrados</p>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="mb-3">
                    <form action="" method="POST" class="form-inline">
                        <label for="id_usuario" class="form-label"><b>Pesquisar Usuário por Código:</b></label><br>
                        <div class="input-group">
                            <input type="number" class="form-control" name="id_usuario" id="id_usuario" placeholder="Código do usuário" />
                            <button type="submit" name="btnPesquisarUsuarios" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <button type="submit" name="btnRetornar" class="btn btn-secondary">
                                <i class="bi bi-reply-fill"></i>
                            </button>
                        </div>
                    </form>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                </div>
            </div>
        </div>

        <section class="mt-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Senha</th>
                            <th scope="col">Editar/Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php listarUsuarios($conexao, $sql_pesquisa); ?>
                    </tbody>
                </table>
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
            echo "<td>
                          <a class='btn btn-sm btn-primary' href='editUsuario.php?id=" . $linha['id'] . "' id='editar' title='Editar'>
                              <i class='bi bi-pencil'></i>
                          </a>
                          <a class='btn btn-sm btn-danger' href='deleteUsuario.php?id=" . $linha['id'] . "' id='deletar' title='Delete' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?')\">
                              <i class='bi bi-trash-fill'></i>
                          </a>
                      </td>";
            echo "</tr>";
        }
    }
    ?>
</body>

</html>