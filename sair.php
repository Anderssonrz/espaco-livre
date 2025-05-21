<?php
// Inicia a sessão (se já não estiver iniciada)
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se existir um cookie de sessão, apaga-o
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão
session_destroy();

// Redireciona o usuário para a página de login ou outra página desejada
header("Location: index.php"); // Ou sua página de login
exit();
?>