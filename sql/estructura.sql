-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS nova_salud;
USE nova_salud;

-- Tabla de productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    stock INT NOT NULL DEFAULT 0,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(50),
    fecha_vencimiento DATE
);

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla de ventas
CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT,
    cantidad INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Tabla de tickets (atención al cliente)
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    mensaje TEXT NOT NULL,
    respuesta TEXT,
    estado ENUM('pendiente', 'en proceso', 'resuelto') DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

-- Usuario administrador (opcional)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'vendedor') DEFAULT 'admin'
);

