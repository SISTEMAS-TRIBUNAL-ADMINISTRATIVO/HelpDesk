SET NAMES utf8mb4;
SET COLLATION_CONNECTION = 'utf8mb4_spanish2_ci';

ALTER TABLE tm_ticket
    ADD COLUMN nombre_valido VARCHAR(250),
    ADD COLUMN area_crea VARCHAR(250),
    ADD COLUMN se_da_solucion VARCHAR(10),
    ADD COLUMN diagnostico TEXT,
    ADD COLUMN observaciones TEXT,
    ADD COLUMN cargo_valido VARCHAR(250),
    ADD COLUMN nombre_realizo VARCHAR(250),
    ADD COLUMN nombre_conformidad VARCHAR(250),
    ADD COLUMN cargo_conformidad VARCHAR(250),
    ADD COLUMN cargo_realizo VARCHAR(250);