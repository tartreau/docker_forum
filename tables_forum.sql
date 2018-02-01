CREATE DATABASE IF NOT EXISTS `forum`;

/*
DROP TABLE IF EXISTS `forum_categorie`;
DROP TABLE IF EXISTS `forum_connecte`;
DROP TABLE IF EXISTS `forum_forum`;
DROP TABLE IF EXISTS `forum_topic`;
DROP TABLE IF EXISTS `forum_membres`;
DROP TABLE IF EXISTS `forum_message`;
DROP TABLE IF EXISTS `forum_post`;
*/

--
-- Structure de la table `forum_categorie`
--

CREATE TABLE `forum_categorie` (
  `cat_id` int(11) NOT NULL,
  `cat_nom` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `cat_ordre` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Structure de la table `forum_connecte`
--

CREATE TABLE `forum_connecte` (
  `membre_id` int(3) NOT NULL,
  `membre_pseudo` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Structure de la table `forum_forum`
--

CREATE TABLE `forum_forum` (
  `forum_id` int(11) NOT NULL,
  `forum_cat_id` mediumint(8) NOT NULL,
  `forum_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `forum_desc` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `forum_ordre` mediumint(8) NOT NULL,
  `forum_last_post_id` int(11) NOT NULL,
  `forum_topic` mediumint(8) NOT NULL,
  `forum_post` mediumint(8) NOT NULL,
  `auth_view` tinyint(4) NOT NULL,
  `auth_post` tinyint(4) NOT NULL,
  `auth_topic` tinyint(4) NOT NULL,
  `auth_annonce` tinyint(4) NOT NULL,
  `auth_modo` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Structure de la table `forum_topic`
--

CREATE TABLE `forum_topic` (
  `topic_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `topic_titre` char(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `topic_createur` varchar(50) NOT NULL,
  `topic_vu` int(8) NOT NULL,
  `topic_time` varchar(50) NOT NULL,
  `topic_genre` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `topic_last_post` int(11) NOT NULL,
  `topic_first_post` int(11) NOT NULL,
  `topic_post` int(8) NOT NULL,
  `topic_createur_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Structure de la table `forum_membres`
--

CREATE TABLE `forum_membres` (
  `membre_id` int(11) NOT NULL,
  `membre_pseudo` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_mdp` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_email` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_siteweb` varchar(200) NOT NULL,
  `membre_avatar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_description` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_localisation` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_inscrit` date NOT NULL,
  `membre_derniere_visite` date NOT NULL,
  `membre_rang` tinyint(4) NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Structure de la table `forum_message`
--

CREATE TABLE `forum_message` (
  `message_id` int(11) NOT NULL,
  `message_contenu` varchar(1000) NOT NULL,
  `message_createur` varchar(50) NOT NULL,
  `message_avatar` text NOT NULL,
  `message_time` varchar(50) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `message_createur_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Index pour les tables exportées
--

--
-- Index pour la table `forum_categorie`
--
ALTER TABLE `forum_categorie`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_ordre` (`cat_ordre`);

--
-- Index pour la table `forum_connecte`
--
ALTER TABLE `forum_connecte`
  ADD PRIMARY KEY (`membre_id`);

--
-- Index pour la table `forum_forum`
--
ALTER TABLE `forum_forum`
  ADD PRIMARY KEY (`forum_id`);

--
-- Index pour la table `forum_membres`
--
ALTER TABLE `forum_membres`
  ADD PRIMARY KEY (`membre_id`);

--
-- Index pour la table `forum_message`
--
ALTER TABLE `forum_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Index pour la table `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD PRIMARY KEY (`topic_id`);