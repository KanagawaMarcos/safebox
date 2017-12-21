CREATE TABLE varys (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
  tipo varchar(255) NOT NULL,
  valor float NOT NULL,
  agente varchar(255) NOT NULL,
  origem varchar(255) DEFAULT NULL,
  destino varchar(255) DEFAULT NULL,
  dataAcao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

