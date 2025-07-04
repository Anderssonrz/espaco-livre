<?php
/* ------------- PHP (topo) ------------- */
include_once 'conexao.php'; // Sua conexão MySQLi ($conexao)
session_start();

// --- Coleta e Limpeza de todos os filtros ---
$filtros = $_GET['filter'] ?? []; // Usar $_GET diretamente é mais simples aqui

// Filtros de texto
$filtro_descricao = trim($filtros['descricao'] ?? '');
$filtro_cidade = trim($filtros['cidade'] ?? '');
$filtro_bairro = trim($filtros['bairro'] ?? '');

// Filtros de preço
$filtro_preco_min = $filtros['preco_min'] ?? null;
$filtro_preco_max = $filtros['preco_max'] ?? null;
// Valores para repopular os campos, com defaults
$display_preco_min = ($filtro_preco_min !== null && $filtro_preco_min !== '') ? htmlspecialchars($filtro_preco_min) : '0';
$display_preco_max = ($filtro_preco_max !== null && $filtro_preco_max !== '') ? htmlspecialchars($filtro_preco_max) : '1000';

// Filtros de data
// $filtro_data_inicio = trim($filtros['data_inicio'] ?? '');
// $filtro_data_fim = trim($filtros['data_fim'] ?? '');


// --- Construção da Query SQL ---
$condicoes = [];
$params = [];
$types = "";

// 1. Condição base: vaga deve estar ativa
$condicoes[] = "v.status_vaga = 'ativa'";

// 2. Filtro de Data de Disponibilidade (o mais importante)
$datas_validas = false;
if (!empty($filtro_data_inicio) && !empty($filtro_data_fim)) {
    try {
        $inicio = new DateTime($filtro_data_inicio);
        $fim = new DateTime($filtro_data_fim);
        if ($fim >= $inicio) {
            $datas_validas = true;
        }
    } catch (Exception $e) {
        // Data inválida, ignora o filtro de data
    }
}

if ($datas_validas) {
    // Adiciona a subquery para excluir vagas com reservas conflitantes no período
    $condicoes[] = "NOT EXISTS (
        SELECT 1 
        FROM reservas r
        WHERE r.id_vaga = v.id
          AND r.status = 'r'
          AND ? <= DATE_ADD(r.data_reserva, INTERVAL r.quant_dias - 1 DAY) -- Data de início do filtro vs Fim da reserva
          AND ? >= r.data_reserva                                         -- Data de fim do filtro vs Início da reserva
    )";
    $params[] = $filtro_data_inicio;
    $params[] = $filtro_data_fim;
    $types .= "ss";
}

// 3. Adicionar outros filtros (texto e preço)
if (!empty($filtro_descricao)) {
    $condicoes[] = 'v.descricao LIKE ?';
    $params[] = '%' . $filtro_descricao . '%';
    $types .= "s";
}
if (!empty($filtro_cidade)) {
    $condicoes[] = 'v.cidade LIKE ?';
    $params[] = '%' . $filtro_cidade . '%';
    $types .= "s";
}
if (!empty($filtro_bairro)) {
    $condicoes[] = 'v.bairro LIKE ?';
    $params[] = '%' . $filtro_bairro . '%';
    $types .= "s";
}
if ($filtro_preco_min !== null && $filtro_preco_min !== '' && is_numeric($filtro_preco_min)) {
    $condicoes[] = 'v.preco >= ?';
    $params[] = floatval($filtro_preco_min);
    $types .= "d";
}
if ($filtro_preco_max !== null && $filtro_preco_max !== '' && is_numeric($filtro_preco_max)) {
    $condicoes[] = 'v.preco <= ?';
    $params[] = floatval($filtro_preco_max);
    $types .= "d";
}

// Monta a cláusula WHERE
$where_clause = 'WHERE ' . implode(' AND ', $condicoes);

