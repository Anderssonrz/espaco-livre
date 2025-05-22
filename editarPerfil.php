<?php
session_start();
include_once("conexao.php"); // Seu arquivo de conexão (espera-se que $conexao seja uma conexão MySQLi válida)

// --- Configurações ---
define('SENHA_COMPRIMENTO_MINIMO', 8); // Define o comprimento mínimo para novas senhas

// --- Verificações Iniciais ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se não for uma requisição POST, redireciona ou encerra.
    // Poderia redirecionar para uma página de erro ou lista de usuários.
    $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'Acesso inválido.'];
    header("Location: listaUsuarios.php"); // Ajuste o redirecionamento conforme necessário
    exit();
}

// --- Coleta e Validação do ID do Usuário ---
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
if (empty($id)) {
    $_SESSION['feedback'] = ['type' => 'danger', 'message' => 'ID do usuário inválido ou não fornecido.'];
    header("Location: listaUsuarios.php"); // Página de listagem de usuários ou similar
    exit();
}

// --- Coleta e Sanitização dos Dados do Formulário ---
// Usar trim para remover espaços em branco extras. FILTER_UNSAFE_RAW não sanitiza para XSS.
// A proteção XSS deve ser feita na exibição dos dados (htmlspecialchars).
$nome = trim(filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW) ?? '');
$cpf = trim(filter_input(INPUT_POST, 'cpf', FILTER_UNSAFE_RAW) ?? '');
$telefone = trim(filter_input(INPUT_POST, 'telefone', FILTER_UNSAFE_RAW) ?? '');
$email_input = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');

// Senhas (só serão processadas se preenchidas)
$senha_nova = $_POST['senha'] ?? ''; // Não use filter_input para senhas, pois pode remover caracteres válidos
$senha_confirm = $_POST['senha_confirm'] ?? '';

// --- Validação dos Dados ---
$erros_validacao = [];

if (empty($nome)) {
    $erros_validacao[] = "O campo Nome é obrigatório.";
}
if (empty($cpf)) {
    $erros_validacao[] = "O campo CPF é obrigatório.";
}
// O campo telefone pode ser opcional, se não for, adicione:
// if (empty($telefone)) {
// $erros_validacao[] = "O campo Telefone é obrigatório.";
// }
if (empty($email_input)) {
    $erros_validacao[] = "O campo Email é obrigatório.";
} elseif (!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
    $erros_validacao[] = "O formato do Email é inválido.";
}

// Validação da senha (somente se uma nova senha for fornecida)
if (!empty($senha_nova)) {
    if (strlen($senha_nova) < SENHA_COMPRIMENTO_MINIMO) {
        $erros_validacao[] = "A nova senha deve ter pelo menos " . SENHA_COMPRIMENTO_MINIMO . " caracteres.";
    }
    if ($senha_nova !== $senha_confirm) {
        $erros_validacao[] = "A nova senha e a confirmação de senha não coincidem.";
    }
}

// Se houver erros de validação, redireciona de volta ao formulário de edição
if (!empty($erros_validacao)) {
    $_SESSION['feedback'] = ['type' => 'danger', 'message' => implode("<br>", $erros_validacao)];
    // Para repopular o formulário, você pode armazenar os inputs em $_SESSION temporariamente
    // ou redirecionar com os erros como parâmetros GET, se preferir.
    header("Location: editaUsuario.php?id=" . $id); // Página do formulário de edição
    exit();
}

// --- Atualização dos Dados no Banco ---
$atualizacao_sucesso_dados = false;
$atualizacao_sucesso_senha = true; // Assume sucesso se a senha não for alterada

// 1. Atualizar dados básicos do usuário (exceto senha)
$update_usuarios_sql = "UPDATE usuarios SET nome=?, cpf=?, telefone=?, email=? WHERE id = ?";
$stmt_dados = mysqli_prepare($conexao, $update_usuarios_sql);

if ($stmt_dados) {
    mysqli_stmt_bind_param($stmt_dados, "ssssi", $nome, $cpf, $telefone, $email_input, $id);
    if (mysqli_stmt_execute($stmt_dados)) {
        $atualizacao_sucesso_dados = true;
    } else {
        error_log("Erro ao atualizar dados básicos do usuário ID $id: " . mysqli_stmt_error($stmt_dados), 3, "error.log");
    }
    mysqli_stmt_close($stmt_dados);
} else {
    error_log("Erro ao preparar statement para dados básicos do usuário ID $id: " . mysqli_error($conexao), 3, "error.log");
}

// 2. Atualizar a senha apenas se uma nova senha válida foi fornecida e os dados básicos foram atualizados com sucesso (ou se a atualização dos dados não era o objetivo principal)
if ($atualizacao_sucesso_dados && !empty($senha_nova)) { // Garante que a senha só seja atualizada se os dados básicos foram OK (opcional)
    $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);
    $update_senha_sql = "UPDATE usuarios SET senha=? WHERE id = ?";
    $stmt_senha = mysqli_prepare($conexao, $update_senha_sql);

    if ($stmt_senha) {
        mysqli_stmt_bind_param($stmt_senha, "si", $senha_hash, $id);
        if (!mysqli_stmt_execute($stmt_senha)) {
            $atualizacao_sucesso_senha = false;
            error_log("Erro ao atualizar senha do usuário ID $id: " . mysqli_stmt_error($stmt_senha), 3, "error.log");
        }
        mysqli_stmt_close($stmt_senha);
    } else {
        $atualizacao_sucesso_senha = false;
        error_log("Erro ao preparar statement para senha do usuário ID $id: " . mysqli_error($conexao), 3, "error.log");
    }
}

// --- Feedback Final e Redirecionamento ---
if ($atualizacao_sucesso_dados && $atualizacao_sucesso_senha) {
    $_SESSION['feedback'] = ['type' => 'success', 'message' => 'Usuário atualizado com sucesso!'];
    header("Location: dadosPessoaisUsuario.php?id=" . $id); // Ou listaUsuarios.php, ou página de perfil
} else {
    // Monta uma mensagem de erro mais específica se possível
    $msg_erro_final = "Erro ao atualizar o usuário.";
    if (!$atualizacao_sucesso_dados) {
        $msg_erro_final .= " Falha ao atualizar dados básicos.";
    }
    if (!$atualizacao_sucesso_senha && !empty($senha_nova)) {
        $msg_erro_final .= " Falha ao atualizar senha.";
    }
    $_SESSION['feedback'] = ['type' => 'danger', 'message' => $msg_erro_final];
    header("Location: editaUsuario.php?id=" . $id); // De volta ao formulário de edição
}
exit();
?>