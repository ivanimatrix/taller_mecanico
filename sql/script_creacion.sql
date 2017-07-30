/*
  Script de creacion de tablas para base de datos Taller Mecanico
 */


/** tabla perfil **/
create table perfil(
  codigo_perfil tinyint not null PRIMARY KEY ,
  nombre_perfil varchar(15) not null
) default charset=utf8 AUTO_INCREMENT=1;

insert into perfil (codigo_perfil, nombre_perfil) values (1, 'ADMINISTRADOR');
insert into perfil (codigo_perfil, nombre_perfil) values (2, 'MECANICO');
insert into perfil (codigo_perfil, nombre_perfil) values (3, 'CLIENTE');


/** tabla usuario **/
create table usuario(
  id_usuario serial not null primary key,
  rut_usuario varchar(10) not null unique,
  nombres_usuario varchar(40) not null,
  apellidos_usuario varchar(40) not null,
  pass_usuario varchar(250) not null,
  perfil_usuario TINYINT not null,
  CONSTRAINT fk_perfil FOREIGN KEY (perfil_usuario) REFERENCES perfil(codigo_perfil)
) default charset=utf8 AUTO_INCREMENT=1;

/* inserción de usuario con perfil ADMINISTRADOR(password 'demo') */
insert into usuario (rut_usuario, nombres_usuario, apellidos_usuario, pass_usuario, perfil_usuario)
    values ('15489151-k','Iván','Almonacid','$6$rounds=5000$thisissaltforenc$2VmU5k2rOe4c9kDx8iYJyG./wXQLj8ZsIp0wr7N9BTvgGPcgRo7QAXnCiZItLfZj.cfqkvqB.rBcOkrb7JRbz.', 1);


/** tabla mecanico **/
create table mecanico(
  id_mecanico bigint UNSIGNED not null primary key,
  especialidad_mecanico varchar(60) default null,
  CONSTRAINT fk_mecanico FOREIGN KEY (id_mecanico) REFERENCES usuario(id_usuario)
) default charset=utf8 auto_increment=1;



/** tabla cliente **/
create table cliente(
  id_cliente bigint UNSIGNED not null primary key,
  email_cliente varchar(50) unique default null,
  fono_cliente varchar(20) default null,
  CONSTRAINT fk_cliente FOREIGN KEY (id_cliente) REFERENCES usuario(id_usuario)
) default charset=utf8 auto_increment=1;


/** tabla vehiculo **/
create table vehiculo(
  id_vehiculo serial not null primary key,
  patente_vehiculo varchar(6) not null unique,
  marca_vehiculo varchar(30) not null,
  modelo_vehiculo varchar(30) not null,
  anyo_vehiculo tinyint not null,
  fk_cliente_vehiculo bigint unsigned not null,
  CONSTRAINT fk_vehiculo FOREIGN KEY (fk_cliente_vehiculo) REFERENCES cliente(id_cliente)
) default charset=utf8 auto_increment=1;


/** tabla estados_revision **/
create table estados_revision(
  codigo_estrev tinyint not null PRIMARY KEY ,
  nombre_estrev varchar(20) not null
) default charset=utf8 auto_increment=1;

insert into estados_revision(codigo_estrev, nombre_estrev) values(1, 'EN REVISION');
insert into estados_revision(codigo_estrev, nombre_estrev) VALUES (2, 'FINALIZADO');


/** tabla revision **/
create table revision(
  id_revision serial not null primary key,
  fk_vehiculo_revision bigint UNSIGNED not null,
  estado_revision tinyint not null default 1,
  CONSTRAINT fk_estado_revision FOREIGN KEY (estado_revision) REFERENCES estados_revision(codigo_estrev)
) default charset=utf8 auto_increment=1;


/** tabla trabajo **/
create table trabajo(
  id_trabajo serial not null primary key,
  fk_revision_trabajo bigint UNSIGNED not null,
  fk_mecanico_trabajo bigint UNSIGNED not null,
  fecha_trabajo date not null,
  descripcion_trabajo text not null,
  valor_trabajo int not null default 0,
  CONSTRAINT fk_revision FOREIGN KEY (fk_revision_trabajo) REFERENCES revision(id_revision),
  CONSTRAINT fk_mecanico_trabajo FOREIGN KEY (fk_mecanico_trabajo) REFERENCES mecanico(id_mecanico)
) default charset=utf8 auto_increment=1;