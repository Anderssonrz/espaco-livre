<?php
session_start();
include_once 'conexao.php'; // Garanta que $conn seja seu objeto PDO

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Acesso não autorizado. Por favor, faça login.'];
    header("Location: login.php");
    exit();
}
$id_usuario_logado = $_SESSION['id'];

// 2. Obter e validar parâmetros da URL
$id_vaga = filter_input(INPUT_GET, 'id_vaga', FILTER_VALIDATE_INT);
$acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_SPECIAL_CHARS);

// Valida se os parâmetros são válidos
if (!$id_vaga || !in_array($acao, ['ativar', 'desativar'])) {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Ação ou ID da vaga inválido.'];
    header("Location: account.php#tab-vagas"); // Volta para a aba de vagas
    exit();
}

try {
    // Configura PDO para lançar exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. VERIFICAÇÃO DE SEGURANÇA: Garantir que a vaga pertence ao usuário logado
    $stmt_check = $conn->prepare("SELECT id_usuario FROM vagas WHERE id = :id_vaga");
    $stmt_check->bindParam(':id_vaga', $id_vaga, PDO::PARAM_INT);
    $stmt_check->execute();
    $vaga_owner = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$vaga_owner || $vaga_owner['id_usuario'] != $id_usuario_logado) {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Você não tem permissão para alterar esta vaga.'];
        header("Location: account.php#tab-vagas");
        exit();
    }

    // 4. Executar a atualização no banco
    $novo_status = ($acao == 'ativar') ? 'ativa' : 'inativa';

    $stmt_update = $conn->prepare("UPDATE vagas SET status_vaga = :status_vaga WHERE id = :id_vaga AND id_usuario = :id_usuario");
    $stmt_update->bindParam(':status_vaga', $novo_status, PDO::PARAM_STR);
    $stmt_update->bindParam(':id_vaga', $id_vaga, PDO::PARAM_INT);
    $stmt_update->bindParam(':id_usuario', $id_usuario_logado, PDO::PARAM_INT); // Segurança extra
    
    if ($stmt_update->execute()) {
        if ($stmt_update->rowCount() > 0) {
            $_SESSION['feedback_redirect'] = ['type' => 'success', 'message' => 'Status da vaga #' . $id_vaga . ' atualizado para "' . ucfirst($novo_status) . '".'];
        } else {
            $_SESSION['feedback_redirect'] = ['type' => 'info', 'message' => 'Nenhuma alteração foi necessária no status da vaga.'];
        }
    } else {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Erro ao executar a atualização do status da vaga.'];
    }

} catch (PDOException $e) {
    // Em caso de erro de banco, logar o erro e mostrar uma mensagem amigável
    error_log("Erro ao mudar status da vaga (ID: $id_vaga): " . $e->getMessage());
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Ocorreu um erro técnico. Por favor, tente novamente.'];
}

// 5. Redirecionar de volta para a página da conta, na aba correta
header("Location: account.php#tab-vagas");
exit();
?>