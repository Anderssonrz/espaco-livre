<?php
session_start();
include_once 'conexao.php'; // Garanta que $conn (PDO) seja inicializado aqui

// Exibe feedback da sessão (ex: após atualização do perfil)
if (isset($_SESSION['feedback'])) {
  // Adicionado container para melhor posicionamento e classe de alerta específica
  $feedback_type = htmlspecialchars($_SESSION['feedback']['type']);
  $feedback_message = htmlspecialchars($_SESSION['feedback']['message']);
  // A mensagem será ecoada dentro do <main> para melhor posicionamento
  // unset($_SESSION['feedback']); // Será feito após o echo
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
  $_SESSION['feedback_redirect'] = ['type' => 'warning', 'message' => 'Você precisa estar logado para acessar sua conta.'];
  header("Location: login.php");
  exit();
}

$id_usuario = $_SESSION['id'];
$usuario = null;
$minhas_reservas = [];
$minhas_vagas_cadastradas = [];

try {
  // 1. Buscar dados do perfil do usuário
  $stmt_usuario = $conn->prepare("SELECT id, nome, cpf, telefone, email FROM usuarios WHERE id = ?");
  $stmt_usuario->execute([$id_usuario]);
  $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

  if (!$usuario) {
    session_destroy(); // Usuário da sessão não encontrado no DB
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Erro ao carregar dados do usuário. Faça login novamente.'];
    header("Location: login.php");
    exit();
  }

  // 2. Buscar "Minhas Reservas"
  // (Incluindo descrição da vaga e UF da reserva)
  $stmt_reservas = $conn->prepare(
    "SELECT r.*, v.descricao AS vaga_descricao, v.foto_vaga, e.uf AS reserva_estado_uf
         FROM reservas r
         JOIN vagas v ON r.id_vaga = v.id
         LEFT JOIN estados e ON r.id_uf = e.id -- A reserva tem seu próprio id_uf
         WHERE r.id_usuario = ?
         ORDER BY r.data_reserva DESC, r.id_reserva DESC"
  );
  $stmt_reservas->execute([$id_usuario]);
  $minhas_reservas = $stmt_reservas->fetchAll(PDO::FETCH_ASSOC);

  // 3. Buscar "Minhas Vagas Cadastradas"
  // (Incluindo UF da vaga)
  $stmt_vagas = $conn->prepare(
    "SELECT v.*, e.uf AS estado_uf_vaga
         FROM vagas v
         JOIN estados e ON v.id_uf = e.id
         WHERE v.id_usuario = ?
         ORDER BY v.dataCadastro DESC, v.id DESC"
  );
  $stmt_vagas->execute([$id_usuario]);
  $minhas_vagas_cadastradas = $stmt_vagas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log("Erro na página Minha Conta (usuário ID: $id_usuario): " . $e->getMessage());
  // Definir uma mensagem de erro para ser exibida no HTML
  $erro_fatal_carregamento = "Ocorreu um erro ao carregar os dados da sua conta. Por favor, tente novamente mais tarde.";
  // Não usar die() diretamente se o HTML abaixo ainda precisa ser renderizado para mostrar o erro
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
    <section id="hero-minha-conta" class="hero section" style="padding-top: 80px; padding-bottom: 20px;">
      <div class="container" data-aos="fade-up">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-lg-8">
            <div class="hero-content">
              <h1 class="mb-2">Minha <span class="accent-text">Conta</span></h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <?php
        // Exibir feedback da sessão AQUI, dentro do container principal da seção
        if (isset($feedback_message)) { // Variável definida no bloco PHP do topo
          echo '<div class="row justify-content-center mb-3"><div class="col-md-10 col-lg-9">';
          echo '<div class="alert alert-' . $feedback_type . ' alert-dismissible fade show" role="alert">';
          echo $feedback_message;
          echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
          echo '</div></div></div>';
          if (isset($_SESSION['feedback'])) unset($_SESSION['feedback']); // Limpa após exibir
        }
        // Exibir erro fatal de carregamento, se houver
        if (isset($erro_fatal_carregamento)) {
          echo '<div class="row justify-content-center mb-3"><div class="col-md-10 col-lg-9">';
          echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($erro_fatal_carregamento) . '</div>';
          echo '</div></div>';
        }
        ?>

        <div class="mobile-menu d-lg-none mb-4">
          <button class="mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#profileMenu" aria-expanded="false" aria-controls="profileMenu">
            <i class="bi bi-list"></i>
            <span>Menu da Conta</span>
          </button>
        </div>

        <div class="row g-4">
          <div class="col-lg-3">
            <div class="profile-menu collapse d-lg-block" id="profileMenu">
              <?php if ($usuario): ?>
                <div class="user-info mb-4 text-center text-lg-start" data-aos="fade-right">
                  <div class="user-avatar mx-auto ms-lg-0 mb-2" style="width: 80px; height: 80px; background-color: #e9ecef; border-radius: 50%; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-person-fill" style="font-size: 2.5rem; color: #6c757d;"></i>
                  </div>
                  <h4><?= htmlspecialchars($usuario['nome'] ?? 'Usuário') ?></h4>
                </div>
              <?php endif; ?>

              <nav class="menu-nav">
                <ul class="nav flex-column nav-pills" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="perfil-tab" data-bs-toggle="tab" href="#tab-perfil" role="tab" aria-controls="tab-perfil" aria-selected="true">
                      <i class="bi bi-person-circle me-2"></i>
                      <span>Meu Perfil</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="reservas-tab" data-bs-toggle="tab" href="#tab-reservas" role="tab" aria-controls="tab-reservas" aria-selected="false">
                      <i class="bi bi-calendar2-check me-2"></i>
                      <span>Minhas Reservas</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="vagas-tab" data-bs-toggle="tab" href="#tab-vagas" role="tab" aria-controls="tab-vagas" aria-selected="false">
                      <i class="bi bi-car-front-fill me-2"></i>
                      <span>Minhas Vagas</span>
                    </a>
                  </li>
                </ul>
                <div class="menu-footer mt-4 pt-3 border-top">
                  <a href="sair.php" class="logout-link">
                    <i style="color: red;" class="bi bi-box-arrow-right me-2"></i>
                    <span style="color: red;">Sair</span>
                  </a>
                </div>
              </nav>
            </div>
          </div>

          <div class="col-lg-9">
            <div class="content-area card shadow-sm">
              <div class="card-body">
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="tab-perfil" role="tabpanel" aria-labelledby="perfil-tab">
                    <div class="tab-pane fade show active" id="tab-perfil" role="tabpanel" aria-labelledby="perfil-tab">
                      <h3 class="mb-4">Meu Perfil</h3>

                      <div id="perfil-display-section">
                        <?php if ($usuario): ?>
                          <div class="mb-3">
                            <p><strong>Nome Completo:</strong><br> <?= htmlspecialchars($usuario['nome'] ?? 'Não informado') ?></p>
                            <p><strong>CPF:</strong><br> <span id="display-cpf"><?= htmlspecialchars($usuario['cpf'] ?? 'Não informado') ?></span></p>
                            <p><strong>Telefone:</strong><br> <span id="display-telefone"><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></span></p>
                            <p><strong>Email:</strong><br> <?= htmlspecialchars($usuario['email'] ?? 'Não informado') ?></p>
                          </div>
                          <button type="button" id="btnAbrirFormEditarPerfil" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>Editar Perfil
                          </button>
                        <?php else: ?>
                          <p class="text-danger">Não foi possível carregar os dados do seu perfil.</p>
                        <?php endif; ?>
                      </div>

                      <div id="perfil-edit-form-section" style="display:none;">
                        <h4 class="mb-3">Editar Informações Pessoais</h4>
                        <?php if ($usuario): // Garante que o formulário só apareça se os dados do usuário existirem 
                        ?>
                          <form method="POST" action="editarPerfil.php" class="needs-validation" novalidate id="formEditarPerfilReal">
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label for="edit-nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="edit-nome" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
                                <div class="invalid-feedback">Por favor, informe seu nome.</div>
                              </div>
                              <div class="col-md-6">
                                <label for="edit-cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="edit-cpf" name="cpf" value="<?= htmlspecialchars($usuario['cpf'] ?? '') ?>" required>
                                <div class="invalid-feedback">Por favor, informe um CPF válido.</div>
                              </div>
                              <div class="col-md-6">
                                <label for="edit-telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="edit-telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>">
                              </div>
                              <div class="col-md-6">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                                <div class="invalid-feedback">Por favor, informe um e-mail válido.</div>
                              </div>
                            </div>
                            <div class="form-buttons mt-4">
                              <button type="submit" name="btnEditarPerfil" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>Salvar Alterações
                              </button>
                              <button type="button" id="btnCancelarEdicaoPerfil" class="btn btn-outline-secondary ms-2">
                                Cancelar
                              </button>
                            </div>
                          </form>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-reservas" role="tabpanel" aria-labelledby="reservas-tab">
                    <h3 class="mb-4">Minhas Reservas</h3>
                    <?php if (!empty($minhas_reservas)): ?>
                      <div class="list-group">
                        <?php foreach ($minhas_reservas as $reserva): ?>
                          <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-1 text-primary"><?= htmlspecialchars($reserva['vaga_descricao']) ?></h5>
                              <small class="text-muted">Reserva #<?= htmlspecialchars($reserva['id_reserva']) ?></small>
                            </div>
                            <p class="mb-1">

                              <strong>Status:</strong>
                              <span class="badge bg-<?= $reserva['status'] == 'r' ? 'success' : ($reserva['status'] == 'c' ? 'danger' : 'secondary') ?>">
                                <?php
                                switch ($reserva['status']) {
                                  case 'r':
                                    echo 'Reservado';
                                    break;
                                  case 'l':
                                    echo 'Liberado';
                                    break; // Este status pode não fazer sentido para reservas do usuário
                                  case 'c':
                                    echo 'Cancelado';
                                    break;
                                  default:
                                    echo ucfirst($reserva['status']);
                                }
                                ?>
                              </span>
                            </p>
                            <div class="mt-2">
                              <a href="detalhes_vaga.php?id=<?= $reserva['id_vaga'] ?>" class="btn btn-sm btn-outline-info">Ver Vaga</a>
                              <?php if ($reserva['status'] == 'r'): // Só permite cancelar se estiver 'Reservado' 
                              ?>
                                <a href="cancelar_reserva.php?id_reserva=<?= $reserva['id_reserva'] ?>"
                                  class="btn btn-sm btn-outline-danger ms-2"
                                  onclick="return confirm('Tem certeza que deseja cancelar esta reserva? Esta ação não pode ser desfeita.');">
                                  <i class="bi bi-x-circle me-1"></i>Cancelar Reserva
                                </a>
                              <?php endif; ?>
                              <!-- <a href="editar_reserva.php?id_reserva=<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-outline-primary disabled ms-2" aria-disabled="true">Editar Reserva (Em breve)</a> -->
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <p class="text-muted">Você ainda não possui nenhuma reserva.</p>
                    <?php endif; ?>
                  </div>

                  <div class="tab-pane fade" id="tab-vagas" role="tabpanel" aria-labelledby="vagas-tab">
                    <h3 class="mb-4">Minhas Vagas Cadastradas</h3>
                    <div class="mb-3">
                      <a href="cadastrarVaga.php" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill me-2"></i>Cadastrar Nova Vaga
                      </a>
                    </div>
                    <?php if (!empty($minhas_vagas_cadastradas)): ?>
                      <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($minhas_vagas_cadastradas as $vaga_cadastrada): ?>
                          <div class="col">
                            <div class="card h-100 shadow-sm">
                              <?php if (!empty($vaga_cadastrada['foto_vaga']) && file_exists($vaga_cadastrada['foto_vaga'])): // Adicionada verificação file_exists 
                              ?>
                                <img src="<?= htmlspecialchars($vaga_cadastrada['foto_vaga']) ?>" class="card-img-top" alt="Foto da Vaga: <?= htmlspecialchars($vaga_cadastrada['descricao']) ?>" style="height: 200px; object-fit: cover;">
                              <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center" style="height: 200px; background-color: #f0f0f0; color: #6c757d;">
                                  <i class="bi bi-image fs-1"></i> <span class="ms-2">Sem Imagem</span>
                                </div>
                              <?php endif; ?>
                              <div class="card-body d-flex flex-column">
                                <div>
                                  <h5 class="card-title text-primary"><?= htmlspecialchars($vaga_cadastrada['descricao']) ?></h5>
                                  <p class="card-text small">
                                    <i class="bi bi-geo-alt-fill text-secondary me-1"></i>
                                    <?= htmlspecialchars($vaga_cadastrada['endereco'] . ', ' . $vaga_cadastrada['numero']) ?><br>
                                    <span class="ms-3"><?= htmlspecialchars($vaga_cadastrada['bairro'] . ', ' . $vaga_cadastrada['cidade'] . ' - ' . $vaga_cadastrada['estado_uf_vaga']) ?></span>
                                  </p>
                                  <p class="card-text fw-bold">Diária: R$ <?= htmlspecialchars(number_format($vaga_cadastrada['preco'], 2, ',', '.')) ?></p>
                                  <p class="card-text small mt-2">
                                    <strong>Status:</strong>
                                    <span class="badge bg-<?= ($vaga_cadastrada['status_vaga'] == 'ativa') ? 'success' : 'secondary'; ?>">
                                      <?= ucfirst(htmlspecialchars($vaga_cadastrada['status_vaga'])) ?>
                                    </span>
                                  </p>
                                </div>
                              </div>
                              <div class="card-footer bg-light p-2 mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="editVaga.php?id=<?= $vaga_cadastrada['id'] ?>" class="btn btn-sm btn-outline-primary">
                                      <i class="bi bi-pencil-square me-1"></i>Editar Vaga
                                    </a>
                                    <?php if ($vaga_cadastrada['status_vaga'] == 'ativa'): ?>
                                      <a href="mudar_status_vaga.php?id_vaga=<?= $vaga_cadastrada['id'] ?>&acao=desativar"
                                        class="btn btn-sm btn-outline-warning"
                                        onclick="return confirm('Tem certeza que deseja DESATIVAR esta vaga? Ela não aparecerá mais nas buscas para novas reservas.');">
                                        <i class="bi bi-pause-circle me-1"></i>Desativar Vaga
                                      </a>
                                    <?php else: ?>
                                      <a href="mudar_status_vaga.php?id_vaga=<?= $vaga_cadastrada['id'] ?>&acao=ativar"
                                        class="btn btn-sm btn-outline-success"
                                        onclick="return confirm('Tem certeza que deseja ATIVAR esta vaga? Ela voltará a aparecer nas buscas.');">
                                        <i class="bi bi-play-circle me-1"></i>Ativar Vaga
                                      </a>
                                    <?php endif; ?>
                                    <a href="ver_reservas_vaga.php?id_vaga=<?= $vaga_cadastrada['id'] ?>"
                                      class="btn btn-sm btn-outline-info">
                                      <i class="bi bi-list-check me-1"></i>Ver Reservas
                                    </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <div class="text-center py-5">
                        <i class="bi bi-car-front-fill fs-1 text-muted d-block mb-2"></i>
                        <p class="lead text-muted">Você ainda não cadastrou nenhuma vaga.</p>
                        <p><a href="cadastrarVaga.php" class="btn btn-lg btn-success">
                            <i class="bi bi-plus-circle-fill me-2"></i>Cadastre sua primeira vaga!
                          </a></p>
                      </div>
                    <?php endif; ?>
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
      if (typeof $.fn.mask === 'function') {
        $('#telefone').mask('(00) 00000-0000');
        $('#cpf').mask('000.000.000-00', {
          reverse: true
        });
      } else {
        console.warn('jQuery Mask não está carregada.');
      }

      // Ativar a aba correta se houver um hash na URL (ex: ao voltar de uma edição)
      var hash = window.location.hash;
      if (hash) {
        var tabTrigger = new bootstrap.Tab(document.querySelector('a.nav-link[href="' + hash + '"]'));
        if (tabTrigger._element) { // Verifica se o elemento da aba existe
          tabTrigger.show();
        }
      }

      // Salvar a aba ativa no localStorage e restaurar ao carregar (opcional, para persistência)
      $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        localStorage.setItem('activeAccountTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeAccountTab');
      if (activeTab && !hash) { // Não sobrescreve se já tiver hash
        var tabTrigger = new bootstrap.Tab(document.querySelector('a.nav-link[href="' + activeTab + '"]'));
        if (tabTrigger._element) {
          tabTrigger.show();
        } else { // Se a aba salva não existe mais, remove do localStorage
          localStorage.removeItem('activeAccountTab');
        }
      }
    });

    // Script de validação Bootstrap (se não estiver global)
    (function() {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()

    $(document).ready(function() {
      $('#edit-telefone').mask('(00) 00000-0000');
      $('#edit-cpf').mask('000.000.000-00', {
        reverse: true
      });
    });
  </script>
</body>

</html>