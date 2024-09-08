<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial BrModelo / PHP / MySQL</title>
    <link href="http://localhost/projeto_bd/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://localhost/projeto_bd/css/index.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once '../src/bootstrap_components.php';
    include_once '../src/nav_bar.php';
    ?>

    <body>
        <h1>Adicionar Usuário</h1>
        <form action="../controller/controllerUser.php" method="POST">
            <label for="nome_user">Nome:</label>
            <input type="text" name="nome_user" required><br><br>

            <label for="email_user">E-mail:</label>
            <input type="email" name="email_user" required><br><br>

            <h3>Endereço</h3>
            <label for="rua_endereco">Rua:</label>
            <input type="text" name="rua_endereco" required><br><br>

            <label for="bairro_endereco">Bairro:</label>
            <input type="text" name="bairro_endereco" required><br><br>

            <label for="cep_endereco">CEP:</label>
            <input type="text" name="cep_endereco" required><br><br>

            <h3>Telefone</h3>
            <label for="numero_tel">Telefone:</label>
            <input type="text" name="numero_tel" required><br><br>

            <input type="submit" value="Adicionar Usuário">
        </form>
    </body>

</html>