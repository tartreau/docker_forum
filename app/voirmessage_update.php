<?php 
$message_avatar = $app['session']->get('avatar');

if (empty($message_avatar))
	$message_avatar='index.jpg';

require('../src/modeles/modele_messages.php');
$msg = get_message_id($num_msg);
$app['session']->set('message_contenu', $msg[0]['message_contenu']);

// Instanciation de la classe message
require('../src/class/Messages.class.php');
$message = new Messages($dbCon);

//Fonction de modification message
if (isset($request)){
	if ($app['session']->get('valid_msg')=='oui'){
		$message->update($msg[0]['message_id'],$request->get('message_contenu'),$pseudo,$message_avatar,date('H\hi \l\e d/M/Y')."(a été edité)",$app['session']->get('sujet'),$app['session']->get('topic'));
	}
}