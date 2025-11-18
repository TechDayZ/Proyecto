CREATE TABLE constru (
    IdJorn INT(5) not null,
    idUser INT(8) not null,
    idUniCoop INT(5) not null,
    dia DATE ,
    horas INT(5) not null,
    CONSTRAINT PK_constru PRIMARY KEY (IdJorn),
    CONSTRAINT FK_constru_usuario FOREIGN KEY (idUser) REFERENCES usuario(idUser),
    CONSTRAINT FK_constru_uniCoop FOREIGN KEY (idUniCoop) REFERENCES uniCoop(idUniCoop)
);
