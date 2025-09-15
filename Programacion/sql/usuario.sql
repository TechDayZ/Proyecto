create table usuario(
idUser int(8) not null,
nombre varchar(50) not null,
fechNac date not null,
cantFam int(10) not null,
email varchar(50) not null,
telefono int(9) not null,
constraint PK_IDUSER primary key (idUser)
);
