<<?php
    session_start();
    include_once("conexao.php"); // Garanta que $conexao seja sua conexão MySQLi

    $feedback_messages = [];

    // 1. Verificar se o usuário está logado
    if (!isset($_SESSION['id'])) {
        $_SESSION['feedback_redirect'] = ['type' => 'warning', 'message' => 'Você precisa estar logado para fazer uma reserva.'];
        header("Location: login.php");
        exit();
    }
    $id_usuario_logado = $_SESSION['id'];
    $nome_usuario_logado = $_SESSION['nome'] ?? 'Usuário Logado'; // Supondo que 'nome' está na sessão

    // 2. Obter e validar o ID da Vaga da URL
    $id_vaga_param = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (empty($id_vaga_param)) {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Vaga não especificada ou inválida.'];
        header("Location: buscaVagas.php");
        exit();
    }

    // 3. Buscar Detalhes da Vaga usando Prepared Statement
    $linha_vaga = null;
    // Query ajustada para pegar cidade e bairro diretamente da tabela vagas e id_uf da vaga
    $sql_vaga_details = "SELECT v.id AS vaga_id, v.descricao, v.endereco, v.numero, v.complemento, 
                           v.foto_vaga, v.preco, v.cidade AS vaga_cidade, v.bairro AS vaga_bairro, 
                           v.id_uf AS vaga_id_uf, 
                           e.nome AS estado_nome_vaga, e.uf AS estado_uf_vaga,
                           u.nome AS proprietario_nome
                    FROM vagas v
                    LEFT JOIN estados e ON v.id_uf = e.id
                    LEFT JOIN usuarios u ON v.id_usuario = u.id
                    WHERE v.id = ?";
    $stmt_vaga = mysqli_prepare($conexao, $sql_vaga_details);

    if ($stmt_vaga) {
        mysqli_stmt_bind_param($stmt_vaga, "i", $id_vaga_param);
        mysqli_stmt_execute($stmt_vaga);
        $result_vaga = mysqli_stmt_get_result($stmt_vaga);
        if ($result_vaga && mysqli_num_rows($result_vaga) > 0) {
            $linha_vaga = mysqli_fetch_assoc($result_vaga);
        }
        mysqli_stmt_close($stmt_vaga);
    }

    if (!$linha_vaga) {
        $_SESSION['feedback_redirect'] = ['type' => 'danger', 'message' => 'Vaga não encontrada ou indisponível.'];
        header("Location: buscaVagas.php");
        exit();
    }

    // 4. Processar o Formulário de Reserva
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnReservar'])) {
        $data_reserva_str = trim($_POST['data_reserva'] ?? '');
        $quant_dias_str = trim($_POST['quant_dias'] ?? '');
        $quant_dias = filter_var($quant_dias_str, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        $status_nova_reserva = "r"; // 'r' para Reservado, conforme seu ENUM

        // Validações
        if (empty($data_reserva_str)) {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'A data de início da reserva é obrigatória.'];
        } else {
            try {
                $data_reserva_obj = new DateTime($data_reserva_str);
                $hoje = new DateTime('today');
                if ($data_reserva_obj < $hoje) {
                    $feedback_messages[] = ['type' => 'danger', 'message' => 'A data de início não pode ser no passado.'];
                }
            } catch (Exception $e) {
                $feedback_messages[] = ['type' => 'danger', 'message' => 'Formato de data inválido.'];
            }
        }
        if ($quant_dias === false) {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'A quantidade de dias deve ser um número inteiro igual ou maior que 1.'];
        }

        $erros_presentes_submit = !empty(array_filter($feedback_messages, fn($m) => $m['type'] == 'danger'));

        if (!$erros_presentes_submit) {
            $valor_diaria_vaga = floatval($linha_vaga['preco']);
            $valor_total_calculado = $valor_diaria_vaga * $quant_dias;

            // Coletar dados do endereço da vaga para o "snapshot" na reserva
            $reserva_id_uf = $linha_vaga['vaga_id_uf'];
            $reserva_cidade = $linha_vaga['vaga_cidade'];
            $reserva_bairro = $linha_vaga['vaga_bairro'];
            $reserva_endereco = $linha_vaga['endereco'];
            $reserva_numero = $linha_vaga['numero'];
            $reserva_complemento = $linha_vaga['complemento'] ?? ''; // Complemento pode ser NULL

            // SQL para inserir na tabela 'reservas', incluindo os campos de endereço
            // Colunas: id_usuario, id_vaga, id_uf, cidade, bairro, endereco, numero, complemento, quant_dias, valor_reserva, status, data_reserva
            $sql_insert = "INSERT INTO reservas 
                       (id_usuario, id_vaga, id_uf, cidade, bairro, endereco, numero, complemento, quant_dias, valor_reserva, status, data_reserva) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conexao, $sql_insert);

            if ($stmt_insert) {
                // Tipos para bind_param: i i i s s s s s i d s s  (12 parâmetros)
                mysqli_stmt_bind_param(
                    $stmt_insert,
                    "iiisssssidss",
                    $id_usuario_logado,
                    $linha_vaga['vaga_id'],
                    $reserva_id_uf,
                    $reserva_cidade,
                    $reserva_bairro,
                    $reserva_endereco,
                    $reserva_numero,
                    $reserva_complemento,
                    $quant_dias,
                    $valor_total_calculado,
                    $status_nova_reserva,
                    $data_reserva_str  // A coluna data_reserva na sua tabela tem DEFAULT curdate(), mas aqui estamos passando o valor do form
                );

                if (mysqli_stmt_execute($stmt_insert)) {
                    $_SESSION['feedback_redirect'] = [
                        'type' => 'success',
                        'message' => 'Reserva para "' . htmlspecialchars($linha_vaga['descricao']) . '" realizada! Total: R$ ' . number_format($valor_total_calculado, 2, ',', '.')
                    ];
                    header("Location: buscaVagas.php"); // Ou para "Minhas Reservas"
                    exit();
                } else {
                    $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro ao registrar a reserva (BD Execute): ' . mysqli_error($conexao)];
                    error_log("Erro MySQL (reservas execute): " . mysqli_error($conexao));
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro ao preparar a declaração de reserva (BD Prepare): ' . mysqli_error($conexao)];
                error_log("Erro MySQL (reservas prepare): " . mysqli_error($conexao));
            }
        }
    }

    // Exibir mensagens de feedback da sessão (após um redirecionamento)
    if (isset($_SESSION['feedback_redirect'])) {
        $feedback_messages[] = $_SESSION['feedback_redirect'];
        unset($_SESSION['feedback_redirect']);
    }
    ?>


    <!DOCTYPE html>
    <html lang="pt-br">
    <?php
    $pageTitle = 'Reservar: ' . htmlspecialchars($linha_vaga['descricao'] ?? 'Vaga') . ' – Espaço Livre';
    require_once 'components/head.php';
    ?>

    <body>
        <?php require_once 'components/header.php'; ?>
        <main class="main">
            <section id="hero-minha-conta" class="hero section" style="padding-top: 80px; padding-bottom: 20px;">
                <div class="container" data-aos="fade-up">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-lg-8">
                            <div class="hero-content">
                                <h1 class="mb-2">Confirmar <span class="accent-text">Reserva</span></h1>
                                <p class="lead">Você está prestes a reservar a vaga: <strong><?= htmlspecialchars($linha_vaga['descricao'] ?? 'Não especificada') ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="detalhes-reserva" class="section pt-0">
                <div class="container" data-aos="fade-up" data-aos-delay="100">

                    <?php
                    // Exibir mensagens de feedback acumuladas
                    if (!empty($feedback_messages)) {
                        echo '<div class="row justify-content-center mb-4"><div class="col-md-8 col-lg-7">';
                        foreach ($feedback_messages as $msg) {
                            echo '<div class="alert alert-' . htmlspecialchars($msg['type']) . ' alert-dismissible fade show" role="alert">';
                            echo htmlspecialchars($msg['message']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                        echo '</div></div>';
                    }
                    ?>

                    <?php if ($linha_vaga): // Somente mostra o formulário se a vaga foi carregada 
                    ?>
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <div class="card shadow-sm mb-4">
                                    <?php if (!empty($linha_vaga['foto_vaga'])): ?>
                                        <img src="<?= htmlspecialchars($linha_vaga['foto_vaga']) ?>" class="card-img-top" alt="Foto da Vaga" style="max-height: 350px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h4 class="card-title">Detalhes da Vaga Selecionada</h4>
                                        <p class="card-text mb-1">
                                            <strong>Endereço:</strong>
                                            <?= htmlspecialchars($linha_vaga['endereco'] ?? 'N/A') ?>, <?= htmlspecialchars($linha_vaga['numero'] ?? 'N/A') ?>
                                            <?php if (!empty($linha_vaga['complemento'])): ?>
                                                (<?= htmlspecialchars($linha_vaga['complemento']) ?>)
                                            <?php endif; ?>
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Bairro:</strong> <?= htmlspecialchars($linha_vaga['vaga_bairro'] ?? 'N/A') ?>
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Cidade/UF:</strong> <?= htmlspecialchars($linha_vaga['vaga_cidade'] ?? 'N/A') ?> - <?= htmlspecialchars($linha_vaga['estado_uf_vaga'] ?? 'N/A') ?>
                                        </p>
                                        <p class="card-text mb-0">
                                            <strong>Proprietário:</strong> <?= htmlspecialchars($linha_vaga['proprietario_nome'] ?? 'N/A') ?>
                                        </p>
                                        <hr>
                                        <p class="card-text fw-bold fs-5">
                                            Preço da Diária: R$ <span id="preco_diaria_vaga"><?= number_format($linha_vaga['preco'], 2, ',', '.') ?></span>
                                        </p>
                                    </div>
                                </div>

                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Informe os Detalhes da Reserva</h4>
                                        <p class="text-muted">Reservando como: <strong><?= htmlspecialchars($nome_usuario_logado) ?></strong></p>

                                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?id=<?= htmlspecialchars($id_vaga_param) ?>" class="needs-validation" novalidate>

                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="data_reserva" class="form-label">Data de Início <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control form-control-lg" id="data_reserva" name="data_reserva"
                                                        value="<?= htmlspecialchars($_POST['data_reserva'] ?? date('Y-m-d', strtotime('+1 day'))) ?>"
                                                        min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                                                    <div class="invalid-feedback">Selecione uma data de início válida (a partir de amanhã).</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="quant_dias" class="form-label">Quantidade de Dias <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control form-control-lg" id="quant_dias" name="quant_dias"
                                                        value="<?= htmlspecialchars($_POST['quant_dias'] ?? '1') ?>"
                                                        min="1" step="1" required>
                                                    <div class="invalid-feedback">Informe a quantidade de dias (mínimo 1).</div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <h5 class="fw-bold">Valor Total Estimado: R$ <span id="valor_total_estimado">--,--</span></h5>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-2">
                                                <button type="submit" name="btnReservar" class="btn btn-primary btn-lg">Confirmar e Reservar</button>
                                                <a href="buscaVagas.php" class="btn btn-outline-secondary">Cancelar</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <p class="lead">A vaga solicitada não pôde ser carregada. Por favor, tente novamente ou selecione outra vaga.</p>
                                <a href="buscaVagas.php" class="btn btn-primary">Ver Vagas Disponíveis</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>

        <?php require_once 'components/footer.php'; ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const precoDiariaTextElement = document.getElementById('preco_diaria_vaga');
                const quantDiasInput = document.getElementById('quant_dias');
                const valorTotalElement = document.getElementById('valor_total_estimado');

                function calcularEAtualizarTotal() {
                    if (!precoDiariaTextElement || !quantDiasInput || !valorTotalElement) {
                        // console.log("Elementos não encontrados:", precoDiariaTextElement, quantDiasInput, valorTotalElement);
                        return;
                    }

                    const precoDiariaText = precoDiariaTextElement.textContent.replace(/\./g, '').replace(',', '.');
                    const precoDiaria = parseFloat(precoDiariaText);
                    const quantDias = parseInt(quantDiasInput.value);

                    if (!isNaN(precoDiaria) && !isNaN(quantDias) && quantDias > 0) {
                        const total = precoDiaria * quantDias;
                        valorTotalElement.textContent = total.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else {
                        valorTotalElement.textContent = '--,--';
                    }
                }

                if (quantDiasInput) {
                    quantDiasInput.addEventListener('input', calcularEAtualizarTotal);
                    quantDiasInput.addEventListener('change', calcularEAtualizarTotal);
                }

                // Calcula ao carregar a página se os campos já tiverem valores (ex: após erro de validação)
                if (document.readyState === 'complete' || document.readyState === 'interactive') {
                    calcularEAtualizarTotal();
                } else {
                    document.addEventListener('load', calcularEAtualizarTotal, {
                        once: true
                    });
                }
            });

            // Script de validação Bootstrap (pode já estar no seu footer ou head)
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
        </script>
    </body>

    </html>