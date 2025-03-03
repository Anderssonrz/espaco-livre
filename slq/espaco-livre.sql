CREATE DATABASE `espaco-livre`;
USE `espaco-livre`;

-- Tabela: usuario
CREATE TABLE usuario (
	id_usuario INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(100) UNIQUE NOT NULL,
	senha VARCHAR(255) NOT NULL, -- Melhor para armazenar hashes seguros
	nome VARCHAR(150) NOT NULL,
	cpf CHAR(14) UNIQUE NOT NULL, -- Garantindo tamanho fixo
	telefone CHAR(15) -- Formato fixo (ex: (99) 99999-9999)
);

-- Tabela: vaga
CREATE TABLE vaga (
	id_vaga INT PRIMARY KEY AUTO_INCREMENT,
	descricao VARCHAR(500) NOT NULL, -- Melhor desempenho em buscas
	uf CHAR(2) NOT NULL,
	cidade VARCHAR(100) NOT NULL,
	bairro VARCHAR(100),
	endereco VARCHAR(255) NOT NULL,
	numero VARCHAR(20),
	complemento VARCHAR(255),
	foto_vaga VARCHAR(255), -- URL da foto
	preco DECIMAL(10,2) NOT NULL,
	latitude FLOAT,
	longitude FLOAT,
	id_usuario INT, -- Criador da vaga
	id_dono INT, -- Dono da vaga
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY (id_dono) REFERENCES usuario(id_usuario) ON DELETE SET NULL
);

-- Índices para melhorar performance nas consultas na tabela vaga
CREATE INDEX idx_cidade ON vaga(cidade);
CREATE INDEX idx_preco ON vaga(preco);

-- Tabela: reserva
CREATE TABLE reserva (
	id_reserva INT PRIMARY KEY AUTO_INCREMENT,
	id_usuario INT NOT NULL,
	id_vaga INT NOT NULL,
	data_inicio DATETIME NOT NULL,
	data_fim DATETIME NOT NULL,
	status ENUM('pendente', 'confirmada', 'cancelada', 'finalizada') NOT NULL DEFAULT 'pendente',
	FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
	FOREIGN KEY (id_vaga) REFERENCES vaga(id_vaga) ON DELETE CASCADE
);

-- Índices para melhorar performance nas consultas na tabela reserva
CREATE INDEX idx_status ON reserva(status);
CREATE INDEX idx_data_inicio ON reserva(data_inicio);