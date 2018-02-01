<?php
//fonction erreur
function erreur($err='')
{
   $mess=($err!='')? $err:'Une erreur inconnue s\'est produite';
   exit('<div id="error"><p>'.$mess.'</p>
   <p>Cliquez <a href="./index.php">ici</a> pour revenir à la page d\'accueil</p></div></div></body></html>');
}

//fonction move_avatar
//renvoie un message si l'upload s'est bien passé
//enregistre le fichier
function move_avatar($avatar)
{
    $extension_upload = strtolower(substr(  strrchr($avatar['name'], '.')  ,1));
    $name = time(); //donne le nom du timestamp actuel afin que celui-ci soit unique
    $nomavatar = str_replace(' ','',$name).".".$extension_upload; //on ajoute l'extension
    $name = "./images/avatars/".str_replace(' ','',$name).".".$extension_upload;
    move_uploaded_file($avatar['tmp_name'],$name); //déplace dans /images/avatars
    return $nomavatar;
}
?>
