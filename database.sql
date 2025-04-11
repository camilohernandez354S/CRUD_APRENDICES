-- Crear base de datos
CREATE DATABASE IF NOT EXISTS prueba_db;

USE prueba_db;

-- Tabla: tipos_documento
CREATE TABLE tipos_documento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL
);

-- Tabla: generos
CREATE TABLE generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genero VARCHAR(50) NOT NULL
);

-- Tabla: grupos_sanguineos
CREATE TABLE grupos_sanguineos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grupo ENUM('A', 'B', 'AB', 'O') NOT NULL,
    factor ENUM('+', '-') NOT NULL
);

-- Tabla: personas
CREATE TABLE personas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento_id INT NOT NULL,
    genero_id INT NOT NULL,
    grupo_sanguineo_id INT NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    num_documento VARCHAR(20) NOT NULL UNIQUE,
    primer_nombre VARCHAR(50) NOT NULL,
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    FOREIGN KEY (tipo_documento_id) REFERENCES tipos_documento(id),
    FOREIGN KEY (genero_id) REFERENCES generos(id),
    FOREIGN KEY (grupo_sanguineo_id) REFERENCES grupos_sanguineos(id)
);

-- Tabla: aprendices
CREATE TABLE aprendices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT NOT NULL UNIQUE,
    FOREIGN KEY (persona_id) REFERENCES personas(id)
);

-- Tabla: programas
CREATE TABLE programas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla: fichas
CREATE TABLE fichas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    programa_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    numero_ficha VARCHAR(20) NOT NULL UNIQUE,
    jornada ENUM('Mañana', 'Tarde', 'Noche') NOT NULL,
    modalidad ENUM('Presencial', 'Virtual') NOT NULL,
    estado ENUM('Activa', 'Finalizada', 'Cancelada') DEFAULT 'Activa',
    FOREIGN KEY (programa_id) REFERENCES programas(id)
);

-- Tabla: aprendiz_ficha
CREATE TABLE aprendiz_ficha (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aprendiz_id INT NOT NULL,
    ficha_id INT NOT NULL,
    fecha_inscripcion DATE NOT NULL DEFAULT (CURRENT_DATE),
    FOREIGN KEY (aprendiz_id) REFERENCES aprendices(id),
    FOREIGN KEY (ficha_id) REFERENCES fichas(id),
    UNIQUE (aprendiz_id, ficha_id)
);