// Monta a query final
// Se as datas NÃO foram filtradas, ainda precisamos saber quando a vaga ficará disponível
$coluna_disponibilidade = !$datas_validas ?
    ",(SELECT MIN(DATE_ADD(r.data_reserva, INTERVAL r.quant_dias DAY))
      FROM reservas r
      WHERE r.id_vaga = v.id
        AND r.status = 'r'
        AND DATE_ADD(r.data_reserva, INTERVAL r.quant_dias - 1 DAY) >= CURDATE()
     ) AS proxima_data_disponivel"
    : ", NULL AS proxima_data_disponivel"; // Se filtramos por data, todas são consideradas disponíveis

$sql_pesquisa = "SELECT v.* " . $coluna_disponibilidade . "
                FROM `vagas` v " . $where_clause . " ORDER BY v.preco ASC, v.id DESC";

$stmt_pesquisa = mysqli_prepare($conexao, $sql_pesquisa);
$result = null;

if ($stmt_pesquisa) {
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt_pesquisa, $types, ...$params);
    }
    mysqli_stmt_execute($stmt_pesquisa);
    $result = mysqli_stmt_get_result($stmt_pesquisa);
} else {
    error_log("Erro ao preparar a consulta de vagas: " . mysqli_error($conexao));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    $pageTitle = 'Vagas Disponíveis – Espaço Livre';
    require_once 'components/head.php';
    ?>
    <style>
        .card {
            transition: transform .2s ease-out, box-shadow .2s ease-out;
            border-radius: 0.5rem;
            /* Bordas mais arredondadas */
            border: 1px solid #e9ecef;
            /* Borda sutil */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .card-title {
            color: #333;
            /* Cor mais escura para o título */
            min-height: 3em;
            /* Para alinhar títulos com alturas diferentes se houver */
        }

        .card-body .text-muted {
            font-size: 0.9em;
        }

        .badge.status-badge {
            /* Classe específica para o badge de status */
            font-size: 0.8em;
            padding: 0.4em 0.6em;
        }

        .card-footer {
            background-color: #f8f9fa;
            /* Fundo levemente diferente para o footer */
        }

        .price-display {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
            /* Verde para o preço */
        }
    </style>
</head>

<body class="buscaVaga">
    <?php require_once 'components/header.php'; ?>

    <main class="main">
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-lg-8">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <h1 class="mb-4 display-4">
                                Encontre o espaço perfeito para o
                                <span class="accent-text">seu veículo</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title">Filtros</h4>
                            <hr>
                            <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

                                <!-- Filtrar por data 
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <label for="filter_data_inicio" class="form-label">Data de Início</label>
                                        <input type="date" class="form-control form-control-sm" id="filter_data_inicio" name="filter[data_inicio]"
                                            value="<?= htmlspecialchars($filtro_data_inicio) ?>"
                                            min="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="filter_data_fim" class="form-label">Data de Fim</label>
                                        <input type="date" class="form-control form-control-sm" id="filter_data_fim" name="filter[data_fim]"
                                            value="<?= htmlspecialchars($filtro_data_fim) ?>"
                                            min="<?= date('Y-m-d') ?>">
                                    </div>
                                </div> -->

                                <div class="mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <input type="text" class="form-control form-control-sm" id="descricao" name="filter[descricao]"
                                        autocomplete="off" value="<?= htmlspecialchars($filtro_descricao) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control form-control-sm" id="cidade" name="filter[cidade]"
                                        autocomplete="off" value="<?= htmlspecialchars($filtro_cidade) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text" class="form-control form-control-sm" id="bairro" name="filter[bairro]"
                                        autocomplete="off" value="<?= htmlspecialchars($filtro_bairro) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Preço (R$)</label>
                                    <div class="price-inputs">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">Min</span>
                                                    <input type="number" class="form-control min-price-input"
                                                        name="filter[preco_min]"
                                                        placeholder="Mínimo"
                                                        min="0"
                                                        max="10000"
                                                        value="<?= htmlspecialchars($display_preco_min) ?>"
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
                                                        value="<?= htmlspecialchars($display_preco_max) ?>"
                                                        step="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-actions mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn btn-outline-secondary">Limpar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row gx-4 gy-4 row-cols-1 row-cols-sm-2 row-cols-lg-3">
                        <?php
                        if ($result && mysqli_num_rows($result) > 0):
                            while ($linha = mysqli_fetch_assoc($result)):
                                // A vaga está disponível se a 'proxima_data_disponivel' for NULA.
                                // Se filtramos por data, ela sempre será NULA para os resultados, significando que está disponível.
                                $disponivel = is_null($linha['proxima_data_disponivel']);

                                $status_texto = $disponivel ? 'Disponível' : 'Ocupada';
                                $status_badge_class = $disponivel ? 'bg-success' : 'bg-danger';
                        ?>
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="badge <?= $status_badge_class ?> text-white position-absolute status-badge"
                                            style="top: 0.75rem; right: 0.75rem; z-index: 1;">
                                            <?= $status_texto ?>
                                        </div>
                                        <div class="badge bg-dark text-white position-absolute"
                                            style="top: 0.75rem; left: 0.75rem; z-index: 1; font-size: 0.75em; padding: 0.3em 0.5em;">
                                            Cód: <?= $linha['id'] ?>
                                        </div>
                                        <?php
                                        $caminhoImagem = !empty($linha['foto_vaga']) && file_exists($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg';
                                        ?>
                                        <a href="detalhes_vaga.php?id=<?= $linha['id'] ?>">
                                            <img class="card-img-top" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Imagem da Vaga: <?= htmlspecialchars($linha['descricao']) ?>"
                                                style="height: 200px; object-fit: cover;">
                                        </a>
                                        <div class="card-body p-3 d-flex flex-column">
                                            <div class="text-center mb-auto">
                                                <h5 class="card-title">
                                                    <a href="detalhes_vaga.php?id=<?= $linha['id'] ?>" class="text-decoration-none text-dark">
                                                        <?= htmlspecialchars($linha['descricao']) ?>
                                                    </a>
                                                </h5>
                                                <p class="text-muted small mb-1">
                                                    <?= htmlspecialchars($linha['cidade']) ?> - <?= htmlspecialchars($linha['bairro']) ?>
                                                </p>
                                                <p class="price-display mb-2">
                                                    R$<?= number_format($linha['preco'], 2, ',', '.') ?> <span style="font-size:0.8em; color:#6c757d;">/ dia</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer p-3 pt-0 border-top-0 bg-transparent text-center">
                                            <?php
                                            $id_usuario_logado = $_SESSION['id'] ?? null;

                                            // CASO 1: Vaga pertence ao usuário logado
                                            if ($id_usuario_logado && $linha['id_usuario'] == $id_usuario_logado) {
                                            ?>
                                                <a href="account.php#tab-vagas" class="btn btn-success mt-auto w-100">
                                                    <i class="bi bi-gear-fill me-1"></i> Gerenciar Minha Vaga
                                                </a>
                                            <?php
                                                // CASO 2: Vaga está OCUPADA (e não é do usuário logado)
                                            } elseif (!$disponivel) {
                                            ?>
                                                <button class="btn btn-outline-secondary mt-auto w-100" disabled>Vaga Ocupada</button>
                                                <?php if (!empty($linha['proxima_data_disponivel'])): ?>
                                                    <p class="text-info small mb-0 mt-2">
                                                        Disponível a partir de:<br>
                                                        <strong><?= htmlspecialchars(date('d/m/Y', strtotime($linha['proxima_data_disponivel']))) ?></strong>
                                                    </p>
                                                <?php endif; ?>
                                            <?php
                                                // CASO 3: Vaga está DISPONÍVEL (e não é do usuário logado)
                                            } else {
                                            ?>
                                                <a href="cadastrarReserva.php?id=<?= $linha['id']; ?>" class="btn btn-primary mt-auto w-100">
                                                    Reservar
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                        else:
                            ?>
                            <div class="col-12">
                                <div class="alert alert-info text-center" role="alert">
                                    Nenhuma vaga encontrada com os filtros aplicados. <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="alert-link">Limpar filtros</a>?
                                </div>
                            </div>
                        <?php
                        endif;
                        if ($stmt_pesquisa) mysqli_stmt_close($stmt_pesquisa); // Fechar o statement
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </main>

    <?php require_once 'components/footer.php'; ?>
    <?php // Seus scripts JS comuns, como jQuery e jQuery Mask, devem estar no footer.php ou em components/scripts.php 
    ?>

</body>

</html>