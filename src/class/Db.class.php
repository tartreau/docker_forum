<!-- CONNEXION BASE DE DONNEE -->
    <?php
        class Db
        {
            //on rend privé la BDD
            private $dbc;
            //On établit la connexion
            // ou on affiche un message d'erreur
            function __construct()
            {
                try
                {
                    $this->dbc = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,
                    DB_USER,DB_PASS,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
                  //  echo '<script>alert("Connexion au fichier réussie");</script>';
                }
                catch(PDOException $e)
                {
                    exit("Error: ".$e->getMessage());
                    echo 'connexion rate<br>';
                }
            }
            //On obtient la BDD pour l'utiliser quand on veut en dehors des classes
            function get()
            {
                return $this->dbc;
            }
            //On ferme la connexion avec NULL
            function close()
            {
                $this->dbc=null;
            }
        }
