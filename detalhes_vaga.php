<?php
session_start();
include_once 'conexao.php'; // Garanta que $conn seja seu objeto PDO

$id_vaga_get = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$vaga = null;
$feedback_message = null;

if (!$id_vaga_get) {
    // Se não houver ID na URL, define uma mensagem de erro ou redireciona
    $feedback_message = ['type' => 'danger', 'message' => 'ID da vaga inválido ou não fornecido.'];
} else {
    try {
        // Query para buscar os detalhes da vaga, incluindo nome do estado/UF e nome do proprietário
        $sql = "SELECT v.*, 
                       e.nome AS estado_nome, e.uf AS estado_uf, 
                       u.nome AS proprietario_nome
                FROM vagas v
                LEFT JOIN estados e ON v.id_uf = e.id
                LEFT JOIN usuarios u ON v.id_usuario = u.id
                WHERE v.id = :id_vaga";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_vaga', $id_vaga_get, PDO::PARAM_INT);
        $stmt->execute();
        $vaga = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vaga) {
            $feedback_message = ['type' => 'warning', 'message' => 'Vaga não encontrada.'];
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar detalhes da vaga ID $id_vaga_get: " . $e->getMessage());
        $feedback_message = ['type' => 'danger', 'message' => 'Erro ao carregar detalhes da vaga. Tente novamente mais tarde.'];
    }
}

// Define o título da página
$pageTitle = ($vaga ? 'Detalhes: ' . htmlspecialchars($vaga['descricao']) : 'Detalhes da Vaga') . ' – Espaço Livre';
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php require_once 'components/head.php'; // Inclui o <head> da página ?>
<body>
    <?php require_once 'components/header.php'; // Inclui o cabeçalho ?>

    <main class="main">
        <div class="container mt-4 pt-lg-4"> {/* Adicionado padding-top para o header fixo */}
            
            <?php if ($feedback_message): ?>
                <div class="row justify-content-center"><div class="col-md-8">
                    <div class="alert alert-<?= htmlspecialchars($feedback_message['type']) ?>" role="alert">
                        <?= htmlspecialchars($feedback_message['message']) ?>
                        <?php if (!$vaga && $id_vaga_get): ?>
                            <p class="mt-2"><a href="buscaVagas.php" class="btn btn-primary btn-sm">Ver outras vagas</a></p>
                        <?php endif; ?>
                    </div>
                </div></div>
            <?php endif; ?>

            <?php if ($vaga): ?>
                <div class="page-title light-background mb-4">
                    <div class="container">
                        <h1 class="mb-0 display-5"><?= htmlspecialchars($vaga['descricao']) ?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7 mb-4">
                        <?php if (!empty($vaga['foto_vaga'])): ?>
                            <img src="<?= htmlspecialchars($vaga['foto_vaga']) ?>" class="img-fluid rounded shadow-sm" alt="Foto da Vaga: <?= htmlspecialchars($vaga['descricao']) ?>" style="width:100%; max-height: 550px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="height: 300px; width:100%;">
                                <i class="bi bi-image" style="font-size: 3rem;"></i> <span class="ms-2">Sem imagem disponível</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title border-bottom pb-2 mb-3">Informações da Vaga</h3>
                                <p><strong>Proprietário:</strong> <?= htmlspecialchars($vaga['proprietario_nome']) ?></p>
                                
                                <h4 class="mt-3">Localização</h4>
                                <p class="mb-1"><?= htmlspecialchars($vaga['endereco']) ?>, <?= htmlspecialchars($vaga['numero']) ?></p>
                                <?php if (!empty($vaga['complemento'])): ?>
                                    <p class="mb-1"><em>Complemento:</em> <?= htmlspecialchars($vaga['complemento']) ?></p>
                                <?php endif; ?>
                                <p class="mb-1"><em>Bairro:</em> <?= htmlspecialchars($vaga['bairro']) ?></p>
                                <p><em>Cidade/UF:</em> <?= htmlspecialchars($vaga['cidade']) ?> / <?= htmlspecialchars($vaga['estado_uf']) ?> (<?= htmlspecialchars($vaga['estado_nome']) ?>)</p>
                                
                                <h4 class="mt-3">Preço</h4>
                                <p class="fs-3 fw-bold text-success mb-0">R$ <?= number_format($vaga['preco'], 2, ',', '.') ?></p>
                                <p class="text-muted"><small>/ dia</small></p>
                                
                                <hr class="my-4">

                                <?php
                                // Lógica para botões de ação
                                $voltar_para = "buscaVagas.php"; // Destino padrão do botão "Voltar"
                                $texto_voltar = "Ver Outras Vagas";

                                if (isset($_SERVER['HTTP_REFERER'])) {
                                    if (strpos($_SERVER['HTTP_REFERER'], 'account.php#tab-reservas') !== false) {
                                        $voltar_para = "account.php#tab-reservas";
                                        $texto_voltar = "Voltar para Minhas Reservas";
                                    } elseif (strpos($_SERVER['HTTP_REFERER'], 'account.php#tab-vagas') !== false && isset($_SESSION['id']) && $_SESSION['id'] == $vaga['id_usuario']) {
                                         $voltar_para = "account.php#tab-vagas";
                                         $texto_voltar = "Voltar para Minhas Vagas";
                                    }
                                }

                                if (isset($_SESSION['id'])) { // Usuário logado
                                    if ($_SESSION['id'] == $vaga['id_usuario']) { // É o proprietário
                                        echo '<a href="editar_vaga.php?id_vaga=' . $vaga['id'] . '" class="btn btn-primary w-100 mb-2"><i class="bi bi-pencil-square me-2"></i>Editar Minha Vaga</a>';
                                    } else { // Não é o proprietário, pode reservar (se vaga estiver disponível - lógica de disponibilidade não inclusa aqui)
                                        echo '<a href="reservar_vaga.php?id=' . $vaga['id'] . '" class="btn btn-success btn-lg w-100 mb-2"><i class="bi bi-calendar-check me-2"></i>Reservar Esta Vaga</a>';
                                    }
                                } else { // Não logado
                                    echo '<a href="login.php?redirect=detalhes_vaga.php?id=' . $vaga['id'] . '" class="btn btn-success btn-lg w-100 mb-2"><i class="bi bi-box-arrow-in-right me-2"></i>Faça Login para Reservar</a>';
                                }
                                echo '<a href="' . htmlspecialchars($voltar_para) . '" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left-circle me-2"></i>' . $texto_voltar . '</a>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif (!$feedback_message && !$id_vaga_get): // Vaga não especificada e nenhuma outra mensagem ?>
                <div class="alert alert-info text-center">Por favor, especifique uma vaga para ver os detalhes. <a href="buscaVagas.php">Buscar vagas</a>.</div>
            <?php endif; ?>
        </div>
    </main>

    <?php require_once 'components/footer.php'; // Inclui o rodapé ?>
    <?php // Se você tiver um arquivo de scripts comuns, inclua aqui: require_once 'components/scripts.php'; ?>
</body>
</html>