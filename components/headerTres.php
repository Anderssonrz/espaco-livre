<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="buscaVagas.php" class="logo d-flex align-items-center me-auto me-xl-0">
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
      
     
          
            
            <ul class="dropdown-content">
              <li><a href="listaUsuarios.php">Usuários cadastrados</a></li>
              <li><a href="listaVagas.php">Vagas cadastradas</a></li>
              <li><a href="listaReservas.php">Reservas</a></li>
              <li><a href="sair.php">Sair</a></li>
            </ul>
          
        
     

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
  </div>
</header>