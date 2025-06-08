<?php
session_start();
include_once 'conexao.php'; // Sua conexão PDO ($conn)

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
$id_usuario_logado = $_SESSION['id'];

// 2. Verificar se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnAlterarSenha'])) {

    $senha_atual = $_POST['senha_atual'] ?? '';
    $senha_nova = $_POST['senha_nova'] ?? '';
    $senha_nova_confirm = $_POST['senha_nova_confirm'] ?? '';

    // URL para redirecionar em caso de erro
    $redirect_url = "account.php#tab-perfil";

    // 3. Validações
    if (empty($senha_atual) || empty($senha_nova) || empty($senha_nova_confirm)) {
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Todos os campos de senha são obrigatórios.'];
        header("Location: " . $redirect_url);
        exit();
    }
    if (strlen($senha_nova) < 8) {
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'A nova senha deve ter no mínimo 8 caracteres.'];
        header("Location: " . $redirect_url);
        exit();
    }
    if ($senha_nova !== $senha_nova_confirm) {
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'A "Nova Senha" e a "Confirmação" não coincidem.'];
        header("Location: " . $redirect_url);
        exit();
    }

    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 4. Buscar a senha atual (hash) do usuário no banco
        $stmt_check = $conn->prepare("SELECT senha FROM usuarios WHERE id = :id_usuario");
        $stmt_check->bindParam(':id_usuario', $id_usuario_logado, PDO::PARAM_INT);
        $stmt_check->execute();
        $usuario_db = $stmt_check->fetch(PDO::FETCH_ASSOC);

        // 5. Verificar se a "Senha Atual" fornecida está correta
        if (!$usuario_db || !password_verify($senha_atual, $usuario_db['senha'])) {
             $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'A senha atual informada está incorreta.'];
             header("Location: " . $redirect_url);
             exit();
        }
        
        // 6. Criar o hash da nova senha e atualizar no banco
        $novo_hash_senha = password_hash($senha_nova, PASSWORD_DEFAULT);
        
        $stmt_update = $conn->prepare("UPDATE usuarios SET senha = :nova_senha WHERE id = :id_usuario");
        $stmt_update->bindParam(':nova_senha', $novo_hash_senha, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_usuario', $id_usuario_logado, PDO::PARAM_INT);
        $stmt_update->execute();

        // 7. Enviar feedback de sucesso e redirecionar
        $_SESSION['feedback'] = ['type' => 'success', 'message' => 'Senha alterada com sucesso!'];
        header("Location: " . $redirect_url);
        exit();

    } catch (PDOException $e) {
        error_log("Erro ao alterar senha do usuário ID $id_usuario_logado: " . $e->getMessage());
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Ocorreu um erro técnico ao tentar alterar sua senha.'];
        header("Location: " . $redirect_url);
        exit();
    }

} else {
    // Se o script for acessado de forma incorreta, redireciona
    header("Location: account.php");
    exit();
}
?>