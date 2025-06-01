<?php
session_start();
include_once ("conexao.php"); // Espera-se que defina $conexao (mysqli)

// 1. Corrigido o nome do campo para 'id_vaga'
$id_vaga = filter_input(INPUT_POST, 'id_vaga', FILTER_SANITIZE_NUMBER_INT);

if (empty($id_vaga)) {
    $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'ID da vaga inválido!']];
    header("Location: account.php"); // Redirecionar para uma página de erro ou lista
    exit();
}

// Sanitização básica. Se permitir HTML na descrição, considere uma biblioteca como HTML Purifier.
// Para outros campos, se não devem conter caracteres especiais, FILTER_SANITIZE_SPECIAL_CHARS pode ser mais adequado.
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT); // FILTER_DEFAULT é similar a FILTER_UNSAFE_RAW
$cep = filter_input(INPUT_POST, 'cep', FILTER_DEFAULT);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_DEFAULT);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_DEFAULT);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_DEFAULT);
$numero = filter_input(INPUT_POST, 'numero', FILTER_DEFAULT); // Se for só número, SANITIZE_NUMBER_INT é melhor, mas pode ter 's/n'
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_DEFAULT);

// Preço: Converter vírgula para ponto para o banco de dados
$preco_str = str_replace('.', '', filter_input(INPUT_POST, 'preco', FILTER_DEFAULT)); // Remove separador de milhar
$preco = str_replace(',', '.', $preco_str); // Troca vírgula decimal por ponto
$preco = filter_var($preco, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// 2. id_usuario: Decidir como obter. Exemplo: da sessão.
// Se o id_usuario da vaga NÃO MUDA, não precisa incluir no UPDATE.
// Se precisa ser o usuário logado:
// $id_usuario_logado = $_SESSION['usuario_id'] ?? null; // Ajuste o nome da variável de sessão
// if (!$id_usuario_logado) {
//     $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Usuário não autenticado.']];
//     header("Location: login.php");
//     exit();
// }
// E então você compararia se $id_usuario_logado tem permissão para editar esta vaga (geralmente feito antes, ao carregar editVaga.php)

// 3. Sanitização de id_uf
$id_uf = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);

$foto_vaga_db_path = ""; // Caminho a ser salvo no banco

// Processamento do upload da nova foto
if (isset($_FILES["foto_vaga"]) && $_FILES["foto_vaga"]["error"] == 0) {
    $pasta_destino = "assets/img/vagas/"; // Usar subpasta 'vagas' pode ser mais organizado
    if (!is_dir($pasta_destino)) {
        mkdir($pasta_destino, 0775, true); // Tenta criar o diretório se não existir
    }
    $nome_arquivo_original = basename($_FILES["foto_vaga"]["name"]);
    $extensao = strtolower(pathinfo($nome_arquivo_original, PATHINFO_EXTENSION));
    $nome_arquivo_novo = uniqid('vaga_', true) . "." . $extensao; // Adiciona prefixo e usa true para mais entropia
    $caminho_completo_novo = $pasta_destino . $nome_arquivo_novo;

    // Validações adicionais de arquivo (tipo, tamanho)
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($extensao, $allowed_types)) {
        $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Tipo de arquivo de imagem inválido.']];
        header("Location: editVaga.php?id=" . $id_vaga);
        exit();
    }
    // Validação de tamanho (ex: 5MB)
    if ($_FILES["foto_vaga"]["size"] > 5 * 1024 * 1024) {
        $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'O arquivo da imagem é muito grande (Max: 5MB).']];
        header("Location: editVaga.php?id=" . $id_vaga);
        exit();
    }

    if (move_uploaded_file($_FILES["foto_vaga"]["tmp_name"], $caminho_completo_novo)) {
        $foto_vaga_db_path = $caminho_completo_novo;

        // Lógica para excluir a foto antiga (opcional)
        $foto_antiga_path = filter_input(INPUT_POST, 'foto_vaga_antiga', FILTER_DEFAULT);
        if (!empty($foto_antiga_path) && $foto_antiga_path != $foto_vaga_db_path && file_exists($foto_antiga_path)) {
            unlink($foto_antiga_path);
        }
    } else {
        $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Erro ao salvar a nova foto da vaga!']];
        header("Location: editVaga.php?id=" . $id_vaga);
        exit();
    }
} else {
    // Nenhuma nova foto enviada, mantém a foto antiga
    $foto_vaga_db_path = filter_input(INPUT_POST, 'foto_vaga_antiga', FILTER_DEFAULT);
    // Se 'foto_vaga_antiga' puder estar vazio e você precisar buscar do DB:
    // (Essa lógica de buscar no DB se o campo hidden estiver vazio pode ser redundante se o form sempre o preencher)
    if (empty($foto_vaga_db_path)) {
        $stmt_foto_antiga = mysqli_prepare($conexao, "SELECT foto_vaga FROM vagas WHERE id = ?");
        mysqli_stmt_bind_param($stmt_foto_antiga, "i", $id_vaga);
        mysqli_stmt_execute($stmt_foto_antiga);
        $result_foto_antiga = mysqli_stmt_get_result($stmt_foto_antiga);
        if ($row_foto_antiga = mysqli_fetch_assoc($result_foto_antiga)) {
            $foto_vaga_db_path = $row_foto_antiga['foto_vaga'];
        }
        mysqli_stmt_close($stmt_foto_antiga);
    }
}

