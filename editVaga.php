<!DOCTYPE html>

<?php
session_start();
include_once ("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$select_vaga = "SELECT * FROM vagas WHERE vagas.id = '$id'";

$result_vaga = mysqli_query($conexao, $select_vaga);
$linha_vaga = mysqli_fetch_assoc($result_vaga);

$titulo = "upload de foto_vaga";
?>

<html lang="pt-br">
<?php
$pageTitle = 'Cadastrar Nova Vaga – Espaço Livre';
require_once 'components/head.php'; // Seu <head> com CSS, meta tags, etc.
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
                    echo '<div class="row justify-content-center mb-3"><div class="col-md-8">';
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
                            <form method="POST" action="saveEditVaga.php" id="formularioVaga" enctype="multipart/form-data" class="checkout-form needs-validation" novalidate>
                                <div class="checkout-section" id="vaga-info">
                                    <div class="section-header mb-4">
                                        <div class="section-number d-none d-md-flex align-items-center justify-content-center">!</div>
                                        <h3>Informações da Vaga</h3>
                                    </div>
                                    <div class="section-content">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <p style="color: black; font-size: 14px; font-family: 'Times New Roman'">
                                                    Use o campo Descrição para descrever informações que você considera importante compartilha sobre sua vaga,
                                                    isso irá complementar os dados já solicitados neste formulário.<br>
                                                </p>
                                                <label for="descricao" class="form-label">Descrição da Vaga:</label>
                                                <textarea type="text" class="form-control" id="descricao" name="descricao" value="<?php echo htmlspecialchars($linha_vaga['descricao']); ?>" rows="3" required></textarea>
                                                <div class="invalid-feedback">Por favor, insira a descrição da vaga.</div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="cep" class="form-label">CEP:</label>
                                                <input type="text" class="form-control" id="cep" name="cep" value="<?php echo htmlspecialchars($linha_vaga['cep']); ?>" required>
                                                <small></small>
                                                <div class="invalid-feedback">Por favor, insira o CEP.</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="tp_logradouro" class="form-label">Tipo Logradouro <span class="text-danger">*</span></label>
                                                <input type="text" name="tp_logradouro" class="form-control" id="tp_logradouro" value="<?php echo htmlspecialchars($linha_vaga['tp_logradouro']); ?>" placeholder="" required>
                                                <div class="invalid-feedback">Por favor, insira o tipo de logradouro.</div>
                                            </div>
                                            <div class="col-md-7">
                                                <label for="logradouro" class="form-label">Logradouro <span class="text-danger">*</span></label>
                                                <input type="text" name="logradouro" class="form-control" id="logradouro" value="<?php echo htmlspecialchars($linha_vaga['logradouro']); ?>" placeholder="(Rua, Av.)" required>
                                                <div class="invalid-feedback">Por favor, insira o logradouro.</div>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                                                <input type="text" name="numero" class="form-control" id="numero" value="<?php echo htmlspecialchars($linha_vaga['numero']); ?>" required>
                                                <div class="invalid-feedback">Por favor, insira o número.</div>
                                            </div>


                                            <div class="col-md-5">
                                                <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                                                <input type="text" name="bairro" class="form-control" id="bairro" placeholder="" value="<?php echo htmlspecialchars($linha_vaga['bairro']); ?>" required>
                                                <div class="invalid-feedback">Por favor, insira o bairro.</div>
                                            </div>

                                            <div class="col-md-5">
                                                <label for="cidade" class="form-label">Cidade<span class="text-danger">*</span></label>
                                                <input type="text" name="cidade" class="form-control" id="cidade" value="<?php echo htmlspecialchars($linha_vaga['cidade']); ?>" placeholder="" required>
                                                <div class="invalid-feedback">Por favor, insira a cidade.</div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="id_uf" class="form-label">UF:</label><br>
                                                <select name="id_uf" class="form-select" aria-label="Default select example" required>
                                                    <option value="">Selecione o Estado</option>
                                                    <?php
                                                    $query = $conn->query("SELECT * FROM estados ORDER BY nome ASC");
                                                    $registros = $query->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach ($registros as $option) {
                                                        $selected = ($option['id'] == $linha_vaga['id_uf']) ? 'selected' : '';
                                                        echo "<option value=\"{$option['id']}\" {$selected}>{$option['uf']} - {$option['nome']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione o estado.</div>
                                            </div>

                                            <div class="col-9">
                                                <label for="complemento" class="form-label">Complemento</label>
                                                <input type="text" name="complemento" class="form-control" id="complemento" value="<?php echo htmlspecialchars($linha_vaga['complemento']); ?>" placeholder="">
                                                <div class="invalid-feedback">Por favor, insira o complemento.</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="foto_vaga" class="form-label">Selecione a nova imagem (opcional)</label>
                                                <input type="file" name="foto_vaga" accept="assets/image/*" class="form-control" />
                                                <input type="hidden" name="foto_vaga_antiga" value="<?php echo $linha_vaga['foto_vaga']; ?>">
                                                <?php if (!empty($linha_vaga['foto_vaga'])): ?>
                                                    <p>Foto atual: <?php echo basename($linha_vaga['foto_vaga']); ?></p>
                                                    <?php endif; ?>
                                            </div>

                                            <div class="col-md-5">
                                                <label for="preco" class="form-label">Valor da Diária (R$) <span class="text-danger">*</span></label>
                                                <input type="text" name="preco" class="form-control" id="preco" placeholder="Ex: 25,00" value="<?php echo htmlspecialchars($linha_vaga['preco']); ?>" required>
                                                <div class="invalid-feedback">Por favor, insira um valor válido (ex: 25,00).</div>
                                            </div>

                                            <!-- <div class="col-md-6 d-none">
                                                <label for="id_usuario" class="form-label">Usuário:</label><br>
                                                <select name="id_usuario" class="form-select">
                                                    <?php
                                                    // Verifique se o ID do usuário logado está na sessão
                                                    if (isset($_SESSION['id'])) {
                                                        $usuario_logado_id = $_SESSION['id'];

                                                        // Consulte o banco de dados para obter o nome do usuário logado
                                                        $query_logado = $conexao->query("SELECT id, nome FROM usuarios WHERE id = $usuario_logado_id");

                                                        if ($usuario_logado = $query_logado->fetch_assoc()) {
                                                            // Exiba o usuário logado como a opção selecionada
                                                            echo "<option value=\"{$usuario_logado['id']}\" selected>{$usuario_logado['nome']}</option>";
                                                        }
                                                    } else {
                                                        // Caso o ID do usuário não esteja na sessão (o que não deveria acontecer
                                                        // se o usuário estiver logado), você pode exibir uma mensagem ou
                                                        // redirecionar o usuário para a página de login.
                                                        echo "<option value=\"\" disabled>Usuário não identificado</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div> -->

                                            <div class="col-12 mt-4">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <button type="submit" name="btnCadastrar" class="btn btn-primary px-4 btn-lg">Cadastrar Vaga</button>
                                                    <button type="reset" class="btn btn-outline-secondary px-4 btn-lg">Limpar</button>
                                                    <a href="index.php" class="btn btn-outline-danger px-4 btn-lg">Cancelar</a>
                                                </div>
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

    <?php require_once 'components/footer.php'; ?>

    <script>
        // Script de validação do Bootstrap
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
        })()
    </script>
    <script src="assets/js/autocomplete.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cep').mask('00000-000');
            $('#preco').mask('00,00');
            $('#').mask('000.000,00', {
                reverse: true
            });
        });
    </script>
    </script>
</body>
</html>