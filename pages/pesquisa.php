<?php include '../includes/header.php'; ?>
<h1>Pesquisar Livros e Usuários</h1>

<?php
// Incluindo a conexão com o banco de dados
include '../includes/db.php';  // Verifique se o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termoPesquisa = $_POST['termo_pesquisa'];

    // Pesquisar livros
    $sqlLivros = "SELECT * FROM tb_livros WHERE titulo_livro LIKE '%$termoPesquisa%'";
    $resultLivros = $conn->query($sqlLivros);

    // Pesquisar usuários com junção para incluir o telefone
    $sqlUsuarios = "
        SELECT u.id_user, u.nome_user, u.email_user, t.numero_tel 
        FROM tb_usuarios u 
        LEFT JOIN tb_telefones t ON u.id_user = t.fk_usuario
        WHERE u.nome_user LIKE '%$termoPesquisa%'
    ";
    $resultUsuarios = $conn->query($sqlUsuarios);
}
?>

<!-- Formulário de Pesquisa -->
<form action="pesquisa.php" method="post">
    <div class="form-group">
        <label for="termo_pesquisa">Pesquisar Livros ou Usuários</label>
        <input type="text" id="termo_pesquisa" name="termo_pesquisa" class="form-control"
            placeholder="Digite o termo de pesquisa">
    </div>
    <button type="submit" class="btn btn-primary">Pesquisar</button>
</form>

<!-- Resultados da Pesquisa -->
<h2>Resultados da Pesquisa</h2>

<!-- Exibindo resultados de livros -->
<h3>Livros</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ano de Publicação</th>
            <th>ISBN</th>
            <th>Quantidade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($resultLivros)) {
            while ($livro = $resultLivros->fetch_assoc()) {
                echo "<tr>
                        <td>{$livro['id_livro']}</td>
                        <td>{$livro['titulo_livro']}</td>
                        <td>{$livro['ano_publicacao_livro']}</td>
                        <td>{$livro['isbn_livro']}</td>
                        <td>{$livro['quantidade_livro']}</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>

<!-- Exibindo resultados de usuários -->
<h3>Usuários</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($resultUsuarios)) {
            while ($usuario = $resultUsuarios->fetch_assoc()) {
                echo "<tr>
                        <td>{$usuario['id_user']}</td>
                        <td>{$usuario['nome_user']}</td>
                        <td>{$usuario['email_user']}</td>
                        <td>" . (!empty($usuario['numero_tel']) ? $usuario['numero_tel'] : 'Telefone não cadastrado') . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>