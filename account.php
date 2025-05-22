<?php
session_start();
include_once 'conexao.php'; // Garanta que $conn (PDO) seja inicializado aqui

// Exibe feedback da sessão (ex: após atualização do perfil)
if (isset($_SESSION['feedback'])) {
    echo '<div class="container mt-3"><div class="alert alert-' . htmlspecialchars($_SESSION['feedback']['type']) . '" role="alert">'; // Adicionado container para melhor posicionamento
    echo htmlspecialchars($_SESSION['feedback']['message']);
    echo '</div></div>';
    unset($_SESSION['feedback']); // Importante: Limpa a mensagem após exibi-la
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$usuario = null; // Inicializa a variável

// Buscar dados do usuário no banco
try {
    $stmt = $conn->prepare("SELECT nome, cpf, telefone, email FROM usuarios WHERE id = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        session_destroy();
        header("Location: login.php?erro=usuario_invalido");
        exit();
    }
} catch (PDOException $e) {
    // Em produção, logue o erro ($e->getMessage()) e mostre uma mensagem amigável.
    die("Erro ao carregar informações do usuário. Tente novamente mais tarde.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php
$pageTitle = 'Minha Conta – Espaço Livre';
require_once 'components/head.php';
?>

<body class="account-page">
  <?php require_once 'components/header.php'; ?>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Minha Conta</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Minha Conta</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="mobile-menu d-lg-none mb-4">
          <button class="mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu">
            <i class="bi bi-grid"></i>
            <span>Menu</span>
          </button>
        </div>

        <div class="row g-4">
          <div class="col-lg-3">
            <div class="profile-menu collapse d-lg-block" id="profileMenu">
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar"></div> <h4><?= htmlspecialchars($usuario['nome'] ?? 'Usuário') ?></h4>
              </div>

              <nav class="menu-nav">
                <ul class="nav flex-column" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#settings">
                      <i class="bi bi-gear"></i>
                      <span>Configurações</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#reviews">
                      <i class="bi bi-star"></i>
                      <span>Meus Reviews</span>
                    </a>
                  </li>
                </ul>
                <div class="menu-footer">
                  <a href="#" class="help-link">
                    <i class="bi bi-question-circle"></i>
                    <span>Help Center</span>
                  </a>
                  <a href="sair.php" class="logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Log Out</span>
                  </a>
                </div>
              </nav>
            </div>
          </div>

          <div class="col-lg-9">
            <div class="content-area">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="settings">
                  <div class="settings-section" data-aos="fade-up">
                    <h3>Informações Pessoais</h3>
                    <form method="POST" action="editarPerfil.php">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label for="nome" class="form-label">Nome</label>
                          <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                          <label for="cpf" class="form-label">CPF</label>
                          <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($usuario['cpf'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                          <label for="telefone" class="form-label">Telefone</label>
                          <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                        </div>
                        </div>
                      <div class="form-buttons mt-3">
                        <button type="submit" name="btnEditar" class="btn btn-primary">Salvar Alterações</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="reviews">
                  <div class="section-header" data-aos="fade-up">
                    <h2>Meus Reviews</h2>
                    <div class="header-actions">
                      <div class="dropdown">
                        <button class="filter-btn" data-bs-toggle="dropdown">
                          <i class="bi bi-funnel"></i>
                          <span>Sort by: Recent</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Recent</a></li>
                          <li><a class="dropdown-item" href="#">Highest Rating</a></li>
                          <li><a class="dropdown-item" href="#">Lowest Rating</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="reviews-grid">
                    <div class="review-card" data-aos="fade-up" data-aos-delay="100">
                      <div class="review-header">
                        <img src="assets/img/product/product-1.webp" alt="Product" class="product-image" loading="lazy">
                        <div class="review-meta">
                          <h4>Lorem ipsum dolor sit amet</h4>
                          <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span>(5.0)</span>
                          </div>
                          <div class="review-date">Reviewed on Feb 15, 2025</div>
                        </div>
                      </div>
                      <div class="review-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                      </div>
                      <div class="review-footer">
                        <button type="button" class="btn-edit">Edit Review</button>
                        <button type="button" class="btn-delete">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php require_once 'components/footer.php'; ?>

  <script>
  $(document).ready(function() {
    // Certifique-se que jQuery e a biblioteca de máscara estão carregados antes deste script.
    if (typeof $.fn.mask === 'function') {
      $('#telefone').mask('(00) 00000-0000');
      $('#cpf').mask('000.000.000-00', {
        reverse: true
      });
    } else {
      console.warn('jQuery Mask não está carregada. As máscaras de input não serão aplicadas.');
    }
  });
  </script>
</body>
</html>