<?php
    require_once("../config/conexion.php");
    class Ticket extends Conectar
    {

        public function EstadoTicket($tick_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT
                    usu_asig
                    FROM tm_ticket
                    WHERE tick_id='$tick_id'";
                
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function insert_ticket($usu_id,$cat_id,$cats_id,$tick_titulo,$tick_descrip)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="INSERT INTO tm_ticket 
                    SET
                        usu_id=$usu_id,
                        cat_id=$cat_id,
                        cats_id=$cats_id,
                        tick_titulo='$tick_titulo',
                        tick_descrip='$tick_descrip',
                        fech_crea=now()";
            $sql=$conectar->prepare($sql);
            $sql->execute();


            $this->insert_notificacion_nuevo_ticket($usu_id);

            
            $sql="SELECT MAX(tick_id) AS Id
                  FROM tm_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_notificacion_nuevo_ticket($usu_id)
        {
            $datos = $this->ObtenerIdTicketAgregado();
            foreach ($datos as $row)
            {
                $idTicket = $row["Id"];
            }

            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="INSERT INTO tm_notificacion 
                    SET
                        usu_id=$usu_id,
                        not_mensaje='Nuevo Ticket',
                        tick_id=$idTicket,
                        est=1,
                        fk_tipo_notificacion=1,
                        user_asignado=0";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function ObtenerIdTicketAgregado()
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT MAX(tick_id) AS Id
                  FROM tm_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_x_usu($usu_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.fech_crea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_categoria.cat_nom,
                estatus.descrip_estatus
                FROM 
                tm_ticket
                INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN estatus ON tm_ticket.fk_estatus = estatus.id_estatus
                WHERE usu_id=$usu_id";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql=" SELECT 
            tm_ticket.tick_id,
            tm_ticket.tick_descrip,
            tm_ticket.usu_id,
            tm_ticket.cat_id,
            tm_ticket.tick_titulo,
            tm_ticket.fk_estatus,
            estatus.descrip_estatus,
            tm_ticket.fech_crea,
            tm_ticket.tick_estre,
            tm_ticket.tick_coment,
            tm_ticket.usu_asig,
            cat_usuario.nombre,
            cat_usuario.paterno,
            cat_usuario.email,
            tm_categoria.cat_nom,
            tm_subcategoria.cats_nom
            FROM 
            tm_ticket
            INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
            INNER JOIN tm_subcategoria ON tm_ticket.cats_id = tm_subcategoria.cats_id
            INNER JOIN bd_seguridad_sistemas.cat_usuario cat_usuario ON cat_usuario.enlace = tm_ticket.usu_id
            INNER JOIN estatus ON tm_ticket.fk_estatus = estatus.id_estatus
            WHERE tm_ticket.tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket()
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.fech_crea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_categoria.cat_nom,
                estatus.descrip_estatus
                FROM 
                tm_ticket
                INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN estatus ON tm_ticket.fk_estatus = estatus.id_estatus";

                $sql=$conectar->prepare($sql);
                $sql->execute();
                return $resultado=$sql->fetchAll();
        }

        public function listar_ticketdetalle_x_ticket($tick_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="  SELECT * 
                    FROM td_ticketdetalle
                    WHERE tick_id=?
                    ORDER BY tickd_id DESC";
                
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function insert_ticketdetalle($tick_id,$tickd_descrip, $RolUser, $IdUSer)
        {                                    
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
              
            /* TODO:Obtener usuario asignado del tick_id */
            $ticket = new Ticket();
            $datos = $ticket->listar_ticket_x_id($tick_id);
            foreach ($datos as $row)
            {
                $usu_asig = $row["usu_asig"];
                $usu_crea = $row["usu_id"];
            }

             /* Si Rol es 4 = Usuario insertar alerta para usuario soporte */
             if ($RolUser==4)
             {
                $sql0="INSERT INTO tm_notificacion 
                        SET 
                            usu_id = '$IdUSer',
                            not_mensaje = 'Tiene una nueva respuesta del usuario con nro de ticket : ',
                            tick_id = '$tick_id',
                            est=1,
                            fk_tipo_notificacion=4,
                            user_asignado='$usu_asig '";

                $sql0=$conectar->prepare($sql0);
                $sql0->execute();
            }else{
                /* TODO: Guardar Notificacion de nuevo Comentario */
                $sql0="INSERT INTO tm_notificacion 
                SET 
                    usu_id = '$usu_crea',
                    not_mensaje = 'Tiene una nueva respuesta de soporte del ticket Nro : ',
                    tick_id = '$tick_id',
                    est=1,
                    fk_tipo_notificacion=5,
                    user_asignado='$usu_asig '";

                $sql0=$conectar->prepare($sql0);
                $sql0->execute();
            }

              $sql="INSERT INTO 
                        td_ticketdetalle   
                            SET 
                                tick_id =$tick_id,
                                usu_id=$IdUSer,
                                tickd_descrip='$tickd_descrip',
                                fech_crea=now(),
                                descrip_estatus=1"; 
              //$sql="INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
           // $sql->bindValue(1, $tick_id);
            //$sql->bindValue(2, $usu_id);
            //$sql->bindValue(3, $tickd_descrip); 
            $sql->execute();
            //Devuelve el ulitmo ID (Identty) ingresado
            $sql1="select last_insert_id() as 'tickd_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);

            $sql0="INSERT INTO tm_notificacion (not_id,usu_id,not_mensaje,tick_id,est) VALUES (null,?,'Tiene una nueva respuesta del ticket Nro : ',?,2)";
            $sql0=$conectar->prepare($sql1);
            $sql0->bindValue(1, $usu_asig);
            $sql0->bindValue(2, $tick_id);
            $sql0->execute();
            //Devuelve el ulitmo ID (Identty) ingresado
            $sql1="select last_insert_id() as 'tickd_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function insert_ticketdetalle_cerrar($tick_id,$usu_id){ 
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
                $sql=" call sp_i_ticketdetalle_01 (?,?)"; 
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle_reabrir($tick_id,$usu_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
                $sql="	INSERT INTO td_ticketdetalle 
                    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,descrip_estatus) 
                    VALUES 
                    (NULL,?,?,'Ticket Re-Abierto...',now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket($tick_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    fk_estatus = 2,
                    fech_cierre = now()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function reabrir_ticket($tick_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    fk_estatus = '1'
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_asignacion($tick_id,$usu_asig,$UserAsigna)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    usu_asig = ?,
                    fech_asig = now()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tick_id);
            $sql->execute();

            /* TODO: Guardar Notificacion en la tabla */
            $sql1="INSERT INTO tm_notificacion
                    SET
                         usu_id= '$UserAsigna',
                         not_mensaje='Se le ha asignado el ticket Nro :',
                         tick_id='$tick_id', 
                         est=1,
                         fk_tipo_notificacion=2, 
                         user_asignado= '$usu_asig' ";

            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
 
             return $resultado=$sql->fetchAll();
        }

        public function get_ticket_grafico(){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.fk_estatus = 1
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function insert_encuesta($tick_id,$tick_estre,$tick_coment){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estre = $tick_estre,
                    tick_coment =' $tick_coment'
                where
                    tick_id = $tick_id";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public FUNCTION filtrar_ticket($cat_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $SQL="SELECT
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.cat_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.fech_crea,
                    tm_ticket.usu_asig,
                    tm_ticket.fech_asig, 
                    tm_categoria.cat_nom,
                    estatus.descrip_estatus
                   FROM tm_ticket
                   INNER JOIN tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id                                    
                   INNER JOIN estatus ON tm_ticket.fk_estatus = estatus.id_estatus
                   WHERE tm_ticket.cat_id = ?";

            $SQL=$conectar->PREPARE($SQL);
            $SQL->bindValue(1, $cat_id);
            $SQL->EXECUTE();
            RETURN $resultado=$SQL->fetchAll();
        }

        public function get_calendar_all(){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="  SELECT 
                    tm_ticket.tick_id AS id,
                    CONCAT(cat_usuario.nombre,' ',cat_usuario.paterno) AS title,
                    tm_ticket.fech_crea AS start,
                    CASE
                        WHEN tm_ticket.fk_estatus = 1 THEN 'green'
                        WHEN tm_ticket.fk_estatus = 2 THEN 'red'
                        ELSE 'white'
                    END AS color
                    FROM
                    tm_ticket
                    INNER JOIN bd_seguridad_sistemas.cat_usuario ON tm_ticket.usu_id = cat_usuario.enlace";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_calendar_usu($usu_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT 
                    tm_ticket.tick_id as id,
                    CONCAT(cat_usuario.nombre,' ',cat_usuario.paterno) AS title,
                    tm_ticket.fech_crea as start,
                    CASE
                        WHEN tm_ticket.fk_estatus = 1 THEN '#C2FFC7'
                        WHEN tm_ticket.fk_estatus = 2 THEN 'B03052'
                        ELSE 'white'
                    END as color
                    FROM
                    tm_ticket
                    INNER JOIN bd_seguridad_sistemas.cat_usuario ON tm_ticket.usu_id = cat_usuario.enlace
                    WHERE usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>