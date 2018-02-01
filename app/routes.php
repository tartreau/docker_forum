<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/***********
****** ROUTES- FORUM
**********/

//Route - Accueil
$app->get('/', function () {  
    require '../src/homepage.php';
    $view = ob_get_clean();
    return $view;
});

//Route - page de connexion
$app->get('/connexion', function () use ($app) { 
    require '../src/header.php';
    return $app['twig']->render('connexion.html.twig', array('err' => '100'));
});

//Route page de connexion -- redirection
$app->post('/connexion/redirect', function (Request $request) use ($app) {
    require '../src/header.php';
	//Récupération des getters
	$pseudo = $request->get('pseudo');
    $password = $request->get('password');

    require'../src/modeles/modele_membre.php';
    $requete=get_membre_by_pseudo($pseudo);

    //variable erreurs à 0 (aucune erreur initialement)
    $err = '0';

    //Ajout valeurs aux variables session
	if(empty($pseudo)||empty($password)){
    	return $app['twig']->render('connexion.html.twig', array('err' => '1'));
    }else if(empty($requete)){ 
        return $app['twig']->render('connexion.html.twig', array('err' => '3'));
    }else{
        require '../app/connexion.php';
        return $app['twig']->render('connexion.html.twig', array('err' => $err));
    }
});

//Route page de deconnexion
$app->get('/deconnexion', function () use ($app){   
    require '../src/header.php';
    require '../app/deconnexion.php';
    return $app['twig']->render('deconnexion.html.twig', array());
});

//Route page d'inscription
$app->get('/register', function () use ($app){   
    if ($app['session']->get('id')!=0){
        require '../src/homepage.php';
        $view = ob_get_clean();
        return $view;
    }
    else
        return $app['twig']->render('register.html.twig', array());
});
$app->post('/register/redirect', function (Request $request) use ($app){   
    require '../src/header.php';
    require '../app/register.php';
    return $app['twig']->render('register_confirmation.html.twig', array('pseudo'=>$pseudo,'i'=>$i,'pseudo_erreur1'=>$pseudo_erreur1,'pseudo_erreur2'=>$pseudo_erreur2,'mdp_erreur1'=>$mdp_erreur1,'mdp_erreur2'=>$mdp_erreur2, 'email_erreur1'=>$email_erreur1, 'email_erreur2'=>$email_erreur2, 'description_erreur'=>$description_erreur, 'avatar_erreur'=>$avatar_erreur,'avatar_erreur1'=>$avatar_erreur1, 'avatar_erreur2'=>$avatar_erreur2, 'avatar_erreur3'=>$avatar_erreur3));
});


//Route pour voir les topic
$app->get('/forum/{membre_id}', function ($membre_id) use ($app){
    require '../src/header.php';
    require '../app/voirforum.php';
    
    return $app['twig']->render('topic.html.twig', array(
        'pseudo' => $pseudo,
        'titre' => $titre,
        'letopic' => $letopic,
        'membre_id' => $membre_id,
        'nomtopic' => $nomtopic,
        'personnes_connectes' => $personnes_connectes,
        'rang' => $_SESSION['rang']));
})->bind('page_topic');

//Route pour ajouter les topic
$app->post('/forum/{membre_id}/ajout', function (Request $request, $membre_id) use ($app){
    require '../src/header.php';
    require '../app/voirforum.php';
    return new Response("<script language='Javascript'>alert('Ajout effectué');document.location.href='/www/forum/".$membre_id."';</script>", 200);
});

//Route pour supprimer les topic
$app->get('/forum/{membre_id}/suppr/{num_topic}', function (Request $request, $membre_id, $num_topic) use ($app){
    $app['session']->set('num_topic', $num_topic);
    require '../src/header.php';
    require '../app/voirforum.php';
    return new Response("<script language='Javascript'>alert('Suppression effectué');document.location.href='/www/forum/".$membre_id."';</script>", 200);
});

//Route pour voir les messages
$app->get('/forum/{membre_id}/{message_id}', function ($membre_id, $message_id) use ($app){
    require '../src/header.php';
    require '../app/voirmessage.php';
    $app['session']->set('valid_msg', 'non');
    return $app['twig']->render('message.html.twig', array(
        'pseudo' => $pseudo,
        'membre_id' => $membre_id,
        'message_id' => $message_id,
        'titre' => $titre,
        'titreforum' => $titreforum,
        'letopic' => $letopic,
        'lesmessages' => $lesmessages,
        'topic_id' => $message_id,
        'forum_id' => $membre_id,
        'personnes_connectes' => $personnes_connectes,
        'rang' => $_SESSION['rang']));
});

