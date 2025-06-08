<?php
session_start();
include_once 'conexao.php'; // Sua conexão PDO ($conn)

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    $_SESSION['feedback_redirect'] = ['type' => 'warning', 'message' => 'Acesso não autorizado. Por favor, faça login.'];
    header("Location: login.php");
    exit();
}
$id_usuario_logado = $_SESSION['id'];

// 2. Obter e validar o ID da Vaga da URL
$id_vaga_get = filter_input(INPUT_GET, 'id_vaga', FILTER_VALIDATE_INT);
$vaga_info = null;
$reservas_desta_vaga = [];
$page_error_message = null;

if (!$id_vaga_get) {
    $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'ID da vaga não fornecido ou inválido.'];
    header("Location: account.php#tab-vagas");
    exit();
}

try {
    // Configura PDO para lançar exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Buscar informações da vaga e VERIFICAR SE PERTENCE AO USUÁRIO LOGADO (Segurança!)
    $stmt_vaga = $conn->prepare("SELECT id, descricao, id_usuario FROM vagas WHERE id = :id_vaga");
    $stmt_vaga->bindParam(':id_vaga', $id_vaga_get, PDO::PARAM_INT);
    $stmt_vaga->execute();
    $vaga_info = $stmt_vaga->fetch(PDO::FETCH_ASSOC);

    // Se a vaga não existe OU o ID do proprietário não é o do usuário logado, nega o acesso.
    if (!$vaga_info || $vaga_info['id_usuario'] != $id_usuario_logado) {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Vaga não encontrada ou você não tem permissão para ver suas reservas.'];
        header("Location: account.php#tab-vagas");
        exit();
    }

    // 4. Se a propriedade foi confirmada, buscar todas as reservas para esta vaga
    $stmt_reservas = $conn->prepare(
        "SELECT r.*, u.nome AS nome_cliente, u.email AS email_cliente, u.telefone AS telefone_cliente
         FROM reservas r
         JOIN usuarios u ON r.id_usuario = u.id
         WHERE r.id_vaga = :id_vaga
         ORDER BY r.data_reserva DESC, r.id_reserva DESC"
    );
    $stmt_reservas->bindParam(':id_vaga', $id_vaga_get, PDO::PARAM_INT);
    $stmt_reservas->execute();
    $reservas_desta_vaga = $stmt_reservas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro em ver_reservas_vaga.php (Vaga ID: $id_vaga_get): " . $e->getMessage());
    $page_error_message = "Ocorreu um erro técnico ao carregar os dados das reservas.";
}

$pageTitle = 'Reservas para: ' . ($vaga_info ? htmlspecialchars($vaga_info['descricao']) : 'Vaga');
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
                            <nav aria-label="breadcrumb"><br><br><br>
                                <ol class="breadcrumb mb-1 bg-transparent p-0">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="account.php#tab-vagas">Minhas Vagas</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Histórico de Reservas</li>
                                </ol>
                            </nav>
                            <h2>Reservas para a Vaga:</h2>
                            <h3 class="text-primary"><?= htmlspecialchars($vaga_info['descricao'] ?? 'Inválida') ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>


                <div class="container">
                    <?php if ($page_error_message): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($page_error_message) ?></div>
                    <?php endif; ?>

                    <?php if ($vaga_info && empty($reservas_desta_vaga) && !$page_error_message): ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                            Nenhuma reserva encontrada para esta vaga até o momento.
                        </div>
                    <?php elseif (!empty($reservas_desta_vaga)): ?>
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Reserva #</th>
                                        <th>Cliente</th>
                                        <th>Contato</th>
                                        <th>Período da Reserva</th>
                                        <th>Valor Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservas_desta_vaga as $reserva): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                                            <td><?= htmlspecialchars($reserva['nome_cliente']) ?></td>
                                            <td>
                                                <small>
                                                    <?php if (!empty($reserva['email_cliente'])): ?>
                                                        <i class="bi bi-envelope-fill" title="Email"></i> <?= htmlspecialchars($reserva['email_cliente']) ?><br>
                                                    <?php endif; ?>
                                                    <?php if (!empty($reserva['telefone_cliente'])): ?>
                                                        <i class="bi bi-telephone-fill" title="Telefone"></i> <?= htmlspecialchars($reserva['telefone_cliente']) ?>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php
                                                $data_inicio_r = new DateTime($reserva['data_reserva']);
                                                $data_fim_r = new DateTime($reserva['data_reserva']);
                                                $data_fim_r->add(new DateInterval('P' . ($reserva['quant_dias'] - 1) . 'D'));
                                                ?>
                                                <?= $data_inicio_r->format('d/m/Y') ?> até <?= $data_fim_r->format('d/m/Y') ?>
                                                <span class="text-muted">(<?= htmlspecialchars($reserva['quant_dias']) ?> dia(s))</span>
                                            </td>
                                            <td class="text-end fw-bold">R$ <?= htmlspecialchars(number_format($reserva['valor_reserva'], 2, ',', '.')) ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-<?= $reserva['status'] == 'r' ? 'success' : ($reserva['status'] == 'c' ? 'danger' : 'secondary') ?>">
                                                    <?php
                                                    switch ($reserva['status']) {
                                                        case 'r':
                                                            echo 'Reservado';
                                                            break;
                                                        case 'l':
                                                            echo 'Liberado';
                                                            break;
                                                        case 'c':
                                                            echo 'Cancelado';
                                                            break;
                                                        default:
                                                            echo ucfirst($reserva['status']);
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="mt-4">
                        <a href="account.php#tab-vagas" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar para Minhas Vagas</a>
                    </div>
                </div>
        </main>
        <?php require_once 'components/footer.php'; ?>
</body>

</html>