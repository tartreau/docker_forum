--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `forum_categorie`
--
ALTER TABLE `forum_categorie`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `forum_forum`
--
ALTER TABLE `forum_forum`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `forum_membres`
--
ALTER TABLE `forum_membres`
  MODIFY `membre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `forum_message`
--
ALTER TABLE `forum_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contenu de la table `forum_categorie`
--

INSERT INTO `forum_categorie` (`cat_id`, `cat_nom`, `cat_ordre`) VALUES
(1, 'Général', 30),
(2, 'Jeux-Vidéos', 20),
(3, 'Autre', 10);


--
-- Contenu de la table `forum_forum`
--

INSERT INTO `forum_forum` (`forum_id`, `forum_cat_id`, `forum_name`, `forum_desc`, `forum_ordre`, `forum_last_post_id`, `forum_topic`, `forum_post`, `auth_view`, `auth_post`, `auth_topic`, `auth_annonce`, `auth_modo`) VALUES
(1, 1, 'Présentation', 'Nouveau sur le forum? Venez vous présenter ici !', 60, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 'Les News', 'Les news du site sont ici', 50, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 1, 'Discussions générales', 'Ici on peut parler de tout sur tous les sujets', 40, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 2, 'MMORPG', 'Parlez ici des MMORPG', 60, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 2, 'Autres jeux', 'Forum sur les autres jeux', 50, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 3, 'Loisir', 'Vos loisirs', 60, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 3, 'Délires', 'Décrivez ici tous vos délires les plus fous', 50, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Contenu de la table `forum_membres`
--

INSERT INTO `forum_membres` (`membre_id`, `membre_pseudo`, `membre_mdp`, `membre_email`, `membre_siteweb`, `membre_avatar`, `membre_description`, `membre_localisation`, `membre_inscrit`, `membre_derniere_visite`, `membre_rang`) VALUES
(1, 'momo', '06c56a89949d617def52f371c357b6db', 'momo@ta.fr', '', 'index.jpg', 'Profil de l\'admin du forum', '', '2017-11-17', '2018-01-03', 4),
(9, 'popo', '3b2285b348e95774cb556cb36e583106', 'popo@popo.fr', '', 'avatar.jpg', 'test', '', '2017-12-08', '2018-01-02', 2),
(10, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test.fr', 'mon site', '1513707154.jpg', 'Une nouvelle étape', 'Paris', '2017-12-19', '2018-01-03', 2);

--
-- Contenu de la table `forum_message`
--

INSERT INTO `forum_message` (`message_id`, `message_contenu`, `message_createur`, `message_avatar`, `message_time`, `topic_id`, `forum_id`, `message_createur_id`) VALUES
(58, 'Loremefeffz ipsum dolor sit amet ', 'momo', 'index.jpg', '09h07 le 17/Nov/2017(a été edité)', 17, 6, 0),
(84, 'nouveau message 30', 'momo', 'index.jpg', '23h21 le 02/Jan/2018(a été edité)', 30, 6, 0),
(86, 'coucou message 3<br>', 'momo', 'index.jpg', '15h27 le 02/Dec/2017', 30, 6, 1),
(87, 'xzes dv<br>', 'momo', 'index.jpg', '15h30 le 02/Dec/2017', 19, 4, 1),
(88, 'coucou', 'momo', 'index.jpg', '12h15 le 08/Dec/2017', 30, 6, 1),
(102, 'Bienvenue sur le forum<br>', 'momo', 'index.jpg', '23h21 le 02/Jan/2018(a été edité)', 30, 6, 1),
(92, 'Lorem ipsum dolor', 'momo', 'index.jpg', '12h05 le 01/Jan/2018(a été edité)', 30, 6, 1),
(98, 'Nouveau message , un test<br>', 'popo', 'avatar.jpg', '12h16 le 01/Jan/2018', 30, 6, 9),
(96, 'Nouveau', 'momo', 'index.jpg', '12h59 le 31/Dec/2017', 30, 6, 1),
(97, 'Lorem ipsum dolor sit amet<br>', 'momo', 'index.jpg', '12h59 le 31/Dec/2017', 30, 6, 1),
(106, 'Bonjour à toi , nouveau membre<br>', 'test', '1513707154.jpg', '23h45 le 02/Jan/2018', 30, 6, 10);

--
-- Contenu de la table `forum_topic`
--

INSERT INTO `forum_topic` (`topic_id`, `forum_id`, `topic_titre`, `topic_createur`, `topic_vu`, `topic_time`, `topic_genre`, `topic_last_post`, `topic_first_post`, `topic_post`, `topic_createur_id`) VALUES
(35, 5, 'autre jeu topic 1', 'momo', 0, '11h26 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(36, 2, 'fnejzi', 'momo', 0, '11h27 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(19, 4, 'Topic', 'jeremie', 0, '14h16 le 08/Nov/2017', 'genre TEST', 0, 5, 5, 0),
(34, 7, 'délire 2', 'momo', 0, '11h06 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(30, 6, 'topic 1', 'momo', 0, '15h08 le 02/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(31, 6, 'topic 2', 'momo', 0, '15h08 le 02/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(32, 6, 'topic 3', 'momo', 0, '15h09 le 02/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(33, 7, 'délire 1', 'momo', 0, '11h06 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(37, 2, 'nejzoph', 'momo', 0, '11h28 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(38, 6, 'topic loisir 4', 'momo', 0, '12h07 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 1),
(39, 6, 'popo', 'popo', 0, '12h19 le 08/Dec/2017', 'genre TEST', 0, 5, 5, 9),
(65, 6, 'nouveau', 'momo', 0, '19h02 le 27/Dec/2017', 'non déterminé', 0, 0, 0, 1),
(67, 6, 'nouveau topic', 'momo', 0, '20h32 le 27/Dec/2017', 'non déterminé', 0, 0, 0, 1),
(69, 1, 'Présentation de popo', 'popo', 0, '12h36 le 02/Jan/2018', 'non déterminé', 0, 0, 0, 9),
(70, 1, 'Présentation de momo', 'popo', 0, '12h37 le 02/Jan/2018', 'non déterminé', 0, 0, 0, 9);