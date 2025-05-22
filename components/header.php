<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename">Espaço Livre</h1>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <?php if (isset($_SESSION['id']) && $_SESSION['nivel_acesso'] == 2): ?>
        <li class="nav-item"><a class="nav-link" href="areaRestrita.php">Página Restrita</a></li>
        <?php else: ?>
        <li><a href="login.php"></a></li>
        <?php endif; ?>
      </ul>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <?php if (isset($_SESSION['id']) && isset($_SESSION['nome'])): ?>
          <li><a href="cadastrarVaga.php">Cadastrar Vagas</a></li>
          <li><a href="buscaVagas.php">Reservar Vagas</a></li>
          <li class="dropdown">
            <a href="#" class="bi bi-person" onclick="toggleDropdown(event)">
              <?php echo htmlspecialchars($_SESSION['nome'])?> 
            </a>
            <ul class="dropdown-content">
              <li><a href="dadosPessoaisUsuario.php"><i class="bi bi-person-circle me-2"></i>Meu Perfil</a></li>
              <li><a href="dadosVagaUsuario.php"><i class="bi bi-heart me-2"></i> Minhas Reservas</a></li>
              <li><a href="vagasCadastradas.php"><i class="bi bi-gear me-2"></i> Vagas Cadastradas</a></li>
              <li><a href="sair.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a href="login.php" class="btn btn-primary text-white rounded-pill px-4 py-2 ms-3">Login</a>
          </li>
        <?php endif; ?>
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
  </div>
</header>