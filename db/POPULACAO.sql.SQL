-- POPULANDO A TABELA AUTORES
INSERT INTO tb_autores (nome_autor, email_autor) VALUES 
('J. K. Rowling', 'jk.rowling@example.com'),
('George R. R. Martin', 'george.martin@example.com'),
('J. R. R. Tolkien', 'tolkien@example.com'),
('Stephen King', 'stephen.king@example.com'),
('Isaac Asimov', 'asimov@example.com'),
('Agatha Christie', 'agatha@example.com'),
('Arthur Conan Doyle', 'conan.doyle@example.com'),
('Dan Brown', 'dan.brown@example.com'),
('Jules Verne', 'jules.verne@example.com'),
('Leo Tolstoy', 'tolstoy@example.com');

-- POPULANDO A TABELA EDITORAS
INSERT INTO tb_editoras (nome_editora) VALUES 
('Editora Bloomsbury'),
('Editora HarperCollins'),
('Editora Penguin Random House'),
('Editora Simon & Schuster'),
('Editora Companhia das Letras');

-- POPULANDO A TABELA LOCAIS
INSERT INTO tb_locais (secao_local, prateleira_local, corredor_local) VALUES 
('Ficção', 'A1', 'C1'),
('Ficção', 'A2', 'C1'),
('Suspense', 'B1', 'C2'),
('Fantasia', 'C1', 'C3'),
('Ciência', 'D1', 'C4');

-- POPULANDO A TABELA LIVROS
INSERT INTO tb_livros (titulo_livro, ano_publicacao_livro, isbn_livro, quantidade_livro, fk_editora, fk_local) VALUES 
('Harry Potter e a Pedra Filosofal', 1997, '9780747532699', 10, 1, 1),
('A Guerra dos Tronos', 1996, '9780553103540', 8, 2, 2),
('O Senhor dos Anéis', 1954, '9780544003415', 5, 2, 4),
('It: A Coisa', 1986, '9780451169518', 4, 3, 3),
('Fundação', 1951, '9780553803716', 6, 4, 5),
('Assassinato no Expresso do Oriente', 1934, '9780062693662', 7, 5, 3),
('O Cão dos Baskervilles', 1902, '9780141032436', 6, 3, 3),
('O Código Da Vinci', 2003, '9780307474278', 9, 1, 2),
('Vinte Mil Léguas Submarinas', 1870, '9780140399126', 5, 2, 5),
('Guerra e Paz', 1869, '9780307388875', 3, 4, 5);

-- Populando mais livros
INSERT INTO tb_livros (titulo_livro, ano_publicacao_livro, isbn_livro, quantidade_livro, fk_editora, fk_local) VALUES 
('Harry Potter e a Câmara Secreta', 1998, '9780439064866', 9, 1, 1),
('A Fúria dos Reis', 1998, '9780553579901', 7, 2, 2),
('O Hobbit', 1937, '9780547928227', 6, 2, 4),
('Carrie', 1974, '9780385086950', 5, 3, 3),
('Eu, Robô', 1950, '9780553382563', 4, 4, 5),
('Morte no Nilo', 1937, '9780062073551', 6, 5, 3),
('As Aventuras de Sherlock Holmes', 1892, '9780199536955', 7, 3, 3),
('Anjos e Demônios', 2000, '9780743486224', 8, 1, 2),
('A Volta ao Mundo em 80 Dias', 1873, '9780140449068', 5, 2, 5),
('Anna Karenina', 1877, '9780143035008', 3, 4, 5);

-- POPULANDO A TABELA AUTOR_LIVRO (relação muitos-para-muitos)
INSERT INTO tb_autor_livro (fk_livro, fk_autor) VALUES 
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5),
(6, 6), (7, 7), (8, 8), (9, 9), (10, 10),
(11, 1), (12, 2), (13, 3), (14, 4), (15, 5),
(16, 6), (17, 7), (18, 8), (19, 9), (20, 10);

-- POPULANDO A TABELA ENDERECOS
INSERT INTO tb_enderecos (rua_endereco, bairro_endereco, cep_endereco) VALUES 
('Rua das Flores', 'Centro', '12345-678'),
('Av. Paulista', 'Bela Vista', '98765-432'),
('Rua XV de Novembro', 'Centro', '45678-123'),
('Rua da Harmonia', 'Vila Madalena', '87654-321'),
('Rua Augusta', 'Consolação', '23456-789');

-- POPULANDO A TABELA USUARIOS
INSERT INTO tb_usuarios (nome_user, email_user, fk_endereco) VALUES 
('João Silva', 'joao.silva@example.com', 1),
('Maria Oliveira', 'maria.oliveira@example.com', 2),
('Pedro Santos', 'pedro.santos@example.com', 3),
('Ana Costa', 'ana.costa@example.com', 4),
('Lucas Almeida', 'lucas.almeida@example.com', 5);

-- Populando mais usuários
INSERT INTO tb_usuarios (nome_user, email_user, fk_endereco) VALUES 
('Carla Souza', 'carla.souza@example.com', 1),
('Ricardo Lima', 'ricardo.lima@example.com', 2),
('Fernanda Mendes', 'fernanda.mendes@example.com', 3),
('Rafael Castro', 'rafael.castro@example.com', 4),
('Juliana Ramos', 'juliana.ramos@example.com', 5),
('Gustavo Pereira', 'gustavo.pereira@example.com', 1),
('Paula Barbosa', 'paula.barbosa@example.com', 2),
('Bruno Fernandes', 'bruno.fernandes@example.com', 3),
('Aline Teixeira', 'aline.teixeira@example.com', 4),
('Eduardo Martins', 'eduardo.martins@example.com', 5);

-- POPULANDO A TABELA TELEFONES
INSERT INTO tb_telefones (numero_tel, fk_usuario) VALUES 
('11987654321', 1),
('11987654322', 2),
('11987654323', 3),
('11987654324', 4),
('11987654325', 5),
('11987654326', 6),
('11987654327', 7),
('11987654328', 8),
('11987654329', 9),
('11987654330', 10);

-- Populando mais telefones
INSERT INTO tb_telefones (numero_tel, fk_usuario) VALUES 
('11987654331', 11),
('11987654332', 12),
('11987654333', 13),
('11987654334', 14),
('11987654335', 15);

-- POPULANDO A TABELA EMPRESTIMOS
INSERT INTO tb_emprestimos (data_emprestimo, data_devolucao, quantidade_emprestada, quantidade_devolvida, devolvido, fk_livro, fk_usuario) VALUES 
('2024-09-01', '2024-09-15', 1, 0, 0, 1, 1),
('2024-09-02', '2024-09-16', 1, 0, 0, 2, 2),
('2024-09-03', '2024-09-17', 1, 0, 0, 3, 3),
('2024-09-04', '2024-09-18', 1, 0, 0, 4, 4),
('2024-09-05', '2024-09-19', 1, 0, 0, 5, 5);
