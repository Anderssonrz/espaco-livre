



<!DOCTYPE html>
<?php
//-----------------------------------------exemplo para pegar o PHP----------------------------
require_once("conexao.php");

if (isset($_POST['btnCadastrar'])) {

    $coluna['nome'] = $_POST['txtNome'];
    $coluna['descricao'] = $_POST['txtDescricao'];
    $coluna['quantidade'] = $_POST['numQuant'];
    $coluna['data_cadastro'] = $_POST['dataCadastro'];
    $coluna['preco'] = $_POST['numValor'];
    $coluna['descontos'] = $_POST['numDesc'];
    $coluna['id_loja'] = $_POST['loja'];
    //$produto['categoria'] = $_POST['categoria'];
    $coluna['tipo'] = $_POST['tipo'];
    //$titulo = "Upload de imagens";
    cadastrarProduto($conexao, $coluna);
}

//Existe inserteza se a sintaxe está correta
$produto = null;

if (isset($_POST['categoria']))
    $produto = $_POST['categoria'];

if ($produto !== null) {
    for ($i = 0; $i < count($produto); $i++) {
        echo "<p>{$produto[$i]}</p>";
    }
}

// $titulo = "Upload de imagens";


// if (isset($_FILES["imagem"]) && !empty($_FILES["imagem"])) {
//     move_uploaded_file($_FILES["imagem"]["tmp_name"], "./img/" . $_FILES["imagem"]["name"]);
//     echo "<p>upload realizado</p>";
// }

?>

<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cadastro de Produtos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">
                            <h4>HOME Técnologia Online</h4>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="#!"></a></li>
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"></a> -->
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!"></a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="#!"></a></li>
                            <li><a class="dropdown-item" href="#!"></a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <!-- <button class="btn btn-outline-dark" type="submit"> -->
                    <!-- <i class="bi-cart-fill me-1"></i> -->

                    <!-- <span class="badge bg-dark text-white ms-1 rounded-pill"></span> -->
                    <!-- </button> -->
                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1>Fórmulário Cadastro</h1>
                <p class="lead fw-normal text-white-50 mb-0"></p>
            </div>
        </div>
    </header>


    <section class="py-5">

        <div class="container">Dados Pessoais
            <form action="" method="POST">
                <div class="row">
                    <div class="col-6">

                        <div>
                            <label for="nomeProd" class="labelInput">
                                <h6>Nome completo</h6>
                            </label><br>
                            <input type="text" name="txtNome" id="nomeProd" class="inputUser" required>
                        </div>
                        <div>
                            <label for="dataCadastro">
                                <h6>Data do nascimento</h6>
                            </label><br>
                            <input type="date" name="dataCadastro" id="dataCdastro" required>
                        </div>
                        <label for="cpf">
                                <h6>CPF</h6>
                            </label><br>
                            <input type="text" name="cpf" id="cpf" required>
                        </div>
                        <label for="cnh">
                                <h6>CNH</h6>
                            </label><br>
                            <input type="text" name="cnh" id="cnh" class="inputUser" required>
                        </div>
                        <label for="cpf">
                                <h6>CPF</h6>
                            </label><br>
                            <input type="text" name="cpf" id="cpf" required>
                        </div>
                        <br><br>

                        <div>
                            <label for="nomeProd" class="labelInput">
                                <h6>Quantidade</h6>
                            </label><br>
                            <input type="number" name="numQuant" id="nomeProd" class="inputUser" required>
                        </div>
                        <br><br>

                        <br><br>

                        <div>
                            <label for="estado" class="labelInput">
                                <h6>Preço</h6>
                            </label><br>
                            <input type="number" name="numValor" id="valor" class="inputUser" required>
                        </div>
                        <br><br>

                        <div>
                            <label for="descontos" class="labelInput">
                                <h6>Desconto Promocional</h6>
                            </label><br>
                            <input type="number" name="numDesc" class="inputUser" required>
                        </div>
                    </div>



                    

                        
                        <div>
                            <button type="submit" name="btnCadastrar" class="btn btn-primary">
                                <h6>Cadastrar</h6>
                            </button>

                            <button type="submit" name="btnLimpar" class="btn btn-primary">
                                <h6>Limpar</h6>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>




    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

</body>

</html>


<?php
function cadastrarProduto($conexao, $coluna)
{
    $nome = $coluna['nome'];
    $descricao = $coluna['descricao'];
    $quantidade = $coluna['quantidade'];
    $data_cadastro = $coluna['data_cadastro'];
    $preco = $coluna['preco'];
    $descontos = $coluna['descontos'];
    $id_loja = $coluna['id_loja'];
    // $categoria = $coluna['categoria'];
    $tipo = $coluna['tipo'];
    $tipo = $coluna['imagem'];


    $sql = "INSERT INTO cad_produto (nome, descricao, quantidade, data_cadastro, preco, descontos, id_loja, tipo) 
    VALUES ('$nome', '$descricao', '$quantidade', '$data_cadastro', '$preco' , '$descontos' , '$id_loja', '$tipo')";

    if (mysqli_query($conexao, $sql) == TRUE) {
        echo "Registro inserido com sucesso!";
        header("Location: cadastroProduto.php");
    } else {

        echo "Erro ao inserir o registro" . mysqli_connect_error();
    }
    header('Location: listagemProdutos.php');
}
?>