// 4. Query UPDATE corrigida (removido id_usuario da query por enquanto, adicione se necessário)
// Adicionei virgula entre cep e cidade.
$update_vaga_sql = "UPDATE vagas SET descricao=?, cep=?, cidade=?, bairro=?, endereco=?, numero=?, complemento=?,
                     foto_vaga=?, preco=?, id_uf=?
                     WHERE id = ?";

$stmt = mysqli_prepare($conexao, $update_vaga_sql);

if ($stmt === false) {
    // Erro na preparação da query
    error_log("Erro ao preparar statement: " . mysqli_error($conexao));
    $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Erro no servidor ao tentar editar a vaga. (PREP)']];
    header("Location: editVaga.php?id=" . $id_vaga);
    exit();
}

// 5. Tipos no bind_param ajustados. `$numero` como string para permitir "s/n". Se for sempre int, use 'i'.
// Assumindo que 'numero' pode conter caracteres como "S/N", mantive 's'. Se for estritamente numérico, mude para 'i'.
// A string de tipos agora tem 10 especificadores para 10 placeholders (sem id_usuario).
// s: descricao, s: cep, s: cidade, s: bairro, s: endereco, s: numero, s: complemento, s: foto_vaga_db_path, d: preco, i: id_uf, i: id_vaga
mysqli_stmt_bind_param($stmt, "ssssssssdii",
    $descricao, $cep, $cidade, $bairro, $endereco, $numero, $complemento,
    $foto_vaga_db_path, $preco, $id_uf, $id_vaga
);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $_SESSION['feedback_messages'] = [['type' => 'success', 'message' => 'Vaga editada com sucesso!']];
    } else {
        $_SESSION['feedback_messages'] = [['type' => 'info', 'message' => 'Nenhuma alteração foi feita na vaga.']];
    }
    header("Location: account.php#minhas-vagas"); // Ou uma página de sucesso/detalhes da vaga
    exit();
} else {
    error_log("Erro ao editar vaga (ID: $id_vaga): " . mysqli_stmt_error($stmt));
    $_SESSION['feedback_messages'] = [['type' => 'danger', 'message' => 'Erro ao editar a vaga no banco de dados!']];
    header("Location: editVaga.php?id=" . $id_vaga);
    exit();
}

// 7. O header() genérico no final foi removido, pois cada caminho já tem seu header() e exit().
?>