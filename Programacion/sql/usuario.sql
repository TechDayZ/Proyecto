CREATE TABLE  usuarios (
  idUser INT(8) PRIMARY KEY,
  nombre VARCHAR(200) NOT NULL,
  fechNac date not null,
  email varchar(50) not null,
  telefono int(9) not null,
  password_hash VARCHAR(255) NOT NULL,
  status ENUM('pending','active','denied') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ;