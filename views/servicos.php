<?php
include_once("conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Página Inicial</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">Espaço Livre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="servicosAdmin"></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Área Restrita</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Gerenciar</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="/tecnologia-online-bd/cadastrarProduto.php">Cadastrar Vaga</a></li>
                            <li><a class="dropdown-item" href="/tecnologia-online-bd/listagemProdutos.php">Listar Vagas</a></li>
                            <li><a class="dropdown-item" href="/tecnologia-online-bd/cadastrarLoja.php">Cadastrar Usuário</a></li>
                            <li><a class="dropdown-item" href="/tecnologia-online-bd/listagemLojas.php">Listar Usuários</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class=""></i>
                        Login
                        <span class=""></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1>Encontre as melhores vagas</h1>
                <p class="lead fw-normal text-white-50 mb-0">Explore nossas ofertas e encontre a vaga para você.</p>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Filtros</h4>
                        <hr>
                        <form method="GET" action="">
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="filter[descricao]"
                                    autocomplete="off" value="">
                            </div>
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="filter[cidade]"
                                    autocomplete="off" value="">
                            </div>
                            <div class="mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="filter[bairro]"
                                    autocomplete="off" value="">
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label><br>
                                <input type="range" class="form-range" id="preco" name="filter[preco]" step="10" min="0"
                                    max="1000" value=""
                                    oninput="document.getElementById('pricerange').innerText = 'R$ ' + document.getElementById('preco').value">
                                <span id="pricerange"></span>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary mb-3" type="submit">Filtrar</button>
                                <a href="" class="btn btn-outline-secondary mb-3">Limpar filtros</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">
                    <?php
                    $sql_pesquisa = "SELECT * FROM `vagas`";
                    $result = mysqli_query($conexao, $sql_pesquisa);
                    while ($linha = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <div class="badge bg-dark text-white position-absolute"
                                    style="top: 0.5rem; right: 0.5rem">
                                    Vaga - Código <?php echo $linha['id'] ?>
                                </div>
                                <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                                    alt="..." />
                                <div class="card-body p-6">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $linha['descricao'] ?></h5>
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>                                            
                                        </div>
                                        <span class="text-muted text-decoration-line-through"></span>
                                        Diária R$<?php echo $linha['preco'] ?><br>

                                        <span class="text-muted text-decoration-line-through"></span>
                                        <?php echo $linha['cidade'] ?><br> 

                                        <span class="text-muted text-decoration-line-through"></span>
                                        <?php echo $linha['bairro'] ?><br>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Reservar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>