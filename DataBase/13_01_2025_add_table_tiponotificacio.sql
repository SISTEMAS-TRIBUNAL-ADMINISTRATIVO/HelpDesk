SET NAMES utf8mb4;
SET COLLATION_CONNECTION = 'utf8mb4_spanish2_ci';

CREATE TABLE cat_tipo_notificacion
(
    id_tipo_notificacion int(10) not null AUTO_INCREMENT,
    nombre_notificacion varchar(200) not null,
    PRIMARY KEY (id_tipo_notificacion)
);


INSERT INTO cat_tipo_notificacion
    (nombre_notificacion)
VALUES ('Nuevo Ticket'), 
       ('Ticket Asignado'), 
       ('Soporte técnico da seguimiento'), 
       ('usuario responde a ticket'),
       ('ticket Cerrado');
