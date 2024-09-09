<?php include '../includes/header.php'; ?>
<h1>Gerenciar Empréstimos</h1>

<?php
include '../includes/db.php';

// Realizar Empréstimo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar_emprestimo'])) {
    $livroId = $_POST['livro_id'];
    $usuarioId = $_POST['usuario_id'];
    $quantidadeEmprestada = $_POST['quantidade_emprestada'];

    // Define a data de empréstimo e a data de devolução
    $dataEmprestimo = date('Y-m-d'); // Data de hoje
    $dataDevolucao = date('Y-m-d', strtotime('+7 days')); // Devolução 7 dias após o empréstimo

    // Verifica se o livro tem a quantidade disponível
    $sqlVerificaQuantidade = "SELECT quantidade_livro FROM tb_livros WHERE id_livro = '$livroId'";
    $resultQuantidade = $conn->query($sqlVerificaQuantidade);
    $livro = $resultQuantidade->fetch_assoc();

    if ($livro['quantidade_livro'] >= $quantidadeEmprestada) {
        // Insere o novo empréstimo
        $sql = "INSERT INTO tb_emprestimos (data_emprestimo, data_devolucao, devolvido, fk_livro, fk_usuario, quantidade_emprestada)
                VALUES ('$dataEmprestimo', '$dataDevolucao', 0, '$livroId', '$usuarioId', '$quantidadeEmprestada')";

        if ($conn->query($sql) === TRUE) {
            // Atualiza a quantidade de livros no estoque
            $novaQuantidade = $livro['quantidade_livro'] - $quantidadeEmprestada;
            $sqlAtualizaLivro = "UPDATE tb_livros SET quantidade_livro = '$novaQuantidade' WHERE id_livro = '$livroId'";
            $conn->query($sqlAtualizaLivro);

            echo "<div class='alert alert-success'>Empréstimo realizado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao realizar empréstimo: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erro: Quantidade de livros insuficiente para o empréstimo!</div>";
    }
}
?>

<!-- Formulário de Empréstimo -->
<h2>Realizar Empréstimo</h2>
<form action="emprestimos.php" method="post">
    <div class="form-group">
        <label for="livro_id">Livro</label>
        <select id="livro_id" name="livro_id" class="form-control" required>
            <option value="">Selecione o livro</option>
            <?php
            // Exibe os livros disponíveis
            $resultLivros = $conn->query("SELECT id_livro, titulo_livro FROM tb_livros");
            while ($livro = $resultLivros->fetch_assoc()) {
                echo "<option value='{$livro['id_livro']}'>{$livro['titulo_livro']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="usuario_id">Usuário</label>
        <select id="usuario_id" name="usuario_id" class="form-control" required>
            <option value="">Selecione o usuário</option>
            <?php
            // Exibe os usuários cadastrados
            $resultUsuarios = $conn->query("SELECT id_user, nome_user FROM tb_usuarios");
            while ($usuario = $resultUsuarios->fetch_assoc()) {
                echo "<option value='{$usuario['id_user']}'>{$usuario['nome_user']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantidade_emprestada">Quantidade de Livros</label>
        <input type="number" class="form-control" id="quantidade_emprestada" name="quantidade_emprestada" min="1"
            required>
    </div>

    <button type="submit" name="realizar_emprestimo" class="btn btn-primary">Realizar Empréstimo</button>
</form>

<!-- Lista de Empréstimos -->
<h2 class="mt-4">Empréstimos em Andamento</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Livro</th>
            <th>Usuário</th>
            <th>Data de Empréstimo</th>
            <th>Data de Devolução</th>
            <th>Quantidade Emprestada</th>
            <th>Quantidade Devolvida</th>
            <th>Devolvido</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqlEmprestimos = "SELECT e.id_emprestimo, l.titulo_livro, u.nome_user, e.data_emprestimo, e.data_devolucao, 
                                  e.quantidade_emprestada, e.quantidade_devolvida, e.devolvido 
                           FROM tb_emprestimos e 
                           JOIN tb_livros l ON e.fk_livro = l.id_livro 
                           JOIN tb_usuarios u ON e.fk_usuario = u.id_user 
                           WHERE e.devolvido = 0";
        $resultEmprestimos = $conn->query($sqlEmprestimos);
        while ($emprestimo = $resultEmprestimos->fetch_assoc()) {
            $devolvido = $emprestimo['devolvido'] ? 'Sim' : 'Não';
            echo "<tr>
                <td>{$emprestimo['id_emprestimo']}</td>
                <td>{$emprestimo['titulo_livro']}</td>
                <td>{$emprestimo['nome_user']}</td>
                <td>{$emprestimo['data_emprestimo']}</td>
                <td>{$emprestimo['data_devolucao']}</td>
                <td>{$emprestimo['quantidade_emprestada']}</td>
                <td>{$emprestimo['quantidade_devolvida']}</td>
                <td>{$devolvido}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>