<?php
session_start();
include_once("conexao.php"); // Sua conexão MySQLi ($conexao)

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    $_SESSION['feedback_redirect'] = ['type' => 'warning', 'message' => 'Você precisa estar logado para gerenciar suas reservas.'];
    header("Location: login.php");
    exit();
}
$id_usuario_logado = $_SESSION['id'];

// 2. Obter e validar o ID da Reserva da URL
$id_reserva_param = filter_input(INPUT_GET, 'id_reserva', FILTER_VALIDATE_INT);

if (!$id_reserva_param) {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'ID da reserva inválido ou não fornecido.'];
    header("Location: account.php#tab-reservas"); // Volta para a aba de reservas
    exit();
}

// 3. Verificar se a reserva pertence ao usuário logado e se pode ser cancelada
$reserva_para_cancelar = null;
$sql_check_reserva = "SELECT id_reserva, id_usuario, status FROM reservas WHERE id_reserva = ? AND id_usuario = ?";
$stmt_check = mysqli_prepare($conexao, $sql_check_reserva);

if ($stmt_check) {
    mysqli_stmt_bind_param($stmt_check, "ii", $id_reserva_param, $id_usuario_logado);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    if ($result_check && mysqli_num_rows($result_check) > 0) {
        $reserva_para_cancelar = mysqli_fetch_assoc($result_check);
    }
    mysqli_stmt_close($stmt_check);
}

if (!$reserva_para_cancelar) {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Reserva não encontrada ou você não tem permissão para cancelá-la.'];
    header("Location: account.php#tab-reservas");
    exit();
}

// Verifica se a reserva já não está cancelada ou em outro status não cancelável
if ($reserva_para_cancelar['status'] !== 'r') { // Só permite cancelar se estiver 'r' (Reservado)
    $status_atual_msg = ($reserva_para_cancelar['status'] == 'c') ? 'já está cancelada' : 'não pode mais ser cancelada';
    $_SESSION['feedback_redirect'] = ['type' => 'info', 'message' => "Esta reserva $status_atual_msg."];
    header("Location: account.php#tab-reservas");
    exit();
}

// 4. Atualizar o status da reserva para 'c' (Cancelado)
$novo_status = 'c';
$sql_update_status = "UPDATE reservas SET status = ? WHERE id_reserva = ? AND id_usuario = ?";
$stmt_update = mysqli_prepare($conexao, $sql_update_status);

if ($stmt_update) {
    mysqli_stmt_bind_param($stmt_update, "sii", $novo_status, $id_reserva_param, $id_usuario_logado);
    if (mysqli_stmt_execute($stmt_update)) {
        if (mysqli_stmt_affected_rows($stmt_update) > 0) {
            $_SESSION['feedback_redirect'] = ['type' => 'success', 'message' => 'Reserva #' . $id_reserva_param . ' cancelada com sucesso.'];
            // Opcional: Adicionar lógica aqui para liberar a vaga, notificar proprietário, etc.
        } else {
            $_SESSION['feedback_redirect'] = ['type' => 'warning', 'message' => 'A reserva não pôde ser cancelada ou já estava com o status desejado.'];
        }
    } else {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Erro ao tentar cancelar a reserva no banco de dados.'];
        error_log("Erro MySQL ao cancelar reserva ID $id_reserva_param: " . mysqli_stmt_error($stmt_update));
    }
    mysqli_stmt_close($stmt_update);
} else {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Erro ao preparar a operação de cancelamento.'];
    error_log("Erro MySQL (prepare) ao cancelar reserva: " . mysqli_error($conexao));
}

header("Location: account.php#tab-reservas"); // Sempre redireciona de volta para a aba de reservas
exit();
?>