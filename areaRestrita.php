
<!DOCTYPE html>
<?php
include_once("conexao.php");
session_start();


?>

<html lang="pt-br">
     <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm</title>
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

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="mb-4">
                    <a href="" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Adicionar Novo
                    </a>
                </div>

                <!-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" >Usuários Cadastrados</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>João da Silva</td>
                                        <td>joao.silva@email.com</td>
                                        <td>
                                            <a href="editar_usuario.php?id=1" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Excluir</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Maria Oliveira</td>
                                        <td>maria.oliveira@outroemail.com</td>
                                        <td>
                                            <a href="editar_usuario.php?id=2" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Editar</a>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Excluir</button>
                                        </td>
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>

        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5">
                <p class="m-0 text-center text-white">Copyright © Seu Site 2025</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>