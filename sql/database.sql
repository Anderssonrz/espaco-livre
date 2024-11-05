CREATE DATABASE estacionamento;
USE estacionamento;

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE vagas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    localizacao VARCHAR(255),
    preco DECIMAL(10, 2),
    disponibilidade VARCHAR(50),
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
