create table usuarios (
    idUser int(8) not null,
    nombre varchar(200) not null,
    fechNac date not null,
    email varchar(50) not null,
    telefono int(9) not null,
    password_hash varchar(255) not null,
    status enum('pending','active','denied') default 'pending',
    rol enum('user','admin','tesorero') default 'user',
    created_at timestamp not null default current_timestamp(),
    foto_perfil varchar(255) default 'default.jpg',
    constraint PK_USUARIOS primary key (idUser)
);

INSERT INTO usuarios (
    idUser,
    nombre,
    fechNac,
    email,
    telefono,
    password_hash,
    status,
    rol
) VALUES (
    1,
    'Administrador',
    '2000-01-01',
    'admin@cooperativa.com',
    123456789,
    '$2y$10$Nh7KBpDcE4QTSLHbwWcNtum1gYffw0z9VL0YsRrhKtdl8/1fj0r6i', -- contraseña: admin1
    'active',
    'admin'
);