//Route pour ajouter des messages
$app->post('/forum/{membre_id}/{message_id}/ajout', function (Request $request, $membre_id, $message_id) use ($app){
    require '../src/header.php';
    require '../app/voirmessage.php';
    return new Response("<script language='Javascript'>alert('Ajout effectué');document.location.href='/www/forum/".$membre_id."/".$message_id."';</script>", 200);
});

//Route pour supprimer les messages
$app->get('/forum/{membre_id}/{message_id}/suppr/{num_message}', function (Request $request, $membre_id, $message_id, $num_message) use ($app){
    $app['session']->set('num_message', $num_message);
    require '../src/header.php';
    require '../app/voirmessage.php';
    return new Response("<script language='Javascript'>alert('Suppression effectué');document.location.href='/www/forum/".$membre_id."/".$message_id."';</script>", 200);
});

//Route pour modifier les messages
$app->post('/forum/{membre_id}/{message_id}/edit/{num_msg}', function (Request $request, $membre_id, $message_id, $num_msg) use ($app){
    require '../src/header.php';
    require '../app/voirmessage_update.php';
    $app['session']->set('valid_msg', 'non');
    $message_contenu = $app['session']->get('message_contenu');
    return $app['twig']->render('message_edit.html.twig', array(
            'num_message' => $num_msg,
            'membre_id' => $membre_id,
            'message_id' => $message_id,
            'message_contenu'=> $message_contenu
        ));
});
$app->post('/forum/{membre_id}/{message_id}/edit/{num_msg}/valider', function (Request $request, $membre_id, $message_id, $num_msg) use ($app){
    $app['session']->set('valid_msg', 'oui');
    require '../src/header.php';
    require '../app/voirmessage_update.php';
    return new Response("<script language='Javascript'>alert('Modification effectué');document.location.href='/www/forum/".$membre_id."/".$message_id."';</script>", 200);
});

//Profil
$app->get('/profil/{num_profil}', function ($num_profil) use ($app){  
    require '../src/header.php'; 
    require '../app/voirprofil.php';
    if ($app['session']->get('admin')==4){
        return $app['twig']->render('profil_admin.html.twig', array(
            'titre' => $titre,
            'membre_id' => $membre_id,
            'membre_pseudo' => $membre_pseudo,
            'membre_mdp' => $membre_mdp,
            'membre_email' => $membre_email,
            'membre_siteweb' => $membre_siteweb,
            'membre_avatar' => $membre_avatar,
            'membre_description' => $membre_description,
            'membre_localisation' => $membre_localisation,
            'membre_inscrit' => $membre_inscrit,
            'membre_derniere_visite' => $membre_derniere_visite,
            'membre_rang' => $membre_rang
        ));
    }
    else{
        return $app['twig']->render('profil.html.twig', array(
            'titre' => $titre,
            'membre_pseudo' => $membre_pseudo,
            'membre_email' => $membre_email,
            'membre_siteweb' => $membre_siteweb,
            'membre_avatar' => $membre_avatar,
            'membre_description' => $membre_description,
            'membre_localisation' => $membre_localisation,
            'membre_inscrit' => $membre_inscrit,
            'membre_derniere_visite' => $membre_derniere_visite,
            'membre_rang' => $membre_rang
        ));
    }
});

//Route pour modifier les profils
$app->post('/profil/{num_profil}/modif', function (Request $request, $num_profil) use ($app){
    require '../src/header.php';
    require '../app/voirprofil.php';
    return new Response("<script language='Javascript'>alert('Modification effectué');document.location.href='/www/profil/".$num_profil."';</script>", 200);
});

//Retour menu
$app->get('/admin', function () use ($app){   
    require '../src/header.php'; 
    return new Response("<script language='Javascript'>document.location.href='/www/';</script>", 200);
});


//Liste des membres
$app->get('/admin/page_membre', function () use ($app){   
    require '../src/header.php'; 
    require '../app/admin/controleur_membres.php';
    if ($app['session']->get('admin')==4)
        return $app['twig']->render('liste_membres.html.twig', array('membres'=>$membres));
    else
        return new Response("<script language='Javascript'>document.location.href='/www/';</script>", 200);
});

//Suppression d'un membre
$app->get('/admin/page_membre/suppr/{num_membre}', function ($num_membre) use ($app){   
    require '../src/header.php'; 
    require '../app/admin/controleur_membres.php';
    return new Response("<script language='Javascript'>alert('Suppression effectué');document.location.href='/www/admin/page_membre';</script>", 200);
});


/***********
****** API REST (Voir-Suppression-modification Membres et Messages par catégorie)
**********/

//Présentation API
$app->get('/api', function () use ($app){
    require '../src/header.php';
    return $app['twig']->render('api.html.twig', array());
});

