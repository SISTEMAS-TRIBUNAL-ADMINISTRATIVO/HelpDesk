<?php
    class Usuario extends Conectar{

        public function login(){
            $conectar=parent::conexion("helpdesk");
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"]; 
                $pass_encrip = md5($correo).hash('sha256', $pass);
                if(empty($correo) or empty($pass)){
                    header("Location:".Conectar::ruta()."index.php?m=2");
                    exit();//
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo = ? AND usu_pass = ? AND  est = 1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass_encrip);
                   // $stmt->bindValue(3, $rol);//
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if(is_array($resultado) && count($resultado) > 0){
                        $_SESSION["usu_id"] = $resultado["usu_id"];
                        $_SESSION["usu_nom"] = $resultado["usu_nom"];
                        $_SESSION["usu_ape"] = $resultado["usu_ape"];
                        $_SESSION["rol_id"] = $resultado["rol_id"];
                        $_SESSION["usu_correo"] = $resultado["usu_correo"];
                        if ($_SESSION["rol_id"] == 4){ //Usuario
                            header("Location:".Conectar::ruta()."/view/Home/");
                            exit();
                        } else if ($_SESSION["rol_id"] == 3){ //Administrador
                            header("Location:".Conectar::ruta()."/view/Home/");
                            exit();
                        }
                    } else {
                        header("Location:".Conectar::ruta()."index.php?m=2");
                        exit();
                    }
                }
            }
        }
       
        public function Autorizacion($Enlace)
        {
            $conectar = parent::conexion("seguridad");
            parent::set_names();

            //$PassEncryp = md5($Email) . hash('sha256', $Password);

            $sql = "SELECT 
                id_usuario,
                nombre,
                paterno,
                materno,
                email,
                siglas,
                PASSWORD,
                token,
                Enlace,
                id_rol,
                rol,
                descripcion_rol,
                id_sistema,
                sistema,
                alias,
                IdPadreSistema,
                url_declaracion
            FROM bd_seguridad_sistemas.cat_usuario
            INNER JOIN bd_seguridad_sistemas.pri_usuario_rol_sistema ON (pri_usuario_rol_sistema.fk_usuario = cat_usuario.id_usuario AND pri_usuario_rol_sistema.activo = 1)
            INNER JOIN bd_seguridad_sistemas.cat_sistema ON (pri_usuario_rol_sistema.fk_sistema = cat_sistema.id_sistema)
            INNER JOIN bd_seguridad_sistemas.cat_rol ON (pri_usuario_rol_sistema.fk_rol = cat_rol.id_rol)
            WHERE Enlace=?
            AND cat_usuario.activo = 1
            AND cat_sistema.id_sistema = 2";


            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $Enlace);
            $stmt->execute();
            $Resultado = $stmt->fetchAll();
            return $Resultado;
        }

        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="INSERT INTO tm_usuario (usu_id, usu_nom, usu_ape, usu_correo, usu_pass, rol_id, fech_crea, fech_modi, fech_elim, est) VALUES (NULL,?,?,?,MD5(?),?,now(), NULL, NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
       
        public function update_usuario($usu_id,$usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="UPDATE tm_usuario set
                usu_nom = ?,
                usu_ape = ?,
                usu_correo = ?,
                usu_pass = ?,
                rol_id = ?,
                fech_modi = now()
                WHERE
                usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_pass);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_usuario($usu_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="UPDATE tm_usuario SET est='0', fech_elim =now() where usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario(){  //Funcion sp Evita inyecciones 
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="call sp_l_usuario_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_usuario_x_id($usu_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();

            $sql="SELECT 
                id_usuario,
                nombre,
                paterno,
                materno,
                email,
                siglas,
                PASSWORD,
                token,
                Enlace,
                id_rol,
                rol,
                descripcion_rol,
                id_sistema,
                sistema,
                alias,
                IdPadreSistema,
                url_declaracion
            FROM bd_seguridad_sistemas.cat_usuario
            INNER JOIN bd_seguridad_sistemas.pri_usuario_rol_sistema ON (pri_usuario_rol_sistema.fk_usuario = cat_usuario.id_usuario AND pri_usuario_rol_sistema.activo = 1)
            INNER JOIN bd_seguridad_sistemas.cat_sistema ON (pri_usuario_rol_sistema.fk_sistema = cat_sistema.id_sistema)
            INNER JOIN bd_seguridad_sistemas.cat_rol ON (pri_usuario_rol_sistema.fk_rol = cat_rol.id_rol)
            WHERE Enlace=?
            AND cat_usuario.activo = 1
            AND cat_sistema.id_sistema = 2
            LIMIT 1";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function comboUserSoporte()
        {
            $conectar= parent::conexion("seguridad");
            parent::set_names();

            $sql="SELECT 
                id_usuario,
                nombre,
                paterno,
                materno,
                email,
                siglas,
                PASSWORD,
                token,
                Enlace,
                id_rol,
                rol,
                descripcion_rol,
                id_sistema,
                sistema,
                alias,
                IdPadreSistema,
                url_declaracion
            FROM bd_seguridad_sistemas.cat_usuario
            INNER JOIN bd_seguridad_sistemas.pri_usuario_rol_sistema ON (pri_usuario_rol_sistema.fk_usuario = cat_usuario.id_usuario AND pri_usuario_rol_sistema.activo = 1)
            INNER JOIN bd_seguridad_sistemas.cat_sistema ON (pri_usuario_rol_sistema.fk_sistema = cat_sistema.id_sistema)
            INNER JOIN bd_seguridad_sistemas.cat_rol ON (pri_usuario_rol_sistema.fk_rol = cat_rol.id_rol)
            AND cat_usuario.activo = 1
            AND cat_sistema.id_sistema = 2
            AND cat_rol.id_rol=3";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


        public function get_ticket_todos(){ //Total de tickets administrador
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket"; 
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_total_x_id($usu_id){ //Total de tickets Usaurio
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id =?"; 
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_abiertotodos(){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where fk_estatus=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and fk_estatus=1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalcerradotodos(){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where fk_estatus=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and fk_estatus=2";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_grafico($usu_id)
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE   tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_Todos_grafico()
        {
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexion("helpdesk");
            parent::set_names();
            $pass_encrip = md5($_SESSION["usu_correo"]).hash('sha256', $usu_pass);
            $sql="UPDATE tm_usuario
                SET
                    usu_pass = '$pass_encrip'
                WHERE
                    usu_id = $usu_id";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


    }
?>
