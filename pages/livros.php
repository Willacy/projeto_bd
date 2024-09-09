<?php include '../includes/header.php'; ?>
<h1>Gerenciar Livros</h1>

<?php
include '../includes/db.php';

// Cadastrar editora
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_editora'])) {
    $nomeEditora = $_POST['nome_editora'];
    $sql = "INSERT INTO tb_editoras (nome_editora) VALUES ('$nomeEditora')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Editora cadastrada com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Cadastrar autor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_autor'])) {
    $nomeAutor = $_POST['nome_autor'];
    $emailAutor = $_POST['email_autor'];
    $sql = "INSERT INTO tb_autores (nome_autor, email_autor) VALUES ('$nomeAutor', '$emailAutor')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Autor cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Cadastrar local
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_local'])) {
    $secaoLocal = $_POST['secao_local'];
    $prateleiraLocal = $_POST['prateleira_local'];
    $corredorLocal = $_POST['corredor_local'];
    $sql = "INSERT INTO tb_locais (secao_local, prateleira_local, corredor_local) VALUES ('$secaoLocal', '$prateleiraLocal', '$corredorLocal')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Local cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Cadastrar livro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_livro'])) {
    $titulo = $_POST['titulo_livro'];
    $ano = $_POST['ano_publicacao_livro'];
    $isbn = $_POST['isbn_livro'];
    $quantidade = $_POST['quantidade_livro'];
    $editoraId = $_POST['editora_existente'];
    $autorId = $_POST['autor_existente'];
    $localId = $_POST['local_existente'];

    // Verificar se a editora existe
    if (empty($editoraId)) {
        $nomeEditora = $_POST['nome_editora'];
        $sqlEditora = "INSERT INTO tb_editoras (nome_editora) VALUES ('$nomeEditora')";
        if ($conn->query($sqlEditora) === TRUE) {
            $editoraId = $conn->insert_id;
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar editora: " . $conn->error . "</div>";
            $editoraId = null;
        }
    }

    // Verificar se o autor existe
    if (empty($autorId)) {
        $nomeAutor = $_POST['nome_autor'];
        $emailAutor = $_POST['email_autor'];
        $sqlAutor = "INSERT INTO tb_autores (nome_autor, email_autor) VALUES ('$nomeAutor', '$emailAutor')";
        if ($conn->query($sqlAutor) === TRUE) {
            $autorId = $conn->insert_id;
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar autor: " . $conn->error . "</div>";
            $autorId = null;
        }
    }

    // Verificar se o local existe
    if (empty($localId)) {
        $secaoLocal = $_POST['secao_local'];
        $prateleiraLocal = $_POST['prateleira_local'];
        $corredorLocal = $_POST['corredor_local'];
        $sqlLocal = "INSERT INTO tb_locais (secao_local, prateleira_local, corredor_local) VALUES ('$secaoLocal', '$prateleiraLocal', '$corredorLocal')";
        if ($conn->query($sqlLocal) === TRUE) {
            $localId = $conn->insert_id;
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar local: " . $conn->error . "</div>";
            $localId = null;
        }
    }

    if ($editoraId && $autorId && $localId) {
        // Cadastrar livro
        $sqlLivro = "INSERT INTO tb_livros (titulo_livro, ano_publicacao_livro, isbn_livro, quantidade_livro, fk_editora, fk_local) VALUES ('$titulo', '$ano', '$isbn', '$quantidade', '$editoraId', '$localId')";
        if ($conn->query($sqlLivro) === TRUE) {
            $livroId = $conn->insert_id;

            // Associar autor ao livro
            $sqlAutorLivro = "INSERT INTO tb_autor_livro (fk_livro, fk_autor) VALUES ('$livroId', '$autorId')";
            if ($conn->query($sqlAutorLivro) === TRUE) {
                echo "<div class='alert alert-success'>Livro cadastrado com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao associar autor ao livro: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar livro: " . $conn->error . "</div>";
        }
    }
}
?>