//Membres
$app->get('/api/membres', function () use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_membre.php';
    $membres = get_all_membres_links();
    return json_encode($membres,JSON_PRETTY_PRINT);
});
$app->get('/api/membres/{nom}', function ($nom) use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_membre.php';
    $membre = get_membre_by_pseudo($nom);
    if (!$membre){
        $app->abort(404, "Membre inexistant");
    }
    else {
        return json_encode($membre,JSON_PRETTY_PRINT);
    }
});
// Delete membre
$app->delete('/api/membres/{nom}', function($nom) use ($app) {
    require '../src/header.php';  
    require '../src/modeles/modele_membre.php';
    $membre = get_membre_by_pseudo($nom);
    if (!$membre){
        $app->abort(404, "Membre inexistant");
    }
    else {
        delete_membre_by_pseudo($nom);
        return json_encode($membre,JSON_PRETTY_PRINT);
    }
});
// Ajout membre
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
$app->post('/api/membres', function (Request $request) use ($app) {
    require '../src/header.php';  
    require '../src/modeles/modele_membre.php';
    $data = $request->request->all();
    add_membre($data);
    return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
});


// Voir les Connectés et topics
$app->get('/api/connectes', function () use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_connecte.php';
    $membres = get_all_connecte();
    return json_encode($membres,JSON_PRETTY_PRINT);
});
$app->get('/api/topics', function () use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_topic.php';
    $topics = get_all_topics_links();
    return json_encode($topics,JSON_PRETTY_PRINT);
});
$app->get('/api/topics/{nom}', function ($nom) use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_topic.php';
    $topic = get_topic_id_by_nom($nom);
    return json_encode($topic,JSON_PRETTY_PRINT);
});


// Messages
$app->get('/api/messages', function () use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_messages.php';
    $msg = get_all_messages_links();
    return json_encode($msg ,JSON_PRETTY_PRINT);
});
// Voir messages catégorie topic
$app->get('/api/messages/{forum_id}', function ($forum_id) use ($app){ 
    require '../src/header.php';  
    require '../src/modeles/modele_messages.php';
    $msg = get_message_topic($forum_id);
    return json_encode($msg,JSON_PRETTY_PRINT);
});
// Supprimer messages catégorie topic
$app->delete('/api/messages/{forum_id}', function($forum_id) use ($app) {
    require '../src/header.php';  
    require '../src/modeles/modele_messages.php';
    $msg = get_message_topic($forum_id);
    if (!$msg){
        $app->abort(404, "Topic inexistant");
    }
    else {
        delete_message_by_topic($forum_id);
        return json_encode($msg,JSON_PRETTY_PRINT);
    }
});
//Ajout messages par catégorie de topics
$app->post('/api/messages', function (Request $request) use ($app) {
    require '../src/header.php';  
    require '../src/modeles/modele_messages.php';
    $data = $request->request->all();
    add_messages($data);
    return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
});


/***********
****** XML - Export
**********/

$app->get('/xml', function() use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_messages.php';
    xml_messages();
    return new Response("Accueil : <a href='/www'>Retour</a></br></br>les liens xml (écriture) : <a href='/www/xml/topic'>Export de tous les topics</a></br><a href='/www/xml/topic/6'>Export des topics de Loisir</a></br><a href='/www/xml/messages'>Export de tous les messages</a></br><a href='/www/xml/messages/6/30'>Export topic 1 de Loisir</a></br></br>les liens xml (relecture): <a href='/www/xml/topic_relecture'>Tous les topics</a></br><a href='/www/xml/messages_relecture'>Tous les messages</a></br>");
});

$app->get('/xml/topic', function() use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_topic.php';
    xml_topic();
    return new Response("Export xml effectué ! <a href='/www/xml'>Retour</a>");
});

$app->get('/xml/topic/{numero}', function($numero) use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_topic.php';
    xml_topic_by_id($numero);
    return new Response("Export xml effectué ! <a href='/www/xml'>Retour</a>");
});

$app->get('/xml/topic_relecture', function() use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_topic.php';
    xml_relecture_topic();
    $view = ob_get_clean();
    return $view;
});

$app->get('/xml/messages', function() use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_messages.php';
    xml_messages();
    return new Response("Export xml effectué ! <a href='/www/xml'>Retour</a>");
});

$app->get('/xml/messages/{forum}/{topic}', function($forum, $topic) use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_messages.php';
    xml_message_by_id($forum, $topic);
    return new Response("Export xml effectué ! <a href='/www/xml'>Retour</a>");
});

$app->get('/xml/messages_relecture', function() use ($app){
    require '../src/header.php';
    require '../src/modeles/modele_messages.php';
    xml_relecture_messages();
    $view = ob_get_clean();
    return $view;
});