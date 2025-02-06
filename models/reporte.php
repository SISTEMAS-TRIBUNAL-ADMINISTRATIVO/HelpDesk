<?php
    class Reporte extends Conectar
    {

        public function get_reporte_ticket($idTicket)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT
                    T.cat_id,
                    t.area_crea,
                    DATE_FORMAT(T.fech_crea, '%W %d de %M de %Y') AS fecha_crea,
                    TIME(T.fech_crea) AS hora,
                    C.cat_nom,
                    T.se_da_solucion,
                    T.tick_descrip,
                    T.diagnostico,
                    T.observaciones,
                    T.nombre_realizo,
                    T.cargo_realizo,
                    T.nombre_valido,
                    T.cargo_valido,
                    T.nombre_conformidad,
                    T.cargo_conformidad
                FROM tm_ticket T
                INNER JOIN tm_categoria C ON C.cat_id = T.cat_id
                WHERE tick_id=?";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idTicket);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        
        public function get_general_reporte()
        {
            $conectar= parent::conexion("siai");
            parent::set_names();
            $sql="SELECT 
                    leyenda,
                    encabezado,
                    pie_pagina
                FROM cat_generales";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_setear_fecha()
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SET lc_time_names =es_MX";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>