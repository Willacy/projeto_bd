<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // pega as variaveis do psot referente ao usuario
    $nome_user = $_POST['nome_user'];
    $email_user = $_POST['email_user'];
    // pega os dados do enderenco
    $rua_endereco = $_POST['rua_endereco'];
    $bairro_endereco = $_POST['bairro_endereco'];
    $cep_endereco = $_POST['cep_endereco'];
    // Pega os dados do telefone
    $numero_tel = $_POST['numero_tel'];



}