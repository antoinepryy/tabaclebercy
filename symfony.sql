-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 20 juin 2018 à 15:20
-- Version du serveur :  10.1.28-MariaDB
-- Version de PHP :  7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `tabac` tinyint(1) NOT NULL,
  `accessoires` tinyint(1) NOT NULL,
  `cigaretteElec` tinyint(1) NOT NULL,
  `alcools` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `access`
--

INSERT INTO `access` (`id`, `tabac`, `accessoires`, `cigaretteElec`, `alcools`) VALUES
(1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `onOrder` tinyint(1) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `image` longtext COLLATE utf8_unicode_ci,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `name`, `description`, `price`, `available`, `onOrder`, `brand_id`, `section_id`, `image`, `updated_at`) VALUES
(32, 'Test', 'Ceci est un bel accessoire', '1.00', 1, 1, 2, 16, '5ace135f933ba752228420.jpg', '2018-04-11 15:53:35'),
(34, 'Coucou', 'Ceci est un test', '3.00', 1, 1, 4, 7, '5ad3e0e374d01577614232.png', '2018-04-16 01:31:47'),
(35, 'gvin blan', 'zdzd', '2.00', 1, 1, 5, 13, '5ae1ca3ec731a381161604.jpg', '2018-04-26 14:46:54'),
(37, 'pipe', 'Pipe haut de gamme servant à fumer du tabac de folie', '2.50', 1, 1, 4, 1, '5ae799b41e8b4882842125.jpg', '2018-05-01 00:33:24'),
(40, 'test', 'petite description des familles', '500.00', 0, 0, 4, 1, NULL, '2018-05-02 15:18:40'),
(42, 'aefaefe', 'dvzdvdvzdv', '2.50', 1, 1, 10, 1, '5af9bbf45c18c379108929.jpg', '2018-05-14 18:40:20'),
(43, 'aefaf', 'efzefz', '2.50', 1, 1, 8, 1, '5af9bd9139a86099558791.jpg', '2018-05-14 18:47:13'),
(47, 'briquet signature', 'Briquet de collection haut de gamme ! modèle unique !', '2.50', 0, 0, 14, 8, '5b030aa33f12e949879238.jpg', '2018-05-21 20:06:27'),
(48, 'test CE', 'ADHBAUDHBA', '2.50', 1, 1, 6, 4, '5b0ffa3fa4bb8939631817.jpg', '2018-05-31 15:35:59'),
(49, 'Marlboro', 'aekf,aepkf,ae', '2.50', 1, 1, 4, 4, '5b25177eb17b6970773819.jpg', '2018-06-16 15:58:22');

-- --------------------------------------------------------

