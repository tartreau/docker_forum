<?php

require("includes/debut.php");
require("header.php");


//On donne ensuite un titre à la page, puis on appelle notre fichier debut.php
$titre = "Forum projet php";

if(isset($_SESSION['pseudo']))
    echo '<p>Utilisateur connecté : '.$_SESSION['pseudo'].'<p>';
?>

<h1>Forum Projet PHP</h1>
<?php
    echo'<main><section><i>Vous êtes ici : </i><a href ="/www/">Index du forum</a></section>';
    //Initialisation de deux variables
    $totaldesmessages = 0;
    $categorie = NULL;

    //Cette requête permet d'obtenir tout sur le forum
    $query=$dbCon->prepare('SELECT cat_id, cat_nom,
    forum_forum.forum_id, forum_name, forum_desc
    FROM forum_categorie
        LEFT JOIN forum_forum ON forum_categorie.cat_id = forum_forum.forum_cat_id
    WHERE auth_view <= :lvl
    ORDER BY cat_ordre, forum_ordre DESC');

    $query->bindValue(':lvl',$lvl,PDO::PARAM_INT);
    $query->execute();
?>
<section id = "tableau_topic">
<!-- Les catégories -->
<table>
<?php
    //Début de la boucle
    while($data = $query->fetch())
    {
        //On affiche chaque catégorie
        if( $categorie != $data['cat_id'] )
        {
            //Si c'est une nouvelle catégorie on l'affiche
            $categorie = $data['cat_id'];
        ?>
            <tr>
                <th></th>
                <th class="titre"><strong><?php echo stripslashes(htmlspecialchars($data['cat_nom'])); ?>
            </strong></th>
                <th class="nombremessages"><strong>Sujets</strong></th>
                <th class="nombresujets"><strong>Messages</strong></th>
                <th class="derniermessage"><strong>Dernier message</strong></th>
            </tr>
        <?php
    }
    //Ici, on met le contenu de chaque catégorie

    /* Les forums */
    // les forums en détail : description, nombre de réponses etc...

        echo'<tr>
                <td><img src="/www/images/message.jpg" alt="message" /></td>
                <td class="titre"><strong>
                    <a href="./forum/'.$data['forum_id'].'">
                    '.stripslashes(htmlspecialchars($data['forum_name'])).'</a></strong>
                    <br />'.nl2br(stripslashes(htmlspecialchars($data['forum_desc']))).'
                </td>';

            // Décompte du nombre de sujets    
	        echo'<td class="nombresujets">';

                // Requete retourne le nombre de sujets par topic
	            $sql_sujet="SELECT distinct(count(*))
						FROM `forum_topic` ft 
						WHERE ft.forum_id = ".$data['forum_id'];

	            $sql_sujet=$dbCon->prepare($sql_sujet);
                $sql_sujet->execute();
	            $result_s = $sql_sujet->fetchAll();

                // Si resultat retourne rien, on renvoi un 0
                if(empty($result_s))
                    echo "<p>0</p>";
                // sinon on retoune le resultat de la requete
	            foreach ($result_s as $row)
		            echo "<p>".$row[0]."</p>";
	
	        echo '</td>';

            //Décompte du nombre de messages
            echo '<td class="nombremessages">';

                // Requete retourne le nombre de messages par topic
                $sql_message="SELECT distinct(count(*))
                        FROM `forum_message` fm
                        WHERE fm.forum_id = ".$data['forum_id'];

                $sql_message=$dbCon->prepare($sql_message);
                $sql_message->execute();
                $result_m = $sql_message->fetchAll();

                // Si resultat retourne rien, on renvoi un 0
                if(empty($result_m))
                    echo "<p>0</p>";
                // sinon on retoune le resultat de la requete
                foreach ($result_m as $row)
                    echo "<p>".$row[0]."</p>";

            echo '</td>';
            echo '<td class="nombremessages">';

                // Requete retourne affichage messages par topic
                $sql_d_message="SELECT `message_time`
                        FROM `forum_message` fm
                        WHERE fm.forum_id = ".$data['forum_id']."
                        ORDER BY message_id DESC
                        LIMIT 1";

                $sql_d_message=$dbCon->prepare($sql_d_message);
                $sql_d_message->execute();
                $result_d = $sql_d_message->fetchAll();

                // Si resultat retourne rien, on renvoi un 0
                if(empty($result_d))
                    echo "<p>Pas de message</p>";
                // sinon on retoune le resultat de la requete
                foreach ($result_d as $row)
                    echo "<p>".$row[0]."</p>";
            echo '</td></tr>';

        //On ferme notre boucle et nos balises
    } //fin de la boucle
$query->CloseCursor();
echo '</table></section></main>';

/* FOOTER */

//Le pied de page ici :
?>
<footer id="footer">
    <h2>Qui est en ligne ?</h2>
    <?php

    // On affiche les membres connectes
    require('modeles/modele_connecte.php');
    $lesconnectes = get_all_connecte();
    // Test temporaire
    echo 'Les membres connectés sont : ';

    // On parcours l'ensemble des personnes présentes dans la table connecté et on récupère les valeurs id et pseudo présente dans le tableau $lesconnectes
    foreach($lesconnectes as $cle=>$valeur)
        echo '<a href="./profil/'.$valeur[0].'">'.$valeur[1].'</a>  ';

    //On compte les messages
    $totaldesmessages = $dbCon->query('SELECT COUNT(*) FROM forum_message')->fetchColumn();
    $query->CloseCursor();

    //On compte les membres
    $totalDesMembres = $dbCon->query('SELECT COUNT(*) FROM forum_membres')->fetchColumn();
    $query->CloseCursor();
    
    $query = $dbCon->query('SELECT membre_pseudo, membre_id FROM forum_membres ORDER BY membre_id DESC LIMIT 0, 1');
    $data = $query->fetch();
    $derniermembre = stripslashes(htmlspecialchars($data['membre_pseudo']));

    echo'<p>Le nombre total des messages du forum est de <strong>'.$totaldesmessages.'</strong>.<br />
    Le site et le forum comptent <strong>'.$totalDesMembres.'</strong> membres.<br />
    Le dernier membre est <a href="./profil/'.$data['membre_id'].'">'.$derniermembre.'</a>.</p>';
	$query->CloseCursor();
    ?>
    </footer>
</body>
</html>
