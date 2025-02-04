SET NAMES utf8mb4;
SET COLLATION_CONNECTION = 'utf8mb4_spanish2_ci';

ALTER TABLE tm_notificacion
    ADD COLUMN fk_tipo_notificacion INT(10),
    ADD COLUMN user_asignado INT(10);




