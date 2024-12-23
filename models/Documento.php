<?php
    class Documento extends Conectar{
        public function insert_documento($tick_id,$doc_nom){
            $conectar= parent::conexion("helpdesk");
            /* consulta sql */
            $sql="INSERT INTO td_documento (tick_id,doc_nom,fech_crea,est) VALUES (?,?,now(),1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function get_documento_x_ticket($tick_id){
            $conectar= parent::conexion("helpdesk");
            /* consulta sql */
            $sql="SELECT * FROM td_documento WHERE tick_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }

        public function insert_documento_detalle($tickd_id,$det_nom){ 
            $conectar= parent::conexion("helpdesk");
            /* consulta sql */
            $sql="INSERT INTO td_documento_detalle (det_id,tickd_id,det_nom,est) VALUES (null,?,?,1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tickd_id);
            $sql->bindParam(2,$det_nom);
            $sql->execute();
        }

        public function get_documento_detalle_x_ticketd($tickd_id){
            $conectar= parent::conexion("helpdesk");
            /* consulta sql */
            $sql="SELECT * FROM td_documento_detalle WHERE tickd_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tickd_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }
?>