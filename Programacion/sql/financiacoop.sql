CREATE TABLE finanCoop (
    idFinCoop INT not null,
    idUniCoop INT not null,
    idTesorero INT not null,
    fechFinanC DATE,
    CONSTRAINT PK_finanCoop PRIMARY KEY (idFinCoop),
    CONSTRAINT FK_finanCoop_uniCoop FOREIGN KEY (idUniCoop) REFERENCES uniCoop(idUniCoop),
    CONSTRAINT FK_finanCoop_tesorero FOREIGN KEY (idTesorero) REFERENCES tesorero(idTesorero)
    );
