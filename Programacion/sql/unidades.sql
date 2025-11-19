create table unidades (
    idUnidad INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT DEFAULT NULL,
    numero_unidad VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    cuartos INT NOT NULL,
    banos INT NOT NULL,
    metros INT NOT NULL,
    estado ENUM('disponible', 'asignada', 'ocupada') DEFAULT 'disponible',
    fecha_asignacion TIMESTAMP NULL DEFAULT NULL,
    constraint FK_UNIDADES_USUARIO foreign key (id_usuario)
        references usuarios(idUser)
);



INSERT INTO unidades (numero_unidad, direccion, descripcion, cuartos, banos, metros, estado)
VALUES
('A1', 'Av. Principal 123', 'Unidad en excelente estado, primer piso.', 3, 1, 68, 'disponible'),
('B2', 'Calle Secundaria 456', 'Cercana al parque y comercios.', 2, 1, 52, 'disponible'),
('C3', 'Boulevard Central 789', 'Amplia, orientación norte.', 4, 2, 89, 'disponible');
