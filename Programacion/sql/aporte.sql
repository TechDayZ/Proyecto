CREATE TABLE aporte (
    idAport INT,
    idUser INT(8) not null,
    fech DATE not null,
    cant decimal(10,2) not null,
    metAport VARCHAR(50),
    CONSTRAINT PK_aporte PRIMARY KEY (idAport),
    CONSTRAINT FK_aporte_usuario FOREIGN KEY (idUser) REFERENCES usuario(idUser)
);