<!-- Cadastro de Livro -->
<h2>Cadastrar Livro</h2>
<form action="livros.php" method="post">
    <div class="form-group">
        <label for="titulo_livro">Título</label>
        <input type="text" class="form-control" id="titulo_livro" name="titulo_livro" required>
    </div>
    <div class="form-group">
        <label for="ano_publicacao_livro">Ano de Publicação</label>
        <input type="number" class="form-control" id="ano_publicacao_livro" name="ano_publicacao_livro" required>
    </div>
    <div class="form-group">
        <label for="isbn_livro">ISBN</label>
        <input type="text" class="form-control" id="isbn_livro" name="isbn_livro" required>
    </div>
    <div class="form-group">
        <label for="quantidade_livro">Quantidade</label>
        <input type="number" class="form-control" id="quantidade_livro" name="quantidade_livro" required>
    </div>

    <!-- Seleção ou Cadastro de Editora -->
    <h3 class="mt-4">Editora</h3>
    <div class="form-group">
        <label for="editora_existente">Editora Existente</label>
        <select id="editora_existente" name="editora_existente" class="form-control">
            <option value="">Selecione uma editora</option>
            <?php
            $result = $conn->query("SELECT * FROM tb_editoras");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_editora']}'>{$row['nome_editora']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nome_editora">Nome da Editora (se a editora não estiver na lista)</label>
        <input type="text" class="form-control" id="nome_editora" name="nome_editora">
    </div>

    <!-- Seleção ou Cadastro de Autor -->
    <h3 class="mt-4">Autor</h3>
    <div class="form-group">
        <label for="autor_existente">Autor Existente</label>
        <select id="autor_existente" name="autor_existente" class="form-control">
            <option value="">Selecione um autor</option>
            <?php
            $result = $conn->query("SELECT * FROM tb_autores");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_autor']}'>{$row['nome_autor']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="nome_autor">Nome do Autor (se o autor não estiver na lista)</label>
        <input type="text" class="form-control" id="nome_autor" name="nome_autor">
    </div>
    <div class="form-group">
        <label for="email_autor">Email do Autor (se o autor não estiver na lista)</label>
        <input type="email" class="form-control" id="email_autor" name="email_autor">
    </div>

    <!-- Seleção ou Cadastro de Local -->
    <h3 class="mt-4">Local</h3>
    <div class="form-group">
        <label for="local_existente">Local Existente</label>
        <select id="local_existente" name="local_existente" class="form-control">
            <option value="">Selecione um local</option>
            <?php
            $result = $conn->query("SELECT * FROM tb_locais");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_local']}'>{$row['secao_local']} - {$row['prateleira_local']} - {$row['corredor_local']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="secao_local">Seção (se o local não estiver na lista)</label>
        <input type="text" class="form-control" id="secao_local" name="secao_local">
    </div>
    <div class="form-group">
        <label for="prateleira_local">Prateleira (se o local não estiver na lista)</label>
        <input type="text" class="form-control" id="prateleira_local" name="prateleira_local">
    </div>
    <div class="form-group">
        <label for="corredor_local">Corredor (se o local não estiver na lista)</label>
        <input type="text" class="form-control" id="corredor_local" name="corredor_local">
    </div>

    <button type="submit" name="cadastrar_livro" class="btn btn-primary">Cadastrar Livro</button>
</form>

<!-- Lista de Livros -->
<h2 class="mt-4">Lista de Livros</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Ano</th>
            <th>ISBN</th>
            <th>Quantidade</th>
            <th>Editora</th>
            <th>Local</th>
            <th>Autores</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqlLivros = "SELECT l.*, e.nome_editora, lo.secao_local, lo.prateleira_local, lo.corredor_local FROM tb_livros l JOIN tb_editoras e ON l.fk_editora = e.id_editora JOIN tb_locais lo ON l.fk_local = lo.id_local";
        $resultLivros = $conn->query($sqlLivros);
        while ($livro = $resultLivros->fetch_assoc()) {
            echo "<tr>
                <td>{$livro['id_livro']}</td>
                <td>{$livro['titulo_livro']}</td>
                <td>{$livro['ano_publicacao_livro']}</td>
                <td>{$livro['isbn_livro']}</td>
                <td>{$livro['quantidade_livro']}</td>
                <td>{$livro['nome_editora']}</td>
                <td>{$livro['secao_local']} - {$livro['prateleira_local']} - {$livro['corredor_local']}</td>
                <td>";

            // Listar autores do livro
            $sqlAutores = "SELECT a.nome_autor FROM tb_autores a JOIN tb_autor_livro al ON a.id_autor = al.fk_autor WHERE al.fk_livro = {$livro['id_livro']}";
            $resultAutores = $conn->query($sqlAutores);
            $autores = [];
            while ($autor = $resultAutores->fetch_assoc()) {
                $autores[] = $autor['nome_autor'];
            }
            echo implode(', ', $autores);

            echo "</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>