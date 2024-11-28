<?php
    class Notificacion extends Conectar
    {

        public function get_notificacion_Administradores($IdUSer)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT *
                    FROM tm_notificacion
                    WHERE fk_tipo_notificacion IN(1,4)
                    AND est=1
                    UNION
                    SELECT *
                    FROM tm_notificacion
                    WHERE fk_tipo_notificacion IN(2)
                    AND est=1
                    AND user_asignado=?
                    ORDER BY not_id Desc";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $IdUSer);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_notificacion_del_User($usu_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT * 
                FROM tm_notificacion 
                WHERE fk_tipo_notificacion in(3,5)
                AND est=1 
                AND usu_id=? ORDER BY not_id desc";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_notificacion_estado_read($not_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="UPDATE tm_notificacion SET est=2 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>