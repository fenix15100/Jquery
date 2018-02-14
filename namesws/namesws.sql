CREATE DATABASE namesws;
USE namesws;
CREATE TABLE nombres (
	nombre varchar(50) PRIMARY KEY,
    genero enum('hombre','mujer','ambos'),
    gusta int default 0,
    nogusta int default 0
    )ENGINE=InnoDB;