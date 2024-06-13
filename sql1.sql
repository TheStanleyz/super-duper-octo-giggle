CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255),
    descricao TEXT,
    foto_perfil VARCHAR(255)
);

CREATE TABLE mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    tags TEXT,
    horario_jogo TEXT,
    descricao TEXT,
    imagem VARCHAR(255),
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);