-- --------------------------------------------------
-- Base de datos: trady
-- --------------------------------------------------

CREATE DATABASE IF NOT EXISTS trady_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE trady;

-- --------------------------------------------------
-- 1. Tabla suscripcion_comercios
-- --------------------------------------------------
CREATE TABLE suscripcion_comercios (
  id_suscripcion   INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(50)     NOT NULL,
  precio           DECIMAL(10,2)   NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 2. Tabla suscripcion_usuarios
-- --------------------------------------------------
CREATE TABLE suscripcion_usuarios (
  id_suscripcion   INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(50)     NOT NULL,
  precio           DECIMAL(10,2)   NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 3. Tabla usuarios
-- --------------------------------------------------
CREATE TABLE usuarios (
  id_usuario       INT             AUTO_INCREMENT PRIMARY KEY,
  email            VARCHAR(50)     NOT NULL UNIQUE,
  alias            VARCHAR(50),
  nombre           VARCHAR(50)     NOT NULL,
  apellido         VARCHAR(50),
  fecha_nac        DATE,
  password         VARCHAR(255)    NOT NULL,
  fecha_registro   DATE            NOT NULL DEFAULT CURRENT_DATE,
  id_suscripcion   INT,
  puntos           INT             NOT NULL DEFAULT 0,
  estado           TINYINT(1)      NOT NULL DEFAULT 1,
  CONSTRAINT fk_usuario_suscripcion
    FOREIGN KEY (id_suscripcion) REFERENCES suscripcion_usuarios(id_suscripcion)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 4. Tabla qr_codigos
-- --------------------------------------------------
CREATE TABLE qr_codigos (
  id_qr            INT             AUTO_INCREMENT PRIMARY KEY,
  tipo             VARCHAR(50),
  qr               VARCHAR(100),
  identificador_qr VARCHAR(255)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 5. Tabla comercios
-- --------------------------------------------------
CREATE TABLE comercios (
  id_comercios     INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(100)    NOT NULL,
  cif              VARCHAR(100),
  descripcion      VARCHAR(100),
  tipo             VARCHAR(50),
  direccion        VARCHAR(100),
  telefono         VARCHAR(100),
  email            VARCHAR(100),
  id_suscripcion   INT,
  fecha_alta       DATE            NOT NULL DEFAULT CURRENT_DATE,
  id_qr            INT,
  latitud          FLOAT,
  longitud         FLOAT,
  estado           TINYINT(1)      NOT NULL DEFAULT 1,
  CONSTRAINT fk_comercio_suscripcion
    FOREIGN KEY (id_suscripcion) REFERENCES suscripcion_comercios(id_suscripcion),
  CONSTRAINT fk_comercio_qr
    FOREIGN KEY (id_qr) REFERENCES qr_codigos(id_qr)
) ENGINE=InnoDB;




-- --------------------------------------------------
-- 6. Tabla sitiosInteres
-- --------------------------------------------------
CREATE TABLE sitiosInteres (
  id_sitio         INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(100)    NOT NULL,
  descripcion      VARCHAR(100),
  tipo             VARCHAR(50),
  direccion        VARCHAR(100),
  telefono         VARCHAR(100),
  email            VARCHAR(100),
  fecha_alta       DATE            NOT NULL DEFAULT CURRENT_DATE,
  latitud          FLOAT,
  longitud         FLOAT,
  estado           TINYINT(1)      NOT NULL DEFAULT 1,
  id_qr            INT,
  CONSTRAINT fk_sitio_qr
    FOREIGN KEY (id_qr) REFERENCES qr_codigos(id_qr)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 7. Tabla recompensas
-- --------------------------------------------------
CREATE TABLE recompensas (
  id_recompensas   INT             AUTO_INCREMENT PRIMARY KEY,
  id_comercio      INT             NOT NULL,
  nombre           VARCHAR(255)    NOT NULL,
  puntos           INT             NOT NULL,
  fecha_alta       DATE            NOT NULL DEFAULT CURRENT_DATE,
  estado           TINYINT(1)      NOT NULL DEFAULT 1,
  CONSTRAINT fk_recompensa_comercio
    FOREIGN KEY (id_comercio) REFERENCES comercios(id_comercios)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 8. Tabla rutas
-- --------------------------------------------------
CREATE TABLE rutas (
  id_ruta          INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(50)     NOT NULL,
  descripcion      VARCHAR(255),
  puntos           INT             NOT NULL,
  estado           TINYINT(1)      NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 9. Tabla rutas_puntos
-- --------------------------------------------------
CREATE TABLE rutas_puntos (
  id_ruta_puntos   INT             AUTO_INCREMENT PRIMARY KEY,
  id_ruta          INT             NOT NULL,
  id_comercio      INT,
  id_sitios        INT,
  orden            INT             NOT NULL,
  CONSTRAINT fk_rutapunto_ruta
    FOREIGN KEY (id_ruta) REFERENCES rutas(id_ruta),
  CONSTRAINT fk_rutapunto_comercio
    FOREIGN KEY (id_comercio) REFERENCES comercios(id_comercios),
  CONSTRAINT fk_rutapunto_sitio
    FOREIGN KEY (id_sitios) REFERENCES sitiosInteres(id_sitio)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 10. Tabla cuestionarios
-- --------------------------------------------------
CREATE TABLE cuestionarios (
  id_cuestionario  INT             AUTO_INCREMENT PRIMARY KEY,
  pregunta         VARCHAR(255)    NOT NULL,
  respuesta        VARCHAR(255)    NOT NULL,
  fecha_alta       DATE            NOT NULL DEFAULT CURRENT_DATE,
  estado           TINYINT(1)      NOT NULL DEFAULT 1,
  id_comercio      INT,
  id_sitio         INT,
  puntos           INT             NOT NULL,
  CONSTRAINT fk_cuestionario_comercio
    FOREIGN KEY (id_comercio) REFERENCES comercios(id_comercios),
  CONSTRAINT fk_cuestionario_sitio
    FOREIGN KEY (id_sitio) REFERENCES sitiosInteres(id_sitio)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 11. Tabla usuarios_desafios
-- --------------------------------------------------
CREATE TABLE usuarios_desafios (
  id_desafios      INT             AUTO_INCREMENT PRIMARY KEY,
  id_ruta          INT             NOT NULL,
  id_usuario       INT             NOT NULL,
  fecha_inicio     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_fin        DATETIME,
  estado           VARCHAR(25)     NOT NULL,
  CONSTRAINT fk_desafio_ruta
    FOREIGN KEY (id_ruta) REFERENCES rutas(id_ruta),
  CONSTRAINT fk_desafio_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 12. Tabla usuario_Actividad
-- --------------------------------------------------
CREATE TABLE usuario_Actividad (
  id_actividad     INT             AUTO_INCREMENT PRIMARY KEY,
  id_usuario       INT             NOT NULL,
  id_desafios      INT,
  id_recompensa    INT,
  id_cuestionario  INT,
  estado           VARCHAR(25),
  puntos_actividad INT             NOT NULL,
  fecha_act        DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_actividad_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_actividad_desafio
    FOREIGN KEY (id_desafios) REFERENCES usuarios_desafios(id_desafios),
  CONSTRAINT fk_actividad_recompensa
    FOREIGN KEY (id_recompensa) REFERENCES recompensas(id_recompensas),
  CONSTRAINT fk_actividad_cuestionario
    FOREIGN KEY (id_cuestionario) REFERENCES cuestionarios(id_cuestionario)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 13. Tabla resenas
-- --------------------------------------------------
CREATE TABLE resenas (
  id_resena        INT             AUTO_INCREMENT PRIMARY KEY,
  descripcion      VARCHAR(255),
  id_ruta          INT,
  id_usuario       INT,
  CONSTRAINT fk_resena_ruta
    FOREIGN KEY (id_ruta) REFERENCES rutas(id_ruta),
  CONSTRAINT fk_resena_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 14. Tabla administradores
-- --------------------------------------------------
CREATE TABLE administradores (
  id               INT             AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(50)     NOT NULL,
  apellido         VARCHAR(50),
  rol              INT             NOT NULL,
  email            VARCHAR(100)    NOT NULL UNIQUE,
  password         VARCHAR(255)    NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------
-- 15. Tabla pagos
-- --------------------------------------------------
CREATE TABLE pagos (
  id_pagos         INT             AUTO_INCREMENT PRIMARY KEY,
  id_comercios     INT,
  id_usuarios      INT,
  fecha_pago       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  monto            DECIMAL(10,2)   NOT NULL,
  metodo           VARCHAR(100),
  estado           VARCHAR(50),
  CONSTRAINT fk_pagos_comercio
    FOREIGN KEY (id_comercios) REFERENCES comercios(id_comercios),
  CONSTRAINT fk_pagos_usuario
    FOREIGN KEY (id_usuarios) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;
