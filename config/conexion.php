<?php
    session_start();

    class Conectar
{
    protected $dbh;
    protected $configMysql = "Local";
    
    
    protected function Conexion($db)
    {
        try {
            if ($this->configMysql == "Local") 
            {
                switch ($db) 
                {

                }
            } else if ($this->configMysql == "Production") 
            {
                switch ($db) 
                {
                    case "seguridad":
                        $this->dbh = new PDO("mysql:host=192.168.1.225;dbname=bd_seguridad_sistemas", "user_helpdesk", "Systema$10");
                        break;

                    case "helpdesk":
                        $this->dbh = new PDO("mysql:host=192.168.1.225;dbname=andercode_helpdesk", "user_helpdesk", "Systema$10");
                        break;

                    case "siai":
                        $this->dbh = new PDO("mysql:host=127.0.0.1;dbname=siai", "root", "");
                        break;

                    case "siga":
                        $this->dbh = new PDO("mysql:host=192.168.1.224;dbname=siga_administrativo", "siga", 'siga&%$admvo01');
                        break;
                }
            }

            return $this->dbh;
        } catch (PDOException $e) 
        {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    } 

    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8mb4'");
    }

    public function ruta()
    {
        return "http://localhost/HelpDesk/";
    }
}
?>