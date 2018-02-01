<?php

    // recuperation du contenu des variables post envoyé à travers le formulaire register
    $membre_pseudo = $request->get('pseudo');
    $password = $request->get('password');
    $description = $request->get('description');
    $email = $request->get('email');
    $website = $request->get('website');
    $localisation = $request->get('localisation');
    $pass = $request->get('password');
    $confirm = $request->get('confirm');


    //déclaration des variables d'erreur
    $pseudo_erreur1 = NULL;
    $pseudo_erreur2 = NULL;
    $mdp_erreur1 = NULL;
    $mdp_erreur2 = NULL;
    $email_erreur1 = NULL;
    $email_erreur2 = NULL;
    $description_erreur = NULL;
    $avatar_erreur = NULL;
    $avatar_erreur1 = NULL;
    $avatar_erreur2 = NULL;
    $avatar_erreur3 = NULL;

    $i = 0; //Variable qui compte le nombre d'erreur rencontrées

    //Variable date
    date_default_timezone_set("Europe/Paris");
    $temps = date('Y-m-d');

    // Appel methode de recherche par pseudo
    require('../src/modeles/modele_membre.php');
    $connect = get_membre_by_pseudo($membre_pseudo);

    //verification - le tableau ne contient pas un pseudo existant, le pseudo est libre (1)
    if (sizeof($connect)==0)
        $pseudo_free = 1;
    else
        $pseudo_free = 0;

    //erreur pseudo déjà pris
    if($pseudo_free==0)
    {
        $pseudo_erreur1 = "Votre pseudo est déjà utilisé par un membre";
        $i++;
    }
    //erreur pseudo pas compris entre 3 et 15 caractères
    if (strlen($membre_pseudo) < 3 || strlen($membre_pseudo) > 15)
    {
        $pseudo_erreur2 = "Votre pseudo ne respecte pas la taille demandée";
        $i++;
    }

    //Vérification du mdp
    //vérifie si le champ de confirmation a la même valeur que le champs de mdp
    //vérifie si les deux champs sont bien remplis
    if (empty($confirm) || empty($pass))
    {
        $mdp_erreur1 = "Votre mot de passe et/ou votre confirmation ne sont pas remplis";
        $i++;
    }

    if ($pass != $confirm)
    {
        $mdp_erreur2 = "Votre mot de passe et votre confirmation de mot de passe ne correspondent pas";
        $i++;
    }

    //Appel de methode - recherche par email

    // Appel methode de recherche par pseudo
    $connect_mail = get_membre_by_mail($email);

    //verification - le tableau ne contient pas de mail existant, le mail est libre (1)
    if (sizeof($connect_mail)==0)
        $mail_free = 1;
    else
        $mail_free = 0;

    if(!$mail_free)
    {
        $email_erreur1 = "Votre adresse email est déjà utilisée par un membre";
        $i++;
    }
    //On vérifie la forme et que le champ est bien rempli
    if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $email) || empty($email))
    {
        $email_erreur2 = "Votre adresse E-Mail n'a pas un format valide";
        $i++;
    }


    //Vérification de la description
    //le champ n'est pas obligatoire, on ne vérifie pas s'il est vide
    if (strlen($description) > 200)
    {
        $description_erreur = "Votre description est trop longue";
        $i++;
    }

    //Vérification de l'avatar :
    if (!empty($_FILES['avatar']['size']))
    {
        //On définit les variables :
        $maxsize = 20000; //Poid de l'image
        $maxwidth = 100; //Largeur de l'image
        $maxheight = 100; //Longueur de l'image
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png', 'bmp' ); //Liste des extensions d'images acceptées

        if ($_FILES['avatar']['error'] > 0)
        {
                $avatar_erreur = "Erreur lors du transfert de l'avatar : ";
        }
        if ($_FILES['avatar']['size'] > $maxsize)
        {
                $i++;
                $avatar_erreur1 = "Le fichier est trop gros : (<strong>".$_FILES['avatar']['size']." Octets</strong>    contre <strong>".$maxsize." Octets</strong>)";
        }

        $image_sizes = getimagesize($_FILES['avatar']['tmp_name']);
        if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight)
        {
                $i++;
                $avatar_erreur2 = "Image trop large ou trop longue :
                (<strong>".$image_sizes[0]."x".$image_sizes[1]."</strong> contre <strong>".$maxwidth."x".$maxheight."</strong>)";
        }

        //on converti les extensions en minuscule afin d'accepter les extension du type .JPG
        $extension_upload = strtolower(substr(  strrchr($_FILES['avatar']['name'], '.')  ,1));
        if (!in_array($extension_upload,$extensions_valides) )
        {
                $i++;
                $avatar_erreur3 = "Extension de l'avatar incorrecte";
        }
    }


   if ($i==0)//La variable i a compté le nombre d'erreur rencontrées, si elle vaut 0, tout est bon
   {
        //on déplace l'avatar uploadé avec la fonction move_avatar
	    $nomavatar=(!empty($_FILES['avatar']['size']))?move_avatar($_FILES['avatar']):'';

        //hashage du pass
	    $pass=md5($pass);

        if(empty($nomavatar))
            $nomavatar = 'index.jpg';

	    // Appel methode de recherche par pseudo
        require('../src/class/Membres.class.php');
        $membre = new Membres($dbCon);
        $membre->insert($membre_pseudo,$pass,$email,$website,$nomavatar,$description,$localisation,$temps);


	    //Et on définit les variables de sessions
        $app['session']->set('pseudo', $membre_pseudo);
        $app['session']->set('id', $dbCon->lastInsertId());
        $app['session']->set('rang', 2);
        $app['session']->set('connexion', true);

        //On ajoute la personne dans la table des connectés
        require('../src/class/Connecte.class.php');
        $connect = new Connecte($dbCon);
        $connect->insert($app['session']->get('id'),$membre_pseudo);

        stripslashes(htmlspecialchars($membre_pseudo));
         
    }
