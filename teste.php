<?php
/* ------------- PHP (topo) ------------- */
include_once 'conexao.php';
session_start();

// Filtros
$filtros = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
$filtro_descricao = $filtros['filter']['descricao'] ?? '';
$filtro_cidade = $filtros['filter']['cidade'] ?? '';
$filtro_bairro = $filtros['filter']['bairro'] ?? '';

// Novos filtros de preço (mínimo e máximo)
$filtro_preco_min_get = $filtros['filter']['preco_min'] ?? null;
$filtro_preco_max_get = $filtros['filter']['preco_max'] ?? null;

// Valores para exibir nos inputs (mantém o que foi submetido, ou usa defaults visuais)
// Os defaults '0' e '500' correspondem aos `value` iniciais que você definiu no HTML.
// Ajuste '500' para '1000' se o máximo padrão desejado for 1000.
$display_preco_min = ($filtro_preco_min_get !== null && $filtro_preco_min_get !== '') ? htmlspecialchars($filtro_preco_min_get) : '0';
$display_preco_max = ($filtro_preco_max_get !== null && $filtro_preco_max_get !== '') ? htmlspecialchars($filtro_preco_max_get) : '500';


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

// Condições para preço mínimo e máximo
// Verifica se o valor foi enviado, não é uma string vazia e é numérico
if ($filtro_preco_min_get !== null && $filtro_preco_min_get !== '' && is_numeric($filtro_preco_min_get)) {
    $condicoes[] = 'preco >= ' . floatval($filtro_preco_min_get);
}
if ($filtro_preco_max_get !== null && $filtro_preco_max_get !== '' && is_numeric($filtro_preco_max_get)) {
    $condicoes[] = 'preco <= ' . floatval($filtro_preco_max_get);
}

// Cláusula Where
$where = !empty($condicoes) ? 'WHERE ' . implode(' AND ', $condicoes) : '';
?>
?>

<!DOCTYPE html>
<html lang="pt-br">
<?php
$pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
require_once 'components/head.php';   // <head> com CSS/meta/ …
?>

<body class="index-page">
    <!-- Navbar / Header -->
    <?php require_once 'components/header.php'; ?>

    <main class="main">

        <!-- ============ HERO ============ -->
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <h1 class="mb-4">
                                Encontre o espaço perfeito para o
                                <span class="accent-text">seu veículo</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /HERO -->

        <!-- ============ VAGAS DISPONÍVEIS ============ -->
        <section id="features" class="features section">
            <br><br>
            <!-- Título da seção -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Vagas Disponíveis</h2><br>

            </div>

            <!-- Cards das vagas -->
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
                                            autocomplete="off" value="<?= $filtro_descricao ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="cidade" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="filter[cidade]"
                                            autocomplete="off" value="<?= $filtro_cidade ?? '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bairro" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="filter[bairro]"
                                            autocomplete="off" value="<?= $filtro_bairro ?? '' ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Preço (R$)</label> <div class="price-inputs">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Min</span>
                                                        <input type="number" class="form-control min-price-input" 
                                                               name="filter[preco_min]" 
                                                               placeholder="Mínimo" 
                                                               min="0" 
                                                               max="10000" 
                                                               value="<?= $display_preco_min ?>" 
                                                               step="1">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Max</span>
                                                        <input type="number" class="form-control max-price-input" 
                                                               name="filter[preco_max]" 
                                                               placeholder="Máximo" 
                                                               min="0" 
                                                               max="10000"
                                                               value="<?= $display_preco_max ?>" 
                                                               step="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-actions mt-3">
                                        <button class="btn btn-primary mb-3" type="submit">Filtrar</button>
                                        <a href="buscaVagas.php" class="btn btn-outline-secondary mb-3">Limpar filtros</a>
                                    </div>
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

                                    $caminhoImagem = !empty($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg'; ?>
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

    </main>

    <?php require_once 'components/footer.php'; ?>

    <!-- Botão scroll-top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/home.js"></script>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>