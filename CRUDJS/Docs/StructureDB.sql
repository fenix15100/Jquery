create table migration_versions
(
	version varchar(255) not null
		primary key
)
;

create table paises
(
	id int not null auto_increment
		primary key,
	pais varchar(120) not null,
	iso varchar(2) not null
)
;

create table tipos
(
	id int not null auto_increment
		primary key,
	tipo enum('Hibrida_Mixta', 'Hibrida_Indica', 'Hibrida_Sativa', 'Sativa', 'Indica', 'Ruderalis', 'Legendaria') null
)
;

create table variedades
(
	id int not null auto_increment
		primary key,
	id_tipo int null,
	id_pais int null,
	nombre varchar(120) not null,
	tiempo_floracion int null,
	interior tinyint(1) not null,
	exterior tinyint(1) not null,
	thc decimal(10,2) null,
	cbd decimal(10,2) null,
	genetica varchar(120) null,
	description longtext null,
	file varchar(150) null,
	constraint FK_8AD7940FFB0D0145
		foreign key (id_tipo) references cannabis.tipos (id)
			on delete cascade,
	constraint FK_8AD7940FF57D32FD
		foreign key (id_pais) references cannabis.paises (id)
			on delete cascade
)
;

create index IDX_8AD7940FF57D32FD
	on variedades (id_pais)
;

create index IDX_8AD7940FFB0D0145
	on variedades (id_tipo)
;

