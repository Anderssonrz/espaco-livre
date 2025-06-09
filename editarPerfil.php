<?php
session_start();
include_once 'conexao.php'; // Espera-se que $conn seja um objeto PDO vindo daqui

// Garante que o PDO esteja configurado para lançar exceções (MUITO IMPORTANTE PARA DEBUG)
if (isset($conn) && $conn instanceof PDO) {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} else {
    // Isso não deve acontecer se conexao.php estiver correto
    error_log("editarPerfil.php: Falha crítica - \$conn não é um objeto PDO ou não definido.");
    $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Erro crítico de conexão com o banco de dados. Contacte o administrador.'];
    // Tenta redirecionar para account.php, mas se a conexão falhar lá também, pode ser um problema.
    header("Location: account.php" . (isset($_POST['id']) ? '#tab-perfil' : ''));
    exit();
}

// 1. Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    $_SESSION['feedback'] = ['type' => 'warning', 'message' => 'Você precisa estar logado para editar o perfil.'];
    header("Location: login.php");
    exit();
}
$id_usuario = $_SESSION['id']; // ID do usuário logado

// 2. Verificar se o formulário foi enviado (método POST e botão específico)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditarPerfil'])) {

    $nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_UNSAFE_RAW);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($email) {
        $email_validado = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email_validado) {
            $_SESSION['msg'] = "<p style='color:red;'>Email inválido!</p>";
            header("Location: editaUsuario.php?id=" . $id);
            exit();
        }
    }
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);


    // Consulta para obter a senha atual do banco de dados
    $sql_senha_atual = "SELECT senha FROM usuarios WHERE id = ?";
    $stmt_senha_atual = mysqli_prepare($conexao, $sql_senha_atual);
    mysqli_stmt_bind_param($stmt_senha_atual, "i", $id);
    mysqli_stmt_execute($stmt_senha_atual);
    $result_senha_atual = mysqli_stmt_get_result($stmt_senha_atual);
    $row_senha_atual = mysqli_fetch_assoc($result_senha_atual);
    $senha_banco = $row_senha_atual['senha'];
    mysqli_stmt_close($stmt_senha_atual);

    $data_cadastro = filter_input(INPUT_POST, 'dataCadastro');

    $atualizacao_sucesso = false; // Variável para rastrear o sucesso da atualização

    $update_usuarios_sql = "UPDATE usuarios SET nome=?, cpf=?, telefone=?, email=?, dataCadastro=? WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $update_usuarios_sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nome, $cpf, $telefone, $email, $data_cadastro, $id);

    if (mysqli_stmt_execute($stmt)) {
        $atualizacao_sucesso = true;
    } else {
        error_log("\n Erro ao editar usuário (dados básicos): " . mysqli_error($conexao), 3, "error.log");
    }
    mysqli_stmt_close($stmt);

    // Atualizar a senha apenas se um novo valor foi fornecido
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $update_senha_sql = "UPDATE usuarios SET senha=? WHERE id = ?";
        $stmt_senha = mysqli_prepare($conexao, $update_senha_sql);
        mysqli_stmt_bind_param($stmt_senha, "si", $senha_hash, $id);
        if (mysqli_stmt_execute($stmt_senha)) {
            $atualizacao_sucesso = true;
        } else {
            error_log("\n Erro ao editar usuário (senha): " . mysqli_error($conexao), 3, "error.log");
        }
        mysqli_stmt_close($stmt_senha);
    }


    // 4. Validação básica dos dados
    $erros_validacao = [];
    if (empty($nome)) {
        $erros_validacao[] = "O campo Nome Completo é obrigatório.";
    }
    if (empty($cpf)) {
        $erros_validacao[] = "O campo CPF é obrigatório.";
    }
    // Adicionar aqui mais validações se necessário (ex: formato de CPF, telefone)
    if (empty($email)) {
        $erros_validacao[] = "O campo Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros_validacao[] = "O formato do Email é inválido.";
    }

    if (!empty($erros_validacao)) {
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => implode("<br>", $erros_validacao)];
        // Para repopular o formulário em account.php, os valores já vêm de $usuario.
        // Se a validação falhar, o usuário verá os dados antigos, o que é aceitável ou
        // você pode armazenar $_POST em $_SESSION['form_data_temp'] e usar em account.php para repopular.
        header("Location: account.php#tab-perfil");
        exit();
    }

    // 5. Tentar atualizar o banco de dados
    try {
        // Verifique se os nomes das colunas (nome, cpf, telefone, email, id) estão corretos!
        $sql = "UPDATE usuarios SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email, senha=:senha WHERE id = :id_usuario";
        $stmt = $conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR); // Se telefone pode ser NULL no BD, ajuste ou trate valor vazio
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['feedback'] = ['type' => 'success', 'message' => 'Seu perfil foi atualizado com sucesso!'];
            // Como o nome do usuário pode ter mudado, atualize na sessão se você o usar no header, por exemplo.
            $_SESSION['nome'] = $nome; // Supondo que você armazena o nome do usuário na sessão
        } else {
            // Query executou, mas nenhuma linha foi alterada (provavelmente os dados eram os mesmos).
            $_SESSION['feedback'] = ['type' => 'info', 'message' => 'Nenhuma alteração foi detectada em seu perfil.'];
        }
        header("Location: account.php#tab-perfil"); // Redireciona de volta para a aba de perfil
        exit();

    } catch (PDOException $e) {
        error_log("Erro ao atualizar perfil do usuário ID $id_usuario: " . $e->getMessage() . " | SQL: $sql");
        // Em produção, não mostre $e->getMessage() diretamente ao usuário.
        $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Ocorreu um erro técnico ao tentar atualizar seu perfil. Por favor, tente novamente.'];
        // Para depuração, você pode querer ver o erro:
        // $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Erro DB: ' . $e->getMessage()];
        header("Location: account.php#tab-perfil");
        exit();
    }

} else {
    // Se não for um POST vindo do botão correto, redireciona.
    $_SESSION['feedback'] = ['type' => 'warning', 'message' => 'Acesso inválido para esta operação.'];
    header("Location: account.php"); // Redireciona para a página principal da conta
    exit();
}
?>