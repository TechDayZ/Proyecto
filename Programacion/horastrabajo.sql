CREATE TABLE horastrabajo (
  idHoras INT(9) PRIMARY KEY auto_increment,
  user_id INT NOT NULL,
  work_date DATE NOT NULL,
  horas DECIMAL(5,2) NOT NULL,
  descripcion TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT unique_user_date UNIQUE (user_id, work_date),
  FOREIGN KEY (user_id) REFERENCES usuarios(idUser)
) ;
