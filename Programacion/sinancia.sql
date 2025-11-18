CREATE TABLE financia (
    idFin INT,
    idFinCoop INT,
    idUniHab INT,
    metPag VARCHAR(50),
    fechAport DATE,
    aportFin DECIMAL(10,2),
    CONSTRAINT PK_financia PRIMARY KEY (idFin),
    CONSTRAINT FK_financia_finanCoop FOREIGN KEY (idFinCoop) REFERENCES finanCoop(idFinCoop),
    CONSTRAINT FK_financia_uniHab FOREIGN KEY (idUniHab) REFERENCES uniHab(idUniHab)
);
