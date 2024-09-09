<?php
// Incluindo o arquivo de conexão com o banco de dados
include '../includes/db.php';  // Verifique se o caminho está correto
include '../includes/header.php';

// Consulta de relatórios de empréstimos em andamento
$sqlEmAndamento = "SELECT e.id_emprestimo, u.nome_user, l.titulo_livro, e.data_emprestimo, e.data_devolucao, e.devolvido, e.quantidade_emprestada
                   FROM tb_emprestimos e
                   JOIN tb_usuarios u ON e.fk_usuario = u.id_user
                   JOIN tb_livros l ON e.fk_livro = l.id_livro
                   WHERE e.devolvido = 0";
$resultEmAndamento = $conn->query($sqlEmAndamento);

// Consulta de relatórios de empréstimos históricos (já devolvidos)
$sqlHistorico = "SELECT e.id_emprestimo, u.nome_user, l.titulo_livro, e.data_emprestimo, e.data_devolucao, e.devolvido, e.quantidade_emprestada
                 FROM tb_emprestimos e
                 JOIN tb_usuarios u ON e.fk_usuario = u.id_user
                 JOIN tb_livros l ON e.fk_livro = l.id_livro
                 WHERE e.devolvido = 1";
$resultHistorico = $conn->query($sqlHistorico);

?>

<h1>Relatórios de Empréstimos</h1>

<!-- Relatório de Empréstimos em Andamento -->
<h2>Empréstimos em Andamento</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID Empréstimo</th>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Quantidade</th>
            <th>Data de Empréstimo</th>
            <th>Data de Devolução</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($resultEmAndamento && $resultEmAndamento->num_rows > 0) {
            while ($emprestimo = $resultEmAndamento->fetch_assoc()) {
                echo "<tr>
                        <td>{$emprestimo['id_emprestimo']}</td>
                        <td>{$emprestimo['nome_user']}</td>
                        <td>{$emprestimo['titulo_livro']}</td>
                        <td>{$emprestimo['quantidade_emprestada']}</td>
                        <td>{$emprestimo['data_emprestimo']}</td>
                        <td>{$emprestimo['data_devolucao']}</td>
                        <td>Em andamento</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Nenhum empréstimo em andamento encontrado.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Relatório de Histórico de Empréstimos -->
<h2>Histórico de Empréstimos</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID Empréstimo</th>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Quantidade</th>
            <th>Data de Empréstimo</th>
            <th>Data de Devolução</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($resultHistorico && $resultHistorico->num_rows > 0) {
            while ($historico = $resultHistorico->fetch_assoc()) {
                echo "<tr>
                        <td>{$historico['id_emprestimo']}</td>
                        <td>{$historico['nome_user']}</td>
                        <td>{$historico['titulo_livro']}</td>
                        <td>{$historico['quantidade_emprestada']}</td>
                        <td>{$historico['data_emprestimo']}</td>
                        <td>{$historico['data_devolucao']}</td>
                        <td>Devolvido</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Nenhum histórico de empréstimos encontrado.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>