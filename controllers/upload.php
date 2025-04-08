<?php
include_once("conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form option="conexao.php" method="post">
    <select name="loja" required>

        <option value="">Por favor, escolha a loja</option>
        
        <?php        
        $query = $conn->query("SELECT id_loja, nome_loja FROM loja ORDER BY id_loja ASC");
        $registros = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($registros as $option) {
            ?>
                <option value="<?php echo $option['id_loja'] ?>"><?php echo $option['nome_loja'] ?></option>
            <?php
        }
        ?>
    </select>
    
    </form>
</body>

</html>