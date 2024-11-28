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
                    case "seguridad":
                        $this->dbh = new PDO("mysql:host=192.168.1.198;dbname=bd_seguridad_sistemas", "root", "Chiapas2021TA");
                        break;
                        
                    case "helpdesk":
                        $this->dbh = new PDO("mysql:host=192.168.1.198;dbname=andercode_helpdesk", "root", "Chiapas2021TA");
                        break;

                    case "siai":
                        $this->dbh = new PDO("mysql:host=192.168.1.198;dbname=siai", "root", "Chiapas2021TA");
                        break;

                    case "siga":
                        $this->dbh = new PDO("mysql:host=192.168.1.198;dbname=siga_administrativo", "root", 'Chiapas2021TA');
                        break;
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
                        $this->dbh = new PDO("mysql:host=192.168.1.225;dbname=siai", "SIAI_USER", "ChiapasInformatica$10");
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



    public function rutaHelpdesk()
    {
        if ($this->configMysql == "Local") 
        {
            return "http://192.168.1.121/HelpDesk/";
        }
        else
        {
            return "http://192.168.1.121/HelpDesk/";
        }
    }


    public function rutaPortal()
    {
        if ($this->configMysql == "Local") 
        {
            return "http://192.168.1.121/PortalNuevaVersion/";
        }
        else
        {
            return "http://192.168.1.121/PortalNuevaVersion/";
        }
    }
    
}
?>