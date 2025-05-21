<!DOCTYPE html>
<?php
session_start();
include_once("conexao.php");

$sql_pesquisa = "SELECT * FROM `reservas`"; // Define a consulta padrão

if (isset($_POST['btnPesquisarReservas'])) {
    $pesq = filter_input(INPUT_POST, 'id_reserva', FILTER_SANITIZE_NUMBER_INT);
    if ($pesq) {
        $sql_pesquisa = "SELECT * FROM `reservas` WHERE `id_reserva` = $pesq";
    } else {
        $_SESSION['msg'] = "<p class='text-warning'>Por favor, insira um ID para pesquisar.</p>";
    }
}

$resultado = $conexao->query($sql_pesquisa);

if (isset($_POST['btnRetornar'])) {
    header("Location: listaReservas.php");
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
    <title>Document</title>
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
                        <form action="" method="POST">
                            <label for="id_reserva" class="form-label"><b>Pesquisar reserva:</b></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="id_reserva" id="id_reserva" placeholder="Código da reserva" />
                                <button type="submit" name="btnPesquisarReservas" class="btn btn-primary">
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
                    <div class="card">
                        <div class="card-body">
                                <h5 class="card-title">Reservas Cadastradas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Usuário</th>
                                            <th scope="col">Vaga</th>
                                            <th scope="col">UF</th>
                                            <th scope="col">Cidade</th>
                                            <th scope="col">Bairro</th>
                                            <th scope="col">Rua</th>
                                            <th scope="col">N.º</th>
                                            <th scope="col">N.º de Dias</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Data da Reserva</th>
                                            <!-- <th scope="col"></th>
                                            <th scope="col"></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php listarReservas($conexao, $sql_pesquisa); ?>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>

</body>
</html>

<?php
    function listarReservas($conexao, $sql_pesquisa)
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
            echo "<td>" . $linha['endereco'] . "</td>";
            echo "<td>" . $linha['numero'] . "</td>";
            echo "<td>" . $linha['quant_dias'] . "</td>";
            echo "<td>" . $linha['valor_reserva'] . "</td>";
            echo "<td>" . $linha['data_reserva'] . "</td>";
            // echo "<td> 
            //             <a class='btn btn-sm btn-warning' href='editReserva.php?id=" . $linha['id_reserva'] . "' id='editar' title='Editar'>
            //                 <i class='bi bi-pencil'>Editar</i>
            //             </a>
            //       </td>";
            // echo "<td>
            //             <a class='btn btn-sm btn-danger' href='deleteReserva.php?id=" . $linha['id_reserva'] . "' id='deletar' title='Delete' onclick=\"return confirm('Tem certeza que deseja excluir esta reserva?')\">
            //                 <i class='bi bi-trash-fill'>Excluir</i>
            //             </a>
            //       </td>";
            echo "</tr>";
        }
    }
?>