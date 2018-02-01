<?php 

/***********
***** VIEW - HEADER et NAV
***********
***********/
?>
<!Doctype html>
  <head>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="../www/css/main.css" />
<?php
      //Si le titre est indiqué, on l'affiche entre les balises <title>
      if (!empty($_SESSION['titre']))
        echo '<title> '.$_SESSION['titre'].' </title>';
      else //Sinon, on écrit forum par défaut
        echo '<title> Forum </title>';

    echo'</head>';

    // Le nav
    echo'<body>';
    
    echo '<nav>';
    echo '<li><a href="/Projet_PHP/www/api">API Rest</a>|<a href="/Projet_PHP/www/xml">Export XML</a></li>';
    if(!empty($_SESSION['admin'])){
      echo '<li><a href="/Projet_PHP/www/admin/page_membre">Gérer les membres</a></li>';
    }
    if(empty($_SESSION['connexion'])){
      echo '<li><a href="/Projet_PHP/www/register">Inscription</a></li>
          <li><a href="/Projet_PHP/www/connexion">Connexion</a></li>';
    }else{
      echo '<li><a href="/Projet_PHP/www/deconnexion">Déconnexion</a></li>';
      echo '<li><a href="/Projet_PHP/www/profil/'.$_SESSION['id'].'">Éditer mon profil</a></li>';
    }
    echo'</nav>';
