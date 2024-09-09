<?php include '../includes/header.php'; ?>
<h1>Gerenciar Devoluções</h1>

<?php
include '../includes/db.php';

// Realizar devolução
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar_devolucao'])) {
    $emprestimoId = $_POST['emprestimo_id'];
    $quantidadeDevolucao = $_POST['quantidade_devolucao'];

    // Busca o empréstimo correspondente e a quantidade de livros restantes a serem devolvidos
    $sqlEmprestimo = "SELECT fk_livro, quantidade_emprestada, quantidade_devolvida 
                      FROM tb_emprestimos 
                      WHERE id_emprestimo = '$emprestimoId'";
    $resultEmprestimo = $conn->query($sqlEmprestimo);

    if ($resultEmprestimo->num_rows > 0) {
        $emprestimo = $resultEmprestimo->fetch_assoc();
        $livroId = $emprestimo['fk_livro'];
        $quantidadeEmprestada = $emprestimo['quantidade_emprestada'];
        $quantidadeDevolvida = $emprestimo['quantidade_devolvida'];

        // Verifica se a devolução excede a quantidade emprestada
        if ($quantidadeDevolvida + $quantidadeDevolucao <= $quantidadeEmprestada) {
            // Atualiza a quantidade devolvida no empréstimo
            $novaQuantidadeDevolvida = $quantidadeDevolvida + $quantidadeDevolucao;
            $sqlUpdateEmprestimo = "UPDATE tb_emprestimos SET quantidade_devolvida = '$novaQuantidadeDevolvida' 
                                    WHERE id_emprestimo = '$emprestimoId'";

            if ($conn->query($sqlUpdateEmprestimo) === TRUE) {
                // Atualiza o estoque de livros
                $sqlLivro = "UPDATE tb_livros SET quantidade_livro = quantidade_livro + $quantidadeDevolucao 
                             WHERE id_livro = '$livroId'";
                $conn->query($sqlLivro);

                // Se todos os livros foram devolvidos, marca o empréstimo como concluído
                if ($novaQuantidadeDevolvida == $quantidadeEmprestada) {
                    $sqlFinalizarEmprestimo = "UPDATE tb_emprestimos SET devolvido = 1 WHERE id_emprestimo = '$emprestimoId'";
                    $conn->query($sqlFinalizarEmprestimo);
                }

                echo "<div class='alert alert-success'>Quantidade de $quantidadeDevolucao livros devolvida com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao registrar devolução: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Erro: A quantidade devolvida excede a quantidade emprestada!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Erro: Empréstimo não encontrado!</div>";
    }
}
?>

<!-- Formulário de Devolução -->
<h2>Realizar Devolução</h2>
<form action="devolucoes.php" method="post">
    <div class="form-group">
        <label for="emprestimo_id">Empréstimo</label>
        <select id="emprestimo_id" name="emprestimo_id" class="form-control" required>
            <option value="">Selecione o empréstimo</option>
            <?php
            // Exibe os empréstimos pendentes de devolução
            $resultEmprestimos = $conn->query("SELECT e.id_emprestimo, l.titulo_livro, u.nome_user 
                                               FROM tb_emprestimos e 
                                               JOIN tb_livros l ON e.fk_livro = l.id_livro 
                                               JOIN tb_usuarios u ON e.fk_usuario = u.id_user 
                                               WHERE e.devolvido = 0");
            while ($emprestimo = $resultEmprestimos->fetch_assoc()) {
                echo "<option value='{$emprestimo['id_emprestimo']}'>Livro: {$emprestimo['titulo_livro']} - Usuário: {$emprestimo['nome_user']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="quantidade_devolucao">Quantidade Devolvida</label>
        <input type="number" class="form-control" id="quantidade_devolucao" name="quantidade_devolucao" min="1"
            required>
    </div>
    <button type="submit" name="realizar_devolucao" class="btn btn-primary">Devolver Livro</button>
</form>

<!-- Lista de Empréstimos Pendentes -->
<h2 class="mt-4">Empréstimos Pendentes</h2>
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