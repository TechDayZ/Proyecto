create table horasTrabajo (
    idHoras int(9) not null auto_increment,
    user_id int(8) not null,
    work_date date not null,
    horas decimal(5,2) not null,
    descripcion text,
    created_at timestamp not null default current_timestamp(),
    constraint PK_HORASTRABAJO primary key (idHoras),
    constraint UQ_USER_DATE unique (user_id, work_date),
    constraint FK_HORASTRABAJO_USUARIOS foreign key (user_id)
        references usuarios(idUser)
);
