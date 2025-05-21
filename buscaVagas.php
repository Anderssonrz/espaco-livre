<!DOCTYPE html>
<?php
include_once("conexao.php");

// Filtros
$filtros = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
$filtro_descricao = $filtros['filter']['descricao'] ?? '';
$filtro_cidade = $filtros['filter']['cidade'] ?? '';
$filtro_bairro = $filtros['filter']['bairro'] ?? '';
$filtro_preco = $filtros['filter']['preco'] ?? '';

// Condições SQL
$condicoes = [];
if (strlen($filtro_descricao)) {
    $condicoes[] = 'descricao LIKE "%' . str_replace(' ', '%', $filtro_descricao) . '%"';
}
if (strlen($filtro_cidade)) {
    $condicoes[] = 'cidade LIKE "%' . str_replace(' ', '%', $filtro_cidade) . '%"';
}
if (strlen($filtro_bairro)) {
    $condicoes[] = 'bairro LIKE "%' . str_replace(' ', '%', $filtro_bairro) . '%"';
}
if (strlen($filtro_preco)) {
    $condicoes[] = 'preco <= "' . $filtro_preco . '"';
}

// Cláusula Where
$where = !empty($condicoes) ? 'WHERE ' . implode(' AND ', $condicoes) : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <?php
        $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
        require_once 'components/head.php';   // <head> com CSS/meta/ …
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca Vagas</title>
</head>
<body>
    <?php require_once 'components/header.php'; ?><br><br><br><br><br>

    <header class="bg-dark py-1">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1></h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0">Visualize e gerencie as vagas disponíveis.</p> -->
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
                                    autocomplete="off" value="<?=$filtro_descricao?>">
                            </div>
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="filter[cidade]"
                                    autocomplete="off" value="<?=$filtro_cidade ?? ''?>">
                            </div>
                            <div class="mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="filter[bairro]"
                                    autocomplete="off" value="<?=$filtro_bairro ?? ''?>">
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label><br>
                                <input type="range" class="form-range" id="preco" name="filter[preco]" step="1" min="0"
                                    max="1000" value="<?=$filtro_preco ?? 1000?>"
                                    oninput="document.getElementById('pricerange').innerText = 'R$ ' + document.getElementById('preco').value">
                                <span id="pricerange">R$ <?=$filtro_preco ?? 1000?></span>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary mb-3" type="submit">Filtrar</button>
                                <a href="buscaVagas.php" class="btn btn-outline-secondary mb-3">Limpar filtros</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">
                    <?php
                    $sql_pesquisa = "SELECT * FROM `vagas` " . $where;
                    $result = mysqli_query($conexao, $sql_pesquisa);
                    while ($linha = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <div class="badge bg-dark text-white position-absolute"
                                    style="top: 0.5rem; right: 0.5rem">
                                    Vaga - Código <?php echo $linha['id'] ?>
                                </div>
                                <?php

                                $caminhoImagem = !empty($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg';?>
                                <img class="card-img-top" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Imagem da vaga" style="height: 300px; object-fit: cover;" />



                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $linha['descricao'] ?></h5>
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        Diária R$<?php echo $linha['preco'] ?><br>
                                        <?php echo $linha['cidade'] ?><br>
                                        <?php echo $linha['bairro'] ?><br>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a href="cadastrarReserva.php?id=<?php echo $linha['id']; ?>" class="btn btn-outline-dark mt-auto">Reservar Vaga</a>
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
            <p class="m-0 text-center text-white">Direitos autorais &copy; Your Website 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>


