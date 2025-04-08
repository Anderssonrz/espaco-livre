<!DOCTYPE html>
<?php
session_start();
include_once("conexao.php");

if (isset($_POST['btnPesquisarVagas'])) {
    $pesq = $_POST['id'];
    $sql_pesquisa = "SELECT * FROM `vagas` WHERE `id` = $pesq";
} else {
    $sql_pesquisa = "SELECT * FROM `vagas`";
}
$resultado = $conexao->query($sql_pesquisa);

if (isset($_POST['btnRetornar'])) {
    header("refresh: url=listagemVagas.php");
}

?>

<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Listagem vagas</title>
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
                <h1>Listagem de Vagas</h1>
                <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="mb-3">
                    <form action="" method="POST">
                        <label for="id_loja" class="form-label"><b>Pesquisar vaga por código:</b></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="id_loja" id="id_loja" placeholder="Código da vaga" />
                            <button type="submit" name="btnPesquisarVagas" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <button type="submit" name="btnRetornar" class="btn btn-secondary">
                                <i class="bi bi-reply-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <section class="mt-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">UF</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Bairro</th>
                            <th scope="col">Rua</th>
                            <th scope="col">Número</th>
                            <th scope="col">Complemento</th>
                            <th scope="col">Foto vaga</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Editar/Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php listarVagas($conexao, $sql_pesquisa); ?>
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
    function listarVagas($conexao, $sql_pesquisa)
    {
        $result = mysqli_query($conexao, $sql_pesquisa);
        while ($linha = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $linha['descricao'] . "</td>";
            echo "<td>" . $linha['id_uf'] . "</td>";
            echo "<td>" . $linha['cidade'] . "</td>";
            echo "<td>" . $linha['bairro'] . "</td>";
            echo "<td>" . $linha['endereco'] . "</td>";
            echo "<td>" . $linha['numero'] . "</td>";
            echo "<td>" . $linha['complemento'] . "</td>";
            echo "<td>" . $linha['foto_vaga'] . "</td>";
            echo "<td>" . $linha['preco'] . "</td>";
            echo "<td> 
                    <a class='btn btn-sm btn-primary' href='editVaga.php?id=" . $linha['id'] . "' id='editar' title='Editar'>
                        <i class='bi bi-pencil'></i>
                    </a>
                    <a class='btn btn-sm btn-danger' href='deleteVaga.php?id=" . $linha['id'] . "' id='deletar' title='Delete'>
                        <i class='bi bi-trash-fill'></i>
                    </a>
                  </td>";
            echo "</tr>";
        }
    }
    ?>
</body>
</html>