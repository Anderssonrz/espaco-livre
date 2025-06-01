<?php
session_start();
include_once ("conexao.php"); // Espera-se que defina $conexao (mysqli)

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$linha_vaga = null;
$feedback_messages = $_SESSION['feedback_messages'] ?? []; // Pega mensagens da sessão
unset($_SESSION['feedback_messages']); // Limpa após usar

if ($id) {
    // Usar Prepared Statements para segurança
    $stmt_vaga = mysqli_prepare($conexao, "SELECT * FROM vagas WHERE id = ?");
    mysqli_stmt_bind_param($stmt_vaga, "i", $id);
    mysqli_stmt_execute($stmt_vaga);
    $result_vaga = mysqli_stmt_get_result($stmt_vaga);

    if ($result_vaga && mysqli_num_rows($result_vaga) > 0) {
        $linha_vaga = mysqli_fetch_assoc($result_vaga);
    } else {
        // Vaga não encontrada, redirecionar ou mostrar mensagem de erro
        $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Vaga não encontrada.']];
        header("Location: index.php"); // Ou para uma página de listagem
        exit;
    }
    mysqli_stmt_close($stmt_vaga);
} else {
    // ID não fornecido ou inválido
    $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'ID da vaga inválido ou não fornecido.']];
    header("Location: index.php"); // Ou para uma página de listagem
    exit;
}