--
-- Structure de la table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dispAccessoires` tinyint(1) NOT NULL,
  `dispAlcools` tinyint(1) NOT NULL,
  `dispCigaretteElec` tinyint(1) NOT NULL,
  `dispTabac` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `brand`
--

INSERT INTO `brand` (`id`, `name`, `dispAccessoires`, `dispAlcools`, `dispCigaretteElec`, `dispTabac`) VALUES
(2, 'Camel', 1, 0, 0, 0),
(4, 'Nouvelle Marque', 1, 1, 1, 1),
(5, 'c', 1, 1, 1, 1),
(6, 'Cojucou', 1, 1, 1, 0),
(7, 'test Marque', 1, 1, 1, 1),
(8, 'test', 1, 1, 1, 1),
(10, 'testafarf', 1, 1, 1, 1),
(12, 'azerty', 1, 1, 1, 1),
(13, 'auh', 1, 1, 1, 1),
(14, 'Philip Morris', 1, 1, 1, 1),
(15, 'last Test', 1, 1, 1, 1),
(16, 'last', 1, 0, 0, 0),
(17, 'zerga', 1, 0, 0, 0),
(18, 'dfvsv', 1, 0, 0, 0),
(19, 'dsfsqbq', 1, 0, 0, 0),
(20, 'qfvvfd', 1, 0, 0, 0),
(21, 'qfv', 1, 0, 0, 0),
(22, 'qfsvfbafeb', 1, 0, 0, 0),
(23, 'eféeé', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `infos_contact`
--

CREATE TABLE `infos_contact` (
  `id` int(11) NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `infos_contact`
--

INSERT INTO `infos_contact` (`id`, `phoneNumber`, `email`, `address`) VALUES
(1, '0000000000', 'tabacbercy@gmail.com', '6 Rue de Chambertin, 75012 Paris');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`id`, `datetime`, `ip`) VALUES
(33, '2018-06-12 18:42:37', '::1'),
(34, '2018-06-13 01:15:07', '::1'),
(35, '2018-06-13 17:09:57', '::1'),
(36, '2018-06-14 15:39:41', '::1'),
(37, '2018-06-14 17:39:36', '::1'),
(38, '2018-06-14 21:18:20', '::1'),
(39, '2018-06-16 15:31:07', '::1'),
(40, '2018-06-16 16:13:10', '::1'),
(41, '2018-06-20 13:29:24', '::1');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `name`) VALUES
(1, 'Cigarettes'),
(2, 'Cigares'),
(3, 'Tabac à pipe'),
(4, 'Matériel'),
(5, 'Junior'),
(6, 'Senior'),
(7, 'Liquides'),
(8, 'Briquets'),
(9, 'Pipes'),
(10, 'Autres'),
(11, 'Champagnes'),
(12, 'Vins rouges'),
(13, 'Vins blancs'),
(14, 'Curiosités'),
(15, 'Spiritueux et liqueurs'),
(16, 'Accessoires cigares');

-- --------------------------------------------------------

--
-- Structure de la table `sentence`
--

CREATE TABLE `sentence` (
  `id` int(11) NOT NULL,
  `sentence` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `sentence`
--

INSERT INTO `sentence` (`id`, `sentence`) VALUES
(1, 'Fumer c\'est mal !');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `first_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `password`, `email`, `is_active`, `first_name`, `last_name`, `birth_date`) VALUES
(59, '$2y$13$gHYPM0B2hKRjducljzPU3uSLNaCaZRjBsdBvnLgAmiufewm422EIC', 'test@crypt.com', 1, 'test', 'crypt', '2013-01-01'),
(60, '$2y$13$rYYQ6edsUQ9qsmr/lwRTqOkcO1uATQkmSIYE4X94XWPNNmqSUbLjC', 'admin@admin', 1, 'admin', 'admin', '2013-01-01'),
(61, '$2y$13$ju.e8viK.OWymPX5rnJ8R.Oe.wFeXZ6TgTLoWq5CqJxdSAuzHALzi', 'tabacbercy@gmail.com', 1, 'admin', 'admin', '2013-01-01'),
(63, '$2y$13$LSjtrpQlum5ltY.b7l5s7uJsP5sis8Xsd2T04N0b6VdxyqgFAy8xq', 'abcd@test.com', 1, 'test', 'je', '2015-01-01'),
(64, '$2y$13$9LhX8u2OZADP.OA1VD.1e.6aWrsF1RRRsyxgRtpig3TglBPW6oP8e', 'apiriou@isep.fr', 1, 'amélie', 'piriou', '1981-07-22'),
(66, '$2y$13$yBfIuEOV2k6YQr.IiSpDQ.YF0poFxEs06Lx0hGPe0PgUWC2qdVEbG', 'user@user.com', 1, 'User', 'user', '2001-01-01'),
(67, '$2y$13$gw/FjKKSrQQdnbnf/w4t9Ovlge3ifc9jUwDvayvpNk2EFLHyiP5lO', 'client@client.com', 1, 'abcd', 'abcd', '2001-01-01'),
(68, '$2y$13$33aIEB.RrefU7Hk5D0FiPeWMU.lpmBHEZ00e50q/pksZSfeO7kkzq', 'antoine.ap.57@gmail.com', 1, 'Antoine', 'Perry', '2001-01-01'),
(69, '$2y$13$UknAU40OK8hiRQ4ysJT3AeAJmYltf5fFGP0WXlYls1KZc2RalALAO', 'jean@jean.fr', 1, 'jean', 'eudes', '1931-01-01'),
(70, '$2y$13$KjzyKmQQInmbJOjppcNC3u8cN2N4z414zR1svRMNRxu0bYPSWCfiO', 'pass@pass.com', 1, 'client@client.com', 'zefefe', '2001-01-01'),
(71, '$2y$13$cVGSCVcbE9zW6ZAoNkzssOogrk1vMVMGfdMDwJIkV7SkSJ9Ln90F.', 'jeanpaul@gmail.com', 0, 'Jean', 'Paul', '1958-10-10'),
(72, '$2y$13$BQpvANo8fNcmwWUHWj6wMOiG7CdHVqWgjaG9T.Ja5boTxuCsu4N/S', 'sylv@mail.com', 1, 'Sylviana', 'Mialisao', '1994-01-01'),
(73, '$2y$13$gb.krpuocV01gHbZF08ynugXV0gAMBld0P4FSiJSffl85z1h6Mv8K', 'fjo@gmail.com', 0, 'as', 'as', '2001-01-01'),
(74, '$2y$13$RMvBFk190NCZ8TTzVJQixOoNNGdSNC0sbcl.PGvfbtXPy5zP4E5M.', 'aazd@mail.com', 0, 'sefg', 'gazrg', '2001-01-01'),
(76, '$2y$13$AsMsqMtYYdsVlSaNH6mW5OgBjNLkjhI9TSxNcTLAwxwCH1LIG3to6', 'user2@user2.com', 1, 'user', 'user', '2001-01-01');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E6644F5D008` (`brand_id`),
  ADD KEY `IDX_23A0E66D823E37A` (`section_id`);

--
-- Index pour la table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1C52F9585E237E06` (`name`);

--
-- Index pour la table `infos_contact`
--
ALTER TABLE `infos_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sentence`
--
ALTER TABLE `sentence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `infos_contact`
--
ALTER TABLE `infos_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `sentence`
--
ALTER TABLE `sentence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E6644F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_23A0E66D823E37A` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
