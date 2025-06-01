<?php
//------------------------------------------------------------------------------------------
require_once("conexao.php"); // Assume que $conexao (MySQLi) é definido aqui
session_start();

$feedback_messages = []; // Array para armazenar mensagens de feedback

// Processa o formulário se foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnCadastrar'])) {
    // Coleta de dados (com sanitização básica e trim)
    $descricao = trim($_POST['descricao'] ?? '');
    $cep_form = trim($_POST['cep'] ?? ''); // Pega o CEP do formulário
    $cidade = trim($_POST['cidade'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $complemento = trim($_POST['complemento'] ?? '');
    $preco_str = trim($_POST['preco'] ?? '');
    $id_uf = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);

    // Validações básicas do servidor
    if (empty($descricao)) $feedback_messages[] = ['type' => 'danger', 'message' => 'A descrição da vaga é obrigatória.'];
    if (empty($cep_form)) $feedback_messages[] = ['type' => 'danger', 'message' => 'O CEP é obrigatório.'];
    if (empty($id_uf)) $feedback_messages[] = ['type' => 'danger', 'message' => 'O estado é obrigatório.'];
    if (empty($cidade)) $feedback_messages[] = ['type' => 'danger', 'message' => 'A cidade é obrigatória.'];
    if (empty($bairro)) $feedback_messages[] = ['type' => 'danger', 'message' => 'O bairro é obrigatório.'];
    if (empty($endereco)) $feedback_messages[] = ['type' => 'danger', 'message' => 'O endereço é obrigatório.'];
    if (empty($numero)) $feedback_messages[] = ['type' => 'danger', 'message' => 'O número é obrigatório.'];

    $preco = 0; // Inicializa o preço
    if (empty($preco_str)) {
        $feedback_messages[] = ['type' => 'danger', 'message' => 'O valor da diária é obrigatório.'];
    } else {
        $preco_temp = str_replace('.', '', $preco_str);
        $preco_temp = str_replace(',', '.', $preco_temp);
        if (!is_numeric($preco_temp) || $preco_temp < 0) {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'O valor da diária é inválido.'];
        } else {
            $preco = floatval($preco_temp); // Converte para float
        }
    }

    if (!isset($_SESSION['id'])) {
        $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro: Você precisa estar logado para cadastrar uma vaga.'];
    }
    $id_usuario_seguro = $_SESSION['id'] ?? null;

    $foto_vaga_db_path = "";
    $erros_criticos_antes_upload = !empty(array_filter($feedback_messages, fn($msg) => $msg['type'] == 'danger'));

    if (!$erros_criticos_antes_upload) {
        if (isset($_FILES["foto_vaga"]) && $_FILES["foto_vaga"]["error"] == UPLOAD_ERR_OK) {
            $pasta_destino = "assets/img/vagas/";
            if (!is_dir($pasta_destino)) {
                if (!mkdir($pasta_destino, 0775, true)) {
                    $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro crítico: Não foi possível criar a pasta de destino para fotos.'];
                }
            }

            if (is_writable($pasta_destino)) {
                $nome_arquivo_original = basename($_FILES["foto_vaga"]["name"]);
                $extensao = strtolower(pathinfo($nome_arquivo_original, PATHINFO_EXTENSION));
                $nome_arquivo_unico = uniqid('vaga_', true) . "." . $extensao;
                $caminho_completo = $pasta_destino . $nome_arquivo_unico;
                $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $tamanho_maximo_bytes = 5 * 1024 * 1024; // 5MB

                if (in_array($extensao, $permitidos)) {
                    if ($_FILES["foto_vaga"]["size"] <= $tamanho_maximo_bytes) {
                        if (move_uploaded_file($_FILES["foto_vaga"]["tmp_name"], $caminho_completo)) {
                            $foto_vaga_db_path = $caminho_completo;
                        } else {
                            $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro ao salvar a foto da vaga. Código: ' . $_FILES["foto_vaga"]["error"]];
                        }
                    } else {
                        $feedback_messages[] = ['type' => 'danger', 'message' => 'A foto é muito grande (limite de 5MB).'];
                    }
                } else {
                    $feedback_messages[] = ['type' => 'danger', 'message' => 'Tipo de arquivo da foto não permitido.'];
                }
            } else {
                $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro crítico: A pasta de destino para fotos não tem permissão de escrita.'];
            }
        } elseif (!isset($_FILES["foto_vaga"]) || $_FILES["foto_vaga"]["error"] == UPLOAD_ERR_NO_FILE) {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'A imagem da vaga é obrigatória.'];
        } elseif ($_FILES["foto_vaga"]["error"] != UPLOAD_ERR_OK) {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'Ocorreu um erro no upload da foto. Código: ' . $_FILES["foto_vaga"]["error"]];
        }
    }

    $erros_presentes = false;
    foreach ($feedback_messages as $msg) {
        if ($msg['type'] === 'danger') {
            $erros_presentes = true;
            break;
        }
    }

    if (!$erros_presentes && $id_usuario_seguro !== null) { // Adicionada verificação para $id_usuario_seguro
        $sql = "INSERT INTO vagas (descricao, cidade, bairro, endereco, numero, complemento, foto_vaga, preco, id_usuario, id_uf)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssdii", $descricao, $cidade, $bairro, $endereco, $numero, $complemento, $foto_vaga_db_path, $preco, $id_usuario_seguro, $id_uf);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['feedback_redirect'] = ['type' => 'success', 'message' => 'Vaga cadastrada com sucesso!'];
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            $feedback_messages[] = ['type' => 'danger', 'message' => 'Erro ao cadastrar a vaga: ' . mysqli_error($conexao)];
            error_log("Erro MySQL ao inserir vaga (usuário: {$id_usuario_seguro}): " . mysqli_error($conexao));
        }
        mysqli_stmt_close($stmt);
    }
}

