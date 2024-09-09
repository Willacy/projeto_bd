<?php include '../includes/header.php'; ?>
<h1>Gerenciar Usuários</h1>

<?php
include '../includes/db.php';

// Cadastrar endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_endereco'])) {
    $rua = $_POST['rua_endereco'];
    $bairro = $_POST['bairro_endereco'];
    $cep = $_POST['cep_endereco'];
    $sql = "INSERT INTO tb_enderecos (rua_endereco, bairro_endereco, cep_endereco) VALUES ('$rua', '$bairro', '$cep')";
    if ($conn->query($sql) === TRUE) {
        $idEndereco = $conn->insert_id;
        echo "<div class='alert alert-success'>Endereço cadastrado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Cadastrar usuário com endereço e telefone
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_usuario'])) {
    $nome = $_POST['nome_user'];
    $email = $_POST['email_user'];
    $rua = $_POST['rua_endereco'];
    $bairro = $_POST['bairro_endereco'];
    $cep = $_POST['cep_endereco'];
    $telefones = $_POST['telefones']; // Expecting a comma-separated string

    // Verificar se o endereço já existe
    $sqlEnderecoExistente = "SELECT id_endereco FROM tb_enderecos WHERE rua_endereco = '$rua' AND bairro_endereco = '$bairro' AND cep_endereco = '$cep'";
    $resultadoEndereco = $conn->query($sqlEnderecoExistente);

    if ($resultadoEndereco->num_rows > 0) {
        $endereco = $resultadoEndereco->fetch_assoc();
        $idEndereco = $endereco['id_endereco'];
    } else {
        // Iniciar a transação
        $conn->begin_transaction();

        try {
            // Cadastrar endereço
            $sqlEndereco = "INSERT INTO tb_enderecos (rua_endereco, bairro_endereco, cep_endereco) VALUES ('$rua', '$bairro', '$cep')";
            if ($conn->query($sqlEndereco) === TRUE) {
                $idEndereco = $conn->insert_id;

                // Cadastrar usuário
                $sqlUsuario = "INSERT INTO tb_usuarios (nome_user, email_user, fk_endereco) VALUES ('$nome', '$email', '$idEndereco')";
                if ($conn->query($sqlUsuario) === TRUE) {
                    $idUsuario = $conn->insert_id;

                    // Cadastrar telefones
                    $telefonesArray = explode(',', $telefones);
                    foreach ($telefonesArray as $telefone) {
                        $telefone = trim($telefone);
                        if (!empty($telefone)) {
                            $sqlTelefone = "INSERT INTO tb_telefones (numero_tel, fk_usuario) VALUES ('$telefone', '$idUsuario')";
                            $conn->query($sqlTelefone);
                        }
                    }

                    // Commit da transação
                    $conn->commit();
                    echo "<div class='alert alert-success'>Usuário, endereço e telefones cadastrados com sucesso!</div>";
                } else {
                    throw new Exception("Erro ao cadastrar usuário: " . $conn->error);
                }
            } else {
                throw new Exception("Erro ao cadastrar endereço: " . $conn->error);
            }
        } catch (Exception $e) {
            // Rollback da transação em caso de erro
            $conn->rollback();
            echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!-- Cadastro de Usuário com Endereço e Telefones -->
<h2>Cadastrar Usuário</h2>
<form action="usuarios.php" method="post">
    <div class="form-group">
        <label for="nome_user">Nome</label>
        <input type="text" class="form-control" id="nome_user" name="nome_user" required>
    </div>
    <div class="form-group">
        <label for="email_user">Email</label>
        <input type="email" class="form-control" id="email_user" name="email_user" required>
    </div>

    <!-- Seleção ou Cadastro de Endereço -->
    <h3 class="mt-4">Endereço</h3>
    <div class="form-group">
        <label for="endereco_existente">Endereço Existente</label>
        <select id="endereco_existente" name="endereco_existente" class="form-control">
            <option value="">Selecione um endereço</option>
            <?php
            $result = $conn->query("SELECT * FROM tb_enderecos");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_endereco']}'>{$row['rua_endereco']}, {$row['bairro_endereco']}, {$row['cep_endereco']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="rua_endereco">Rua (se o endereço não estiver na lista)</label>
        <input type="text" class="form-control" id="rua_endereco" name="rua_endereco">
    </div>
    <div class="form-group">
        <label for="bairro_endereco">Bairro (se o endereço não estiver na lista)</label>
        <input type="text" class="form-control" id="bairro_endereco" name="bairro_endereco">
    </div>
    <div class="form-group">
        <label for="cep_endereco">CEP (se o endereço não estiver na lista)</label>
        <input type="text" class="form-control" id="cep_endereco" name="cep_endereco">
    </div>

    <!-- Telefones -->
    <h3 class="mt-4">Telefones (separados por vírgula)</h3>
    <div class="form-group">
        <label for="telefones">Telefones</label>
        <input type="text" class="form-control" id="telefones" name="telefones"
            placeholder="(11) 99999-9999, (11) 88888-8888" required>
    </div>

    <button type="submit" name="cadastrar_usuario" class="btn btn-primary">Cadastrar Usuário</button>
</form>

<!-- Lista de Usuários -->
<h2 class="mt-4">Lista de Usuários</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereço</th>
            <th>Email</th>
            <th>Telefones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM tb_usuarios");
        while ($row = $result->fetch_assoc()) {
            $idEndereco = $row['fk_endereco'];
            $enderecoResult = $conn->query("SELECT * FROM tb_enderecos WHERE id_endereco = $idEndereco");
            $endereco = $enderecoResult->fetch_assoc();

            // Listar telefones
            $telefoneResult = $conn->query("SELECT * FROM tb_telefones WHERE fk_usuario = {$row['id_user']}");
            $telefones = [];
            while ($telRow = $telefoneResult->fetch_assoc()) {
                $telefones[] = $telRow['numero_tel'];
            }
            $telefonesLista = implode(", ", $telefones);

            echo "<tr>
                <td>{$row['id_user']}</td>
                <td>{$row['nome_user']}</td>
                <td>{$endereco['rua_endereco']}, {$endereco['bairro_endereco']}, {$endereco['cep_endereco']}</td>
                <td>{$row['email_user']}</td>
                <td>{$telefonesLista}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>