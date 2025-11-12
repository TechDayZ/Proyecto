CREATE TABLE unidades (
    idUnidad INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT DEFAULT NULL, -- el usuario al que se asigna
    numero_unidad VARCHAR(50) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    integrantes INT DEFAULT 1,
    estado ENUM('disponible', 'asignada', 'ocupada') DEFAULT 'disponible',
    fecha_asignacion TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(idUser)
);


INSERT INTO unidades (numero_unidad, direccion, integrantes, estado)
VALUES
('A1', 'Av. Principal 123', 3, 'disponible'),
('B2', 'Calle Secundaria 456', 2, 'disponible'),
('C3', 'Boulevard Central 789', 4, 'disponible');