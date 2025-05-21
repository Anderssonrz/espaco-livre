<?php
/* ------------- PHP (topo) ------------- */
include_once 'conexao.php';
session_start();

/* Filtro de cidade --------------------------------------------------------- */
$filtros       = filter_input_array(INPUT_GET, FILTER_UNSAFE_RAW);
$filtro_cidade = $filtros['filter']['cidade'] ?? '';

$condicoes = [];
if ($filtro_cidade !== '') {
  $condicoes[] = 'cidade LIKE "%' . str_replace(' ', '%', $filtro_cidade) . '%"';
}
$where = $condicoes ? 'WHERE ' . implode(' AND ', $condicoes) : '';
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

      <!-- Formulário de filtro -->
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <form method="GET" class="mb-3" action="">
            <div class="input-group">
              <input type="text"
                class="form-control mb-2"
                placeholder="Digite o nome da sua cidade"
                id="cidade"
                name="filter[cidade]"
                autocomplete="off"
                value="<?= htmlspecialchars($filtro_cidade) ?>">
              <button class="btn btn-primary mb-2" type="submit">Filtrar</button>
              <a href="index.php" class="btn btn-outline-secondary mb-2">Limpar</a>
            </div>
          </form>
        </div>
      </div>

      <!-- Cards das vagas -->
      <div class="container py-5">
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">
          <?php

          $sql_pesquisa = "SELECT * FROM `vagas` " . $where;
          $result = mysqli_query($conexao, $sql_pesquisa);

          if (mysqli_num_rows($result) > 0) {
            while ($linha = mysqli_fetch_assoc($result)) {
          ?>
              <div class="col mb-5">
                <div class="card h-100">
                  <?php
                  $caminhoImagem = !empty($linha['foto_vaga']) ? $linha['foto_vaga'] : 'assets/img/sem-imagem.jpg';?>
                                <img class="card-img-top" src="<?= htmlspecialchars($caminhoImagem) ?>" alt="Imagem da vaga" style="height: 300px; object-fit: cover;" />


                  <div class="card-body p-4">
                    <div class="text-center">
                      <h5 class="fw-bolder"><?= $linha['descricao'] ?></h5>
                      <div class="d-flex justify-content-center small text-warning mb-2">
                        <?php for ($i = 0; $i < 5; $i++) echo '<div class="bi-star-fill"></div>'; ?>
                      </div>
                      <span>R$<?= number_format($linha['preco'], 2, ',', '.') ?> por dia</span><br>
                      <small class="text-muted"><?= $linha['cidade'] ?>, <?= $linha['bairro'] ?></small>
                    </div>
                  </div>
                  <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                      
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo '<div class="col-12 text-center mt-4"><p class="lead">Nenhuma vaga disponível no momento.</p></div>';
          }
          ?>
        </div>
      </div>

    </section>
    <!-- /VAGAS DISPONÍVEIS -->

    <!-- ============ SERVICES / EXEMPLO DE OUTRA SEÇÃO ============ -->
    <    <!-- Services Section -->
    <section id="services" class="services section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-card d-flex">
              <div class="icon flex-shrink-0">
                <i class="bi bi-activity"></i>
              </div>
              <div>
                <h3>Nesciunt Mete</h3>
                <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores iure perferendis tempore et consequatur.</p>
                <a href="service-details.html" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-card d-flex">
              <div class="icon flex-shrink-0">
                <i class="bi bi-diagram-3"></i>
              </div>
              <div>
                <h3>Eosle Commodi</h3>
                <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum hic non ut nesciunt dolorem.</p>
                <a href="service-details.html" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-card d-flex">
              <div class="icon flex-shrink-0">
                <i class="bi bi-easel"></i>
              </div>
              <div>
                <h3>Ledo Markt</h3>
                <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id voluptas adipisci eos earum corrupti.</p>
                <a href="service-details.html" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Card -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-card d-flex">
              <div class="icon flex-shrink-0">
                <i class="bi bi-clipboard-data"></i>
              </div>
              <div>
                <h3>Asperiores Commodit</h3>
                <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea fuga sit provident adipisci neque.</p>
                <a href="service-details.html" class="read-more">Read More <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Card -->

        </div>

      </div>

    </section><!-- /Services Section -->

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