if (isset($_SESSION['feedback_redirect'])) {
    $feedback_messages[] = $_SESSION['feedback_redirect'];
    unset($_SESSION['feedback_redirect']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
$pageTitle = 'Cadastrar Nova Vaga – Espaço Livre';
require_once 'components/head.php';
?>

<body>
    <?php require_once 'components/header.php'; ?>

    <main class="main">
        <section id="hero-cadastro-vaga" class="hero section" style="padding-top: 80px; padding-bottom: 20px;">
            <div class="container" data-aos="fade-up">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <h1 class="mb-2">Cadastrar <span class="accent-text">Nova Vaga</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="form-cadastro-vaga" class="checkout section pt-0">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <?php
                if (!empty($feedback_messages)) {
                    echo '<div class="row justify-content-center mb-3"><div class="col-md-10 col-lg-8">'; // Ajustado para consistência
                    foreach ($feedback_messages as $msg) {
                        echo '<div class="alert alert-' . htmlspecialchars($msg['type']) . ' alert-dismissible fade show" role="alert">';
                        echo htmlspecialchars($msg['message']);
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }
                    echo '</div></div>';
                }
                ?>

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="checkout-container">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="checkout-form needs-validation" novalidate>
                                <div class="checkout-section" id="vaga-info">
                                    <div class="section-header mb-4">
                                        <div class="section-number d-none d-md-flex align-items-center justify-content-center">!</div>
                                        <h3>Informações da Vaga</h3>
                                    </div>
                                    <div class="section-content">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="descricao" class="form-label">Descrição da Vaga <span class="text-danger">*</span></label>
                                                <input type="text" name="descricao" class="form-control" id="descricao" placeholder="Ex: Vaga coberta..." required value="<?= htmlspecialchars($_POST['descricao'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira uma descrição para a vaga.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP" maxlength="9" required value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira um CEP válido.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="id_uf" class="form-label">Estado <span class="text-danger">*</span></label>
                                                <select name="id_uf" id="id_uf" class="form-select" required>
                                                    <option value="">Selecione o Estado</option>
                                                    <?php
                                                    $query_estados = $conexao->query("SELECT id, nome, uf FROM estados ORDER BY nome ASC");
                                                    while ($option_estado = $query_estados->fetch_assoc()) {
                                                        $selected = (isset($_POST['id_uf']) && $_POST['id_uf'] == $option_estado['id']) ? 'selected' : '';
                                                        echo "<option value=\"{$option_estado['id']}\" data-uf=\"{$option_estado['uf']}\" $selected>{$option_estado['uf']} - {$option_estado['nome']}</option>"; // Adicionado data-uf
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione um estado.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                                <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Ex: Joinville" required value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira a cidade.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                                                <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Ex: Centro" required value="<?= htmlspecialchars($_POST['bairro'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira o bairro.</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="endereco" class="form-label">Endereço (Rua, Av.) <span class="text-danger">*</span></label>
                                                <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Ex: Rua das Palmeiras" required value="<?= htmlspecialchars($_POST['endereco'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira o endereço.</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                                                <input type="text" name="numero" class="form-control" id="numero" placeholder="Ex: 123" required value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira o número.</div>
                                            </div>

                                            <div class="col-md-8">
                                                <label for="complemento" class="form-label">Complemento</label>
                                                <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Ex: Apto 101" value="<?= htmlspecialchars($_POST['complemento'] ?? '') ?>">
                                            </div>

                                            <div class="col-md-7">
                                                <label for="foto_vaga" class="form-label">Imagem da Vaga <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="foto_vaga" id="foto_vaga" accept="image/jpeg, image/png, image/gif, image/webp" required>
                                                <div class="invalid-feedback">Por favor, selecione uma imagem (JPG, PNG, GIF, WEBP).</div>
                                                <small class="form-text text-muted">Max: 5MB.</small>
                                            </div>

                                            <div class="col-md-5">
                                                <label for="preco" class="form-label">Valor da Diária (R$) <span class="text-danger">*</span></label>
                                                <input type="text" name="preco" class="form-control" id="preco" placeholder="Ex: 25,00" required value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>">
                                                <div class="invalid-feedback">Por favor, insira um valor válido (ex: 25,00).</div>
                                            </div>

                                            <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                                                <button type="submit" name="btnCadastrar" class="btn btn-primary px-4 btn-lg">
                                                    <i class="bi bi-check-circle-fill me-2"></i>Cadastrar Vaga
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary px-4 btn-lg">
                                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Limpar
                                                </button>
                                                <a href="index.php" class="btn btn-outline-secondary px-4 btn-lg">
                                                    <i class="bi bi-x-circle me-2"></i>Cancelar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <?php require_once 'components/footer.php'; ?>
    <script>
        // jQuery Mask (garanta que jQuery e jQuery Mask Plugin estejam carregados)
        $(document).ready(function() {
            if (typeof $.fn.mask === 'function') {
                $('#cep').mask('00000-000');
                $('#preco').mask('#.##0,00', {
                    reverse: true,
                    placeholder: "0,00"
                });
                // Se tiver outros campos para mascarar, adicione aqui. Ex:
                // $('#telefone_contato').mask('(00) 00000-0000');
            } else {
                console.warn('jQuery Mask Plugin não está carregado.');
            }
        });
    </script>
</body>

</html>