$pageTitle = 'Editar Vaga – Espaço Livre'; // Título mais apropriado
// A variável $titulo = "upload de foto_vaga"; foi removida por não ser utilizada.
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
    // Assume-se que components/head.php usa $pageTitle para definir o <title>
    // e inclui meta charset, viewport, CSS, etc.
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
                            <h1 class="mb-2">Editar <span class="accent-text">Vaga</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="form-cadastro-vaga" class="checkout section pt-0">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <?php
                if (!empty($feedback_messages)) {
                    echo '<div class="row justify-content-center mb-3"><div class="col-md-10 col-lg-8">';
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
                            <form action="saveEditVaga.php" method="POST" enctype="multipart/form-data" class="checkout-form needs-validation" novalidate>
                                <input type="hidden" name="id_vaga" value="<?php echo htmlspecialchars($linha_vaga['id']); ?>">

                                <div class="checkout-section" id="vaga-info">
                                    <div class="section-header mb-4">
                                        <div class="section-number d-none d-md-flex align-items-center justify-content-center">!</div>
                                        <h3>Informações da Vaga</h3>
                                    </div>
                                    <div class="section-content">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="descricao" class="form-label">Descrição da Vaga <span class="text-danger">*</span></label>
                                                <input type="text" name="descricao" class="form-control" id="descricao" placeholder="Ex: Vaga coberta..." required value="<?php echo htmlspecialchars($linha_vaga['descricao'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira uma descrição para a vaga.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP" maxlength="9" required value="<?php echo htmlspecialchars($linha_vaga['cep'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira um CEP válido.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="id_uf" class="form-label">UF - Unidade Federativa <span class="text-danger">*</span></label><br>
                                                <select name="id_uf" id="id_uf" class="form-select" aria-label="Selecione a UF" required>
                                                    <option value="">Selecione...</option>
                                                    <?php
                                                    // Ajustado para usar mysqli, assumindo que $conexao é mysqli
                                                    $query_estados = "SELECT id, uf, nome FROM estados ORDER BY nome ASC";
                                                    $result_estados = mysqli_query($conexao, $query_estados);
                                                    if ($result_estados) {
                                                        while ($option = mysqli_fetch_assoc($result_estados)) {
                                                            $selected = (isset($linha_vaga['id_uf']) && $option['id'] == $linha_vaga['id_uf']) ? 'selected' : '';
                                                            echo "<option value=\"" . htmlspecialchars($option['id']) . "\" {$selected}>" . htmlspecialchars($option['uf'] . ' - ' . $option['nome']) . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione uma UF.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                                                <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Ex: Joinville" required value="<?php echo htmlspecialchars($linha_vaga['cidade'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira a cidade.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                                                <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Ex: Centro" required value="<?php echo htmlspecialchars($linha_vaga['bairro'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira o bairro.</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="endereco" class="form-label">Endereço (Rua, Av.) <span class="text-danger">*</span></label>
                                                <input type="text" name="endereco" class="form-control" id="endereco" placeholder="Ex: Rua das Palmeiras" required value="<?php echo htmlspecialchars($linha_vaga['endereco'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira o endereço.</div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                                                <input type="text" name="numero" class="form-control" id="numero" placeholder="Ex: 123" required value="<?php echo htmlspecialchars($linha_vaga['numero'] ?? ''); ?>">
                                                <div class="invalid-feedback">Por favor, insira o número.</div>
                                            </div>

                                            <div class="col-md-8">
                                                <label for="complemento" class="form-label">Complemento</label>
                                                <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Ex: Apto 101" value="<?php echo htmlspecialchars($linha_vaga['complemento'] ?? ''); ?>">
                                            </div>

                                            <div class="col-md-7">
                                                <label for="foto_vaga" class="form-label">Selecione a nova imagem (opcional)</label>
                                                <input type="file" name="foto_vaga" accept="image/jpeg, image/png, image/gif, image/webp" class="form-control" id="foto_vaga" />
                                                <input type="hidden" name="foto_vaga_antiga" value="<?php echo htmlspecialchars($linha_vaga['foto_vaga'] ?? ''); ?>">
                                                <?php if (!empty($linha_vaga['foto_vaga'])): ?>
                                                    <p class="mt-2">Foto atual:
                                                        <a href="<?php echo htmlspecialchars($linha_vaga['foto_vaga']); // Idealmente, um caminho acessível pela web ?>" target="_blank">
                                                            <?php echo basename(htmlspecialchars($linha_vaga['foto_vaga'])); ?>
                                                        </a>
                                                    </p>
                                                    <?php endif; ?>
                                                <div class="invalid-feedback">Por favor, selecione uma imagem válida (JPG, PNG, GIF, WEBP).</div>
                                                <small class="form-text text-muted">Max: 5MB.</small>
                                            </div>

                                            <div class="col-md-5">
                                                <label for="preco" class="form-label">Valor da Diária (R$) <span class="text-danger">*</span></label>
                                                <input type="text" name="preco" class="form-control" id="preco" placeholder="Ex: 25,00" required value="<?php echo htmlspecialchars(number_format($linha_vaga['preco'] ?? 0, 2, ',', '.')); ?>">
                                                <div class="invalid-feedback">Por favor, insira um valor válido (ex: 25,00).</div>
                                            </div>

                                            <div class="d-grid gap-3 d-md-flex justify-content-md-end mt-4">
                                                <button type="submit" name="btnSalvarEdicao" class="btn btn-primary px-4 btn-lg"> <i class="bi bi-check-circle-fill me-2"></i>Salvar Alterações
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary px-4 btn-lg">
                                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Limpar
                                                </button>
                                                <a href="account.php#tab-perfil.php#" class="btn btn-outline-danger px-4 btn-lg"> <i class="bi bi-x-circle me-2"></i>Cancelar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'components/footer.php'; // Presume-se que aqui são carregados JS, incluindo jQuery e jQuery Mask ?>
    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        // jQuery Mask (garanta que jQuery e jQuery Mask Plugin estejam carregados antes deste script)
        $(document).ready(function() {
            if (typeof $.fn.mask === 'function') {
                $('#cep').mask('00000-000');
                $('#preco').mask('#.##0,00', {
                    reverse: true,
                    placeholder: "0,00"
                });
                // Se tiver outros campos para mascarar, adicione aqui.
            } else {
                console.warn('jQuery Mask Plugin não está carregado.');
            }

            // Lógica para carregar cidades baseadas na UF, se necessário (exemplo básico)
            // $('#id_uf').change(function() {
            // var estadoId = $(this).val();
            // Se você tiver um endpoint para buscar cidades:
            // $.ajax({
            // url: 'buscar_cidades.php', // Exemplo de endpoint
            // type: 'GET',
            // data: { id_uf: estadoId },
            // dataType: 'json',
            // success: function(data) {
            // var cidadesSelect = $('#id_cidade'); // Supondo que você tenha um select para cidades
            // cidadesSelect.empty();
            // cidadesSelect.append('<option value="">Selecione a cidade...</option>');
            // $.each(data, function(key, value) {
            // cidadesSelect.append('<option value="' + value.id + '">' + value.nome + '</option>');
            // });
            // }
            // });
            // });
        });
    </script>
</body>
</html>