<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial BrModelo / PHP / MySQL</title>
    <link href="http://localhost/projeto_bd/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://localhost/projeto_bd/css/index.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once './src/bootstrap_components.php';
    include_once './src/nav_bar.php';
    ?>

    <body>
        <h1>Sistema de Gestão de Biblioteca</h1>
        <div class="row mx-auto" style="width: 98%">
            <div class="menu col-3">
                <h3>Escolha uma ação:</h3>
                <ul>
                    <li><a href="./view/add_user.php">Adicionar Usuário</a></li>
                    <li><a href="adicionar_livro.php">Adicionar Livro</a></li>
                    <li><a href="emprestar_livro.php">Realizar Empréstimo</a></li>
                    <li><a href="devolver_livro.php">Devolver Livro</a></li>
                    <li><a href="pesquisar_livro.php">Pesquisar Livro</a></li>
                    <li><a href="pesquisar_usuario.php">Pesquisar Usuário</a></li>
                    <li><a href="relatorio_emprestimos.php">Relatórios de Empréstimos</a></li>
                </ul>
            </div>
            <div class="resultado col bg-danger">
                dfdfddf
            </div>
        </div>

    </body>

</html>