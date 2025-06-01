<?php
/* ------------- PHP (topo) ------------- */
include_once 'conexao.php'; // Sua conexão MySQLi ($conexao)
session_start();

// Filtro de cidade
// Usando filter_input para mais segurança e trim para limpar espaços
$filtro_cidade_input = trim(filter_input(INPUT_GET, 'filter_cidade', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

$params_sql = [];
$types_sql = "";
$where_conditions_sql = [];

if (!empty($filtro_cidade_input)) {
  // Para buscar cidades que contenham o termo, mesmo que o usuário digite apenas parte
  $termo_cidade_sql = '%' . $filtro_cidade_input . '%';
  $where_conditions_sql[] = 'v.cidade LIKE ?';
  $params_sql[] = $termo_cidade_sql;
  $types_sql .= "s";
}

$where_clause_sql = "";
if (!empty($where_conditions_sql)) {
  $where_clause_sql = 'WHERE ' . implode(' AND ', $where_conditions_sql);
}

// Consulta SQL para buscar vagas e verificar disponibilidade
$sql_pesquisa = "SELECT
                    v.*,
                    EXISTS(SELECT 1
                           FROM reservas r
                           WHERE r.id_vaga = v.id
                             AND r.status = 'r'
                             AND DATE_ADD(r.data_reserva, INTERVAL r.quant_dias - 1 DAY) >= CURDATE()
                          ) AS esta_ocupada_ou_reservada_futuro
                FROM `vagas` v " . $where_clause_sql . " ORDER BY v.dataCadastro DESC, v.id DESC"; // Ordenar pelas mais recentes

$stmt_pesquisa = mysqli_prepare($conexao, $sql_pesquisa);
$result_vagas = null;

if ($stmt_pesquisa) {
  if (!empty($params_sql)) {
    mysqli_stmt_bind_param($stmt_pesquisa, $types_sql, ...$params_sql);
  }
  mysqli_stmt_execute($stmt_pesquisa);
  $result_vagas = mysqli_stmt_get_result($stmt_pesquisa);
} else {
  error_log("Erro ao preparar a consulta de vagas no index.php: " . mysqli_error($conexao));
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php
  $pageTitle = 'Espaço Livre – Encontre o Estacionamento Ideal';
  require_once 'components/head.php';
  ?>
  <style>
    .card {
      transition: transform .2s ease-out, box-shadow .2s ease-out;
      border-radius: 0.5rem;
      border: 1px solid #e9ecef;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }

    .card-title-link {
      color: #212529;
      /* Cor padrão de texto escuro do Bootstrap */
      text-decoration: none;
    }

    .card-title-link:hover {
      color: #0d6efd;
      /* Cor primária do Bootstrap ao passar o mouse */
    }

    .card-body .text-muted {
      font-size: 0.9em;
    }

    .badge.status-badge {
      font-size: 0.8em;
      padding: 0.4em 0.6em;
    }

    .card-footer {
      background-color: #f8f9fa;
    }

    .price-display {
      font-size: 1.15rem;
      /* Um pouco menor que na buscaVagas para diferenciar */
      font-weight: bold;
      color: #198754;
      /* Verde sucesso do Bootstrap */
    }

    /* Estilo para o card de "Nenhuma vaga" */
    .no-vagas-card {
      border: 1px dashed #ccc;
      background-color: #f8f9fa;
    }
  </style>
</head>

<body class="index-page">
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

    <section id="vagas-destaque" class="features section bg-light pt-5 pb-5">
      <div class="container section-title" data-aos="fade-up">
        <h2 class="display-5">Vagas em Destaque</h2>
      </div>

      <div class="container mt-4">
        <div class="row justify-content-center mb-5">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="shadow-sm p-3 rounded bg-white">

              <div class="input-group">
                <input type="text" class="form-control form-control-lg"
                  id="filter_cidade" name="filter_cidade"
                  placeholder="Digite o nome da cidade"
                  value="<?= htmlspecialchars($filtro_cidade_input) ?>">
                <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i> Filtrar</button>
                <a href="index.php" class="btn btn-outline-secondary btn-lg">Limpar</a>
              </div>
            </form>
          </div>
        </div>

        <div class="row gx-4 gy-5 row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
          <?php
          if ($result_vagas && mysqli_num_rows($result_vagas) > 0):
            while ($linha = mysqli_fetch_assoc($result_vagas)):
              $disponivel = !$linha['esta_ocupada_ou_reservada_futuro'];
              $status_texto = $disponivel ? 'Disponível' : 'Ocupada';
              $status_badge_class = $disponivel ? 'bg-success' : 'bg-danger';
          ?>
              <div class="col" data-aos="fade-up" data-aos-delay="150">
                <div class="card h-100 shadow-sm">
                  <div class="badge <?= $status_badge_class ?> text-white position-absolute status-badge"
                    style="top: 0.75rem; right: 0.75rem; z-index: 1;">
                    <?= $status_texto ?>
                  </div>
                  <?php if (false): // Opcional: Badge com código da vaga, se desejar. Por ora, falso para não exibir. 
                  ?>
                    <div class="badge bg-dark text-white position-absolute"
                      style="top: 0.75rem; left: 0.75rem; z-index: 1; font-size: 0.75em; padding: 0.3em 0.5em;">
                      Cód: <?= $linha['id'] ?>
                    </div>
                  <?php endif; ?>

                  <?php
                  $caminhoImagem = !empty($linha['foto_vaga']) && file_exists($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg';
                  ?>

                  <img class="card-img-top" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Imagem da Vaga: <?= htmlspecialchars($linha['descricao']) ?>"
                    style="height: 250px; object-fit: cover;">

                  <div class="card-body p-3 d-flex flex-column">
                    <div class="text-start mb-auto">
                      <h5 class="card-title mb-1">
                        <?= htmlspecialchars($linha['descricao']) ?>
                        </a>
                      </h5>
                      <p class="text-muted small mb-2">
                        <i class="bi bi-geo-alt-fill me-1"></i><?= htmlspecialchars($linha['cidade']) ?>, <?= htmlspecialchars($linha['bairro']) ?>
                      </p>
                      <p class="price-display mb-0">
                        R$<?= number_format($linha['preco'], 2, ',', '.') ?> <span style="font-size:0.75em; color:#6c757d;">/ dia</span>
                      </p>
                    </div>
                    <div class="d-flex justify-content-start small text-warning mt-2">
                      <?php for ($i = 0; $i < 5; $i++) echo '<i class="bi bi-star-fill me-1"></i>'; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endwhile;
          else:
            ?>
            <div class="col-12">
              <div class="card no-vagas-card shadow-none">
                <div class="card-body text-center p-5">
                  <i class="bi bi-車-front" style="font-size: 3rem; color: #6c757d;"></i>
                  <p class="lead mt-3">Nenhuma vaga encontrada<?= !empty($filtro_cidade_input) ? ' para a cidade "' . htmlspecialchars($filtro_cidade_input) . '"' : '' ?>.</p>
                  <?php if (!empty($filtro_cidade_input)): ?>
                    <a href="index.php" class="btn btn-sm btn-outline-primary">Limpar filtro e ver todas as vagas</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php
          endif;
          if ($stmt_pesquisa) mysqli_stmt_close($stmt_pesquisa);
          ?>
        </div>
      </div>
    </section>


  </main>

  <?php require_once 'components/footer.php'; ?>
  <?php // Seus scripts JS comuns aqui ou no footer.php 
  ?>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script>
    // Inicializar AOS (Animate On Scroll) se estiver usando
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 600,
        easing: 'ease-in-out',
        once: true,
        mirror: false
      });
    }
  </script>
</body>

</html>