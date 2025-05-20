-- --------------------------------------------------
-- Base de datos: trady_bd
-- --------------------------------------------------

CREATE DATABASE IF NOT EXISTS trady_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE trady_bd;

-- --------------------------------------------------
-- 1. Tabla suscripcion_comercios
-- --------------------------------------------------
CREATE TABLE suscripcion_comercios (
  id_suscripcion INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  precio FLOAT NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 2. Tabla suscripcion_usuarios
-- --------------------------------------------------
CREATE TABLE suscripcion_usuarios (
  id_suscripcion INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  precio FLOAT NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 3. Tabla usuarios
-- --------------------------------------------------
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL UNIQUE,
  nombre VARCHAR(50) NOT NULL,
  fecha_nac DATE,
  password VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_suscripcion INT,
  puntos INT DEFAULT 0,
  estado INT DEFAULT 1,
  telefono VARCHAR(20),
  metodoPago VARCHAR(255),
  qrs_escaneados INT DEFAULT 0,
  CONSTRAINT fk_usuario_suscripcion
    FOREIGN KEY (id_suscripcion) REFERENCES suscripcion_usuarios(id_suscripcion)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 4. Tabla comercios
-- --------------------------------------------------
CREATE TABLE comercios (
  id_comercios INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  cif VARCHAR(100),
  descripcion VARCHAR(100),
  tipo VARCHAR(50),
  direccion VARCHAR(100),
  telefono VARCHAR(100),
  ruta varchar (100),
  email VARCHAR(100),
  imagen VARCHAR(200),
  id_suscripcion INT,
  fecha_alta TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  latitud DECIMAL(10,7),
  longitud DECIMAL(10,7),
  estado INT DEFAULT 0,
  metodoPago VARCHAR(255),
  CONSTRAINT fk_comercio_suscripcion
    FOREIGN KEY (id_suscripcion) REFERENCES suscripcion_comercios(id_suscripcion)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 5. Tabla sitiosInteres
-- --------------------------------------------------
CREATE TABLE sitiosInteres (
  id_sitio INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(100),
  tipo VARCHAR(50),
  direccion VARCHAR(100),
  telefono VARCHAR(100),
  email VARCHAR(255),
  ruta varchar (100),
  imagen VARCHAR(200),
  fecha_alta TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  latitud DECIMAL(10,7),
  longitud DECIMAL(10,7),
  estado INT DEFAULT 1
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 6. Tabla administradores
-- --------------------------------------------------
CREATE TABLE administradores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellido VARCHAR(50),
  rol INT NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 7. Tabla recompensas
-- --------------------------------------------------
CREATE TABLE recompensas (
  id_recompensas INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  puntos INT NOT NULL,
  fecha_alta  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  estado INT DEFAULT 0,
  qrs_escanear INT NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 8. Tabla qr_codigos
-- --------------------------------------------------
CREATE TABLE qr_codigos (
  id_qr INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255),
  tipo VARCHAR(50),
  qr VARCHAR(200),
  fecha_alta  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  identificador_qr VARCHAR(255),
  id_comercio INT,
  puntos INT DEFAULT 0,
  id_sitio INT,
  CONSTRAINT fk_qr_comercio
    FOREIGN KEY (id_comercio) REFERENCES comercios(id_comercios),
  CONSTRAINT fk_qr_sitio
    FOREIGN KEY (id_sitio) REFERENCES sitiosInteres(id_sitio)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 9. Tabla usuario_actividad
-- --------------------------------------------------
CREATE TABLE usuario_actividad (
  id_actividad INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT,
  id_sitio INT,
  id_comercio INT,
  fecha_actividad DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_act_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_act_sitio
    FOREIGN KEY (id_sitio) REFERENCES sitiosInteres(id_sitio),
  CONSTRAINT fk_act_comercio
    FOREIGN KEY (id_comercio) REFERENCES comercios(id_comercios)
) ENGINE=InnoDB;
