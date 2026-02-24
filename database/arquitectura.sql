DROP DATABASE IF EXISTS luthier_forge;
CREATE DATABASE luthier_forge;
USE luthier_forge;

CREATE TABLE Rol (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);

CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    edad INT,
    email VARCHAR(150) UNIQUE NOT NULL,
    contraseña_hash VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- Piezas base disponibles en tienda
CREATE TABLE Forma (
    id_forma INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    color_nombre VARCHAR(100),
    codigo_hex VARCHAR(7),
    imagen VARCHAR(255),
    referencia_glb VARCHAR(255),
    precio_base DECIMAL(10,2) DEFAULT 0.00,
    stock INT DEFAULT 0
);

CREATE TABLE Mastil (
    id_mastil INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    referencia_glb VARCHAR(255),
    precio DECIMAL(10,2) DEFAULT 0.00,
    calidad VARCHAR(100),
    material VARCHAR(100),
    stock INT DEFAULT 0
);

CREATE TABLE Pastilla (
    id_pastilla INT AUTO_INCREMENT PRIMARY KEY,
    id_forma INT NOT NULL,
    tipo ENUM('humbucker','singlecoil') NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    referencia_glb VARCHAR(255),
    precio DECIMAL(10,2) DEFAULT 0.00,
    calidad VARCHAR(100),
    stock INT DEFAULT 0,
    FOREIGN KEY (id_forma) REFERENCES Forma(id_forma)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- Guitarras disponibles como combinación base
CREATE TABLE Guitarra_Forma (
    id_guitarra_forma INT AUTO_INCREMENT PRIMARY KEY,
    id_forma INT NOT NULL,
    id_mastil INT NOT NULL,
    id_pastilla INT NOT NULL,
    precio_total DECIMAL(10,2),
    stock INT DEFAULT 0,
    FOREIGN KEY (id_forma) REFERENCES Forma(id_forma)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_mastil) REFERENCES Mastil(id_mastil)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_pastilla) REFERENCES Pastilla(id_pastilla)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- Guitarras personalizadas guardadas por usuario
CREATE TABLE Guitarra_Usuario (
    id_guitarra_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_forma INT NOT NULL,
    id_mastil INT NOT NULL,
    id_pastilla INT NOT NULL,
    precio_total DECIMAL(10,2),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_forma) REFERENCES Forma(id_forma)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_mastil) REFERENCES Mastil(id_mastil)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_pastilla) REFERENCES Pastilla(id_pastilla)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE Pieza_Suelta (
    id_pieza INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) DEFAULT 0.00,
    imagen VARCHAR(255),
    referencia_glb VARCHAR(255),
    stock INT DEFAULT 0,
    id_distribuidor INT,
    aprobado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_distribuidor) REFERENCES Usuario(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- ======================
-- CARRITO
-- ======================

CREATE TABLE Carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE Carrito_Item (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_carrito INT NOT NULL,
    tipo_producto ENUM('forma','mastil','pastilla','guitarra_forma','pieza_suelta') NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT DEFAULT 1,
    FOREIGN KEY (id_carrito) REFERENCES Carrito(id_carrito)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- ======================
-- HISTORIAL / PEDIDOS
-- ======================

CREATE TABLE Pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE Pedido_Item (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    tipo_producto ENUM('forma','mastil','pastilla','guitarra_forma','pieza_suelta') NOT NULL,
    id_producto INT NOT NULL,
    precio_unitario DECIMAL(10,2),
    cantidad INT DEFAULT 1,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);