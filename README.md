# Projet de forum PHP 2017/2018  - IUT Orléans

Réalisation d'un forum en php à l'aide du micro-framework *silex* et de *twig*

* Jérémie Laisné
* Florent Moulin
* Morgan Tartreau


Forum :
- Inscription et connexion
- Différenciation entre personnes connectés : visiteur, membre et administrateur
- Création, modification et suppression d'un topic
- Création, modification et suppression d'un message
- Statistiques (nombres de personnes connectés, nombres de messages sur le forum, date du dernier message posté ect..)

Utilisation d'une API Rest en json :
- méthodes GET, POST et DELETE (membres)
- méthodes GET, POST et DELETE (topic)
- méthodes GET, POST et DELETE (messages)

Export XML :
-XML Writer pour écriture et SimpleXML pour la relecture (topic, messages)