create table tesorero (
idTesorero int(5) not null,
idUser int(8) not null,
constraint PK_IDTESORERO primary key (IdTesorero),
constraint FK_IDUSER foreign key (idUser) references usuario (idUser)
);
