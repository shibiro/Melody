-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 16 Octobre 2015 à 13:31
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `formation`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` mediumint(9) NOT NULL,
  `news` smallint(6) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `contenu` text NOT NULL,
  `date` datetime NOT NULL,
  `mail` varchar(250) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `news`, `auteur`, `contenu`, `date`, `mail`) VALUES
(27, 49, 'nobody', 'test', 0x323031352d31302d31342031383a31363a3037, ''),
(26, 23, 'test', 'test3', 0x323031352d31302d31342031383a31323a3030, ''),
(28, 49, 'nobogy2', 'test3', 0x323031352d31302d31352031333a30303a3133, ''),
(25, 49, 'test', 'test2', 0x323031352d31302d31342031383a31313a3532, ''),
(29, 49, 'nobody3', 'testafichagejson3', 0x323031352d31302d31352031363a30383a3533, ''),
(30, 49, 'nobody4', 'test4', 0x323031352d31302d31352031363a31333a3132, ''),
(31, 49, 'nobody5', 'test5', 0x323031352d31302d31352031363a32313a3032, ''),
(72, 49, 'Pouet', 'Pouet - 71', 0x323031352d31302d31362031323a30323a3336, 'pouet@pouet.fr'),
(71, 49, 'Pouet', 'Pouet - 70', 0x323031352d31302d31362031323a30323a3332, 'pouet@pouet.fr'),
(70, 49, 'Pouet', 'Pouet - 69', 0x323031352d31302d31362031323a30323a3332, 'pouet@pouet.fr'),
(69, 49, 'Pouet', 'Pouet - 68', 0x323031352d31302d31362031323a30323a3332, 'pouet@pouet.fr'),
(68, 49, 'Pouet', 'Pouet - 67', 0x323031352d31302d31362031323a30323a3332, 'pouet@pouet.fr'),
(67, 49, 'Pouet', 'Pouet - 66', 0x323031352d31302d31362031323a30323a3237, 'pouet@pouet.fr'),
(66, 49, 'Pouet', 'Pouet - 65', 0x323031352d31302d31362031323a30313a3235, 'pouet@pouet.fr'),
(65, 49, 'Pouet', 'Pouet - 0', 0x323031352d31302d31362031323a30313a3133, 'pouet@pouet.fr'),
(64, 49, 'zerzer', 'zer', 0x323031352d31302d31362031313a35333a3538, ''),
(63, 49, 'ert', 'ert', 0x323031352d31302d31362031313a33393a3332, ''),
(62, 49, 'RTY', 'RTY', 0x323031352d31302d31362031313a33373a3330, ''),
(61, 49, 'test', 'test', 0x323031352d31302d31362031313a33313a3235, ''),
(60, 49, 'testauteurcom', 'test', 0x323031352d31302d31362031313a32393a3132, ''),
(73, 49, 'Pouet', 'Pouet - 72', 0x323031352d31302d31362031323a30323a3336, 'pouet@pouet.fr'),
(74, 49, 'Pouet', 'Pouet - 73', 0x323031352d31302d31362031323a30323a3336, 'pouet@pouet.fr'),
(75, 49, 'Pouet', 'Pouet - 74', 0x323031352d31302d31362031323a30323a3336, 'pouet@pouet.fr'),
(76, 49, 'Pouet', 'Pouet - 75', 0x323031352d31302d31362031323a31323a3032, 'pouet@pouet.fr'),
(77, 49, 'Pouet', 'Pouet - 76', 0x323031352d31302d31362031323a31323a3239, 'pouet@pouet.fr'),
(78, 49, 'Pouet', 'Pouet - 77', 0x323031352d31302d31362031323a31333a3536, 'pouet@pouet.fr'),
(79, 49, 'Pouet', 'Pouet - 78', 0x323031352d31302d31362031323a31343a3032, 'pouet@pouet.fr'),
(80, 49, 'Pouet', 'Pouet - 79', 0x323031352d31302d31362031323a31343a3237, 'pouet@pouet.fr'),
(81, 49, 'Pouet', 'Pouet - 80', 0x323031352d31302d31362031323a32333a3439, 'pouet@pouet.fr'),
(82, 49, 'Pouet', 'Pouet - 81', 0x323031352d31302d31362031323a32353a3336, 'pouet@pouet.fr');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
