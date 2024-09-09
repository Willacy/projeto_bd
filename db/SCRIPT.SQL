-- DROP
DROP DATABASE IF EXISTS biblioteca;

-- CRIANDO A BASE DE DADOS E USANDO ELA
CREATE DATABASE IF NOT EXISTS biblioteca;

USE biblioteca;

-- CRIANDO AS TABELAS NECESSARIA PARA LIVROS
-- AUTORES
CREATE TABLE
    IF NOT EXISTS tb_autores (
        id_autor INT PRIMARY KEY AUTO_INCREMENT,
        nome_autor VARCHAR(120),
        email_autor VARCHAR(80)
    );

-- EDITORAS
CREATE TABLE
    IF NOT EXISTS tb_editoras (
        id_editora INT PRIMARY KEY AUTO_INCREMENT,
        nome_editora VARCHAR(120)
    );

-- LOCAIS
CREATE TABLE
    IF NOT EXISTS tb_locais (
        id_local INT PRIMARY KEY AUTO_INCREMENT,
        secao_local VARCHAR(30),
        prateleira_local VARCHAR(30),
        corredor_local VARCHAR(30)
    );

-- LIVROS
CREATE TABLE
    IF NOT EXISTS tb_livros (
        id_livro INT PRIMARY KEY AUTO_INCREMENT,
        titulo_livro VARCHAR(120),
        ano_publicacao_livro YEAR,
        isbn_livro VARCHAR(13),
        quantidade_livro INT,
        fk_editora INT,
        fk_local INT,
        FOREIGN KEY (fk_editora) REFERENCES tb_editoras (id_editora),
        FOREIGN KEY (fk_local) REFERENCES tb_locais (id_local)
    );

-- TABELA RELAÇÃO AUTOR LIVRO
CREATE TABLE
    IF NOT EXISTS tb_autor_livro (
        fk_livro INT,
        fk_autor INT,
        FOREIGN KEY (fk_livro) REFERENCES tb_livros (id_livro),
        FOREIGN KEY (fk_autor) REFERENCES tb_autores (id_autor)
    );

-- CRIANDO AS TABELAS NECESSARIA PARA USUARIOS
-- ENDERECO
CREATE TABLE
    IF NOT EXISTS tb_enderecos (
        id_endereco INT PRIMARY KEY AUTO_INCREMENT,
        rua_endereco VARCHAR(120),
        bairro_endereco VARCHAR(120),
        cep_endereco VARCHAR(15)
    );

-- USUARIOS
CREATE TABLE
    IF NOT EXISTS tb_usuarios (
        id_user INT PRIMARY KEY AUTO_INCREMENT,
        nome_user VARCHAR(120),
        email_user VARCHAR(120),
        fk_endereco INT,
        FOREIGN KEY (fk_endereco) REFERENCES tb_enderecos (id_endereco)
    );

-- TELEFONES
CREATE TABLE
    IF NOT EXISTS tb_telefones (
        id_tel INT PRIMARY KEY AUTO_INCREMENT,
        numero_tel VARCHAR(20),
        fk_usuario INT,
        FOREIGN KEY (fk_usuario) REFERENCES tb_usuarios (id_user)
    );

-- CRIANDO A TABELA EMPRESTIMO
CREATE TABLE
    IF NOT EXISTS tb_emprestimos (
        id_emprestimo INT PRIMARY KEY AUTO_INCREMENT,
        data_emprestimo DATE,
        data_devolucao DATE,
        quantidade_emprestada INT NOT NULL DEFAULT 1,
        quantidade_devolvida INT NOT NULL DEFAULT 0,
        devolvido BOOLEAN,
        fk_livro INT,
        fk_usuario INT,
        FOREIGN KEY (fk_livro) REFERENCES tb_livros (id_livro),
        FOREIGN KEY (fk_usuario) REFERENCES tb_usuarios (id_user)
    );