create table constancia (
IdCont int(5) not null,
iduser int(5) not null,
idunihab int(5) not null,
constraint PK_IDCONT primary key (idCont),
constraint FK_IDUSER2 foreign key (idUser) references usuario (idUser)
);
