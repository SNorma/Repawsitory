-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: repawsitory.c9sl07vbzyiv.us-west-2.rds.amazonaws.com:3306
-- Generation Time: Oct 20, 2018 at 09:32 AM
-- Server version: 5.7.22-log
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(2) NOT NULL,
  `category` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `category`) VALUES
(1, 'Dogs'),
(2, 'Cats');

-- --------------------------------------------------------

--
-- Table structure for table `cat_breeds`
--

CREATE TABLE `cat_breeds` (
  `breed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cat_breeds`
--

INSERT INTO `cat_breeds` (`breed`) VALUES
('Abyssinian'),
('American Bobtail'),
('American Curl'),
('American Shorthair'),
('American Wirehair'),
('Balinese'),
('Bengal'),
('Birman'),
('Bombay'),
('British Shorthair'),
('Burmese'),
('Chartreux'),
('Cornish Rex'),
('Cymric'),
('Devon Rex'),
('Egyptian Mau'),
('Exotic Shorthair'),
('Havana Brown'),
('Himalayan'),
('Japanese Bobtail'),
('Javanese'),
('Korat '),
('Maine Coon'),
('Manx'),
('Munchkin'),
('Nebelung'),
('Norwegian Forest Cat'),
('Ocicat'),
('Oriental'),
('Persian'),
('Ragdoll'),
('Russian Blue'),
('Scottish Fold'),
('Selkirk Rex'),
('Siamese'),
('Siberian'),
('Singapura'),
('Snowshoe'),
('Somali'),
('Sphynx'),
('Tonkinese'),
('Turkish Angora'),
('Turkish Van'),
('Abyssinian'),
('American Bobtail'),
('American Curl'),
('American Shorthair'),
('American Wirehair'),
('Balinese'),
('Bengal'),
('Birman'),
('Bombay'),
('British Shorthair'),
('Burmese'),
('Chartreux'),
('Cornish Rex'),
('Cymric'),
('Devon Rex'),
('Egyptian Mau'),
('Exotic Shorthair'),
('Havana Brown'),
('Himalayan'),
('Japanese Bobtail'),
('Javanese'),
('Korat '),
('Maine Coon'),
('Manx'),
('Munchkin'),
('Nebelung'),
('Norwegian Forest Cat'),
('Ocicat'),
('Oriental'),
('Persian'),
('Ragdoll'),
('Russian Blue'),
('Scottish Fold'),
('Selkirk Rex'),
('Siamese'),
('Siberian'),
('Singapura'),
('Snowshoe'),
('Somali'),
('Sphynx'),
('Tonkinese'),
('Turkish Angora'),
('Turkish Van'),
('Abyssinian'),
('American Bobtail'),
('American Curl'),
('American Shorthair'),
('American Wirehair'),
('Balinese'),
('Bengal'),
('Birman'),
('Bombay'),
('British Shorthair'),
('Burmese'),
('Chartreux'),
('Cornish Rex'),
('Cymric'),
('Devon Rex'),
('Egyptian Mau'),
('Exotic Shorthair'),
('Havana Brown'),
('Himalayan'),
('Japanese Bobtail'),
('Javanese'),
('Korat '),
('Maine Coon'),
('Manx'),
('Munchkin'),
('Nebelung'),
('Norwegian Forest Cat'),
('Ocicat'),
('Oriental'),
('Persian'),
('Ragdoll'),
('Russian Blue'),
('Scottish Fold'),
('Selkirk Rex'),
('Siamese'),
('Siberian'),
('Singapura'),
('Snowshoe'),
('Somali'),
('Sphynx'),
('Tonkinese'),
('Turkish Angora'),
('Turkish Van'),
('Abyssinian'),
('American Bobtail'),
('American Curl'),
('American Shorthair'),
('American Wirehair'),
('Balinese'),
('Bengal'),
('Birman'),
('Bombay'),
('British Shorthair'),
('Burmese'),
('Chartreux'),
('Cornish Rex'),
('Cymric'),
('Devon Rex'),
('Egyptian Mau'),
('Exotic Shorthair'),
('Havana Brown'),
('Himalayan'),
('Japanese Bobtail'),
('Javanese'),
('Korat '),
('Maine Coon'),
('Manx'),
('Munchkin'),
('Nebelung'),
('Norwegian Forest Cat'),
('Ocicat'),
('Oriental'),
('Persian'),
('Ragdoll'),
('Russian Blue'),
('Scottish Fold'),
('Selkirk Rex'),
('Siamese'),
('Siberian'),
('Singapura'),
('Snowshoe'),
('Somali'),
('Sphynx'),
('Tonkinese'),
('Turkish Angora'),
('Turkish Van');

-- --------------------------------------------------------

--
-- Table structure for table `dog_breeds`
--

CREATE TABLE `dog_breeds` (
  `breed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dog_breeds`
--

INSERT INTO `dog_breeds` (`breed`) VALUES
('Affenpinscher'),
('Afghan Hound'),
('Airedale Terrier'),
('Akita'),
('Alaskan Malamute'),
('American English Coonhound'),
('American Eskimo Dog'),
('American Foxhound'),
('American Hairless Terrier'),
('American Leopard Hound'),
('American Staffordshire Terrier'),
('American Water Spaniel'),
('Anatolian Shepherd Dog'),
('Appenzeller Sennenhund'),
('Australian Cattle Dog'),
('Australian Kelpie'),
('Australian Shepherd'),
('Australian Stumpy Tail Cattle Dog'),
('Australian Terrier'),
('Azawakh'),
('Barbet'),
('Basenji'),
('Basset Fauve de Bretagne'),
('Basset Hound'),
('Bavarian Mountain Scent Hound'),
('Beagle'),
('Bearded Collie'),
('Beauceron'),
('Bedlington Terrier'),
('Belgian Laekenois'),
('Belgian Malinois'),
('Belgian Sheepdog'),
('Belgian Tervuren'),
('Bergamasco Sheepdog'),
('Berger Picard'),
('Bernese Mountain Dog'),
('Bichon Frise'),
('Biewer Terrier'),
('Black and Tan Coonhound'),
('Black Russian Terrier'),
('Bloodhound'),
('Bluetick Coonhound'),
('Boerboel'),
('Bolognese'),
('Border Collie'),
('Border Terrier'),
('Borzoi'),
('Boston Terrier'),
('Bouvier des Flandres'),
('Boxer'),
('Boykin Spaniel'),
('Bracco Italiano'),
('Braque du Bourbonnais'),
('Braque Francais Pyrenean'),
('Briard'),
('Brittany'),
('Broholmer'),
('Brussels Griffon'),
('Bull Terrier'),
('Bulldog'),
('Bullmastiff'),
('Cairn Terrier'),
('Canaan Dog'),
('Cane Corso'),
('Cardigan Welsh Corgi'),
('Carolina Dog'),
('Catahoula Leopard Dog'),
('Caucasian Shepherd Dog'),
('Cavalier King Charles Spaniel'),
('Central Asian Shepherd Dog'),
('Cesky Terrier'),
('Chesapeake Bay Retriever'),
('Chihuahua'),
('Chinese Crested'),
('Chinese Shar-Pei'),
('Chinook'),
('Chow Chow'),
('Cirneco dell’Etna'),
('Clumber Spaniel'),
('Cocker Spaniel'),
('Collie'),
('Coton de Tulear'),
('Croatian Sheepdog'),
('Curly-Coated Retriever'),
('Czechoslovakian Vlcak'),
('Dachshund'),
('Dalmatian'),
('Dandie Dinmont Terrier'),
('Danish-Swedish Farmdog'),
('Deutscher Wachtelhund'),
('Doberman Pinscher'),
('Dogo Argentino'),
('Dogue de Bordeaux'),
('Drentsche Patrijshond'),
('Drever'),
('Dutch Shepherd'),
('English Cocker Spaniel'),
('English Foxhound'),
('English Setter'),
('English Springer Spaniel'),
('English Toy Spaniel'),
('Entlebucher Mountain Dog'),
('Estrela Mountain Dog'),
('Eurasier'),
('Field Spaniel'),
('Finnish Lapphund'),
('Finnish Spitz'),
('Flat-Coated Retriever'),
('French Bulldog'),
('French Spaniel'),
('German Longhaired Pointer'),
('German Pinscher'),
('German Shepherd Dog'),
('German Shorthaired Pointer'),
('German Spitz'),
('German Wirehaired Pointer'),
('Giant Schnauzer'),
('Glen of Imaal Terrier'),
('Golden Retriever'),
('Gordon Setter'),
('Grand Basset Griffon Vendéen'),
('Great Dane'),
('Great Pyrenees'),
('Greater Swiss Mountain Dog'),
('Greyhound'),
('Hamiltonstovare'),
('Hanoverian Scenthound'),
('Harrier'),
('Havanese'),
('Hokkaido'),
('Hovawart'),
('Ibizan Hound'),
('Icelandic Sheepdog'),
('Irish Red and White Setter'),
('Irish Setter'),
('Irish Terrier'),
('Irish Water Spaniel'),
('Irish Wolfhound'),
('Italian Greyhound'),
('Jagdterrier'),
('Japanese Chin'),
('Jindo'),
('Kai Ken'),
('Karelian Bear Dog'),
('Keeshond'),
('Kerry Blue Terrier'),
('Kishu Ken'),
('Komondor'),
('Kromfohrlander'),
('Kuvasz'),
('Labrador Retriever'),
('Lagotto Romagnolo'),
('Lakeland Terrier'),
('Lancashire Heeler'),
('Lapponian Herder'),
('Leonberger'),
('Lhasa Apso'),
('Löwchen'),
('Maltese'),
('Manchester Terrier (Standard)'),
('Manchester Terrier (Toy)'),
('Mastiff'),
('Miniature American Shepherd'),
('Miniature Bull Terrier'),
('Miniature Pinscher'),
('Miniature Schnauzer'),
('Mountain Cur'),
('Mudi'),
('Neapolitan Mastiff'),
('Nederlandse Kooikerhondje'),
('Newfoundland'),
('Norfolk Terrier'),
('Norrbottenspets'),
('Norwegian Buhund'),
('Norwegian Elkhound'),
('Norwegian Lundehund'),
('Norwich Terrier'),
('Nova Scotia Duck Tolling Retriever'),
('Old English Sheepdog'),
('Otterhound'),
('Papillon'),
('Parson Russell Terrier'),
('Pekingese'),
('Pembroke Welsh Corgi'),
('Perro de Presa Canario'),
('Peruvian Inca Orchid'),
('Petit Basset Griffon Vendéen'),
('Pharaoh Hound'),
('Plott'),
('Pointer'),
('Polish Lowland Sheepdog'),
('Pomeranian'),
('Poodle (Miniature / Standard)'),
('Poodle (Toy)'),
('Porcelaine'),
('Portuguese Podengo'),
('Portuguese Podengo Pequeno'),
('Portuguese Pointer'),
('Portuguese Sheepdog'),
('Portuguese Water Dog'),
('Pudelpointer'),
('Pug'),
('Puli'),
('Pumi'),
('Pyrenean Mastiff'),
('Pyrenean Shepherd'),
('Rafeiro do Alentejo'),
('Rat Terrier'),
('Redbone Coonhound'),
('Rhodesian Ridgeback'),
('Romanian Mioritic Shepherd Dog'),
('Rottweiler'),
('Russell Terrier'),
('Russian Toy'),
('Russian Tsvetnaya Bolonka'),
('Saint Bernard'),
('Saluki'),
('Samoyed'),
('Schapendoes'),
('Schipperke'),
('cottish Deerhound'),
('Scottish Terrier'),
('Sealyham Terrier'),
('Segugio Italiano'),
('Shetland Sheepdog'),
('Shiba Inu'),
('Shih Tzu'),
('Shikoku'),
('Siberian Husky'),
('Silky Terrier'),
('Skye Terrier'),
('Sloughi'),
('Slovakian Wirehaired Pointer'),
('Slovensky Cuvac'),
('Slovensky Kopov'),
('Small Munsterlander Pointer'),
('Smooth Fox Terrier'),
('Soft Coated Wheaten Terrier'),
('Spanish Mastiff'),
('panish Water Dog'),
('Spinone Italiano'),
('Stabyhoun'),
('Staffordshire Bull Terrier'),
('Standard Schnauzer'),
('Sussex Spaniel'),
('Swedish Lapphund'),
('Swedish Vallhund'),
('Taiwan Dog'),
('Teddy Roosevelt Terrier'),
('hai Ridgeback'),
('Tibetan Mastiff'),
('Tibetan Spaniel'),
('Tibetan Terrier'),
('Tornjak'),
('Tosa'),
('Toy Fox Terrier'),
('Transylvanian Hound'),
('Treeing Tennessee Brindle'),
('Treeing Walker Coonhound'),
('Vizsla'),
('Weimaraner'),
('Welsh Springer Spaniel'),
('Welsh Terrier'),
('West Highland White Terrier'),
('Whippet'),
('Wire Fox Terrier'),
('Wirehaired Pointing Griffon'),
('Wirehaired Vizsla'),
('Working Kelpie'),
('Xoloitzcuintli'),
('Yakutian Laika'),
('Yorkshire Terrier');

-- --------------------------------------------------------

--
-- Table structure for table `lost_pets`
--

CREATE TABLE `lost_pets` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `hair` varchar(20) NOT NULL,
  `age` varchar(20) NOT NULL,
  `size` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `color` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(5) NOT NULL,
  `image` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lost_pets`
--

INSERT INTO `lost_pets` (`id`, `type`, `breed`, `description`, `hair`, `age`, `size`, `gender`, `color`, `city`, `state`, `zip`, `image`) VALUES
(4, '2', 'British Shorthair', 'Found near abc park. ', 'Short', 'Young', 'XSmall', 'Female', 'Gray', 'Seattle', 'WA', 98111, 'Cat-kitten-insurance-for-your-cat_CTA_desktop.jpg'),
(1, '1', 'German Shepherd Dog', 'Speaks German. ', '', 'Teen', '', 'Female', '', 'Edmonds', 'WA', 98026, 'doge.png'),
(5, '1', 'Affenpinscher', 'Found at the store. ', 'Short', 'Young', 'XSmall', 'Male', 'White', 'San Jose', 'CA', 95120, 'foo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adopt`
--

CREATE TABLE `pet_adopt` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `hair` varchar(20) NOT NULL,
  `age` varchar(20) NOT NULL,
  `size` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `color` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(5) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pet_adopt`
--

INSERT INTO `pet_adopt` (`id`, `uid`, `type`, `breed`, `description`, `hair`, `age`, `size`, `gender`, `color`, `name`, `city`, `state`, `zip`, `image`) VALUES
(394, 1, '2', 'Maine Coon', 'Longest whiskers ever!', 'Long', 'Young', 'Large', 'Female', 'Gray', 'Whiskers', 'Kenmore', 'WA', 98028, '1480056003.jpg'),
(395, 1, '2', 'Birman', 'Does the baby deer walk still', 'Medium', 'Young', 'XSmall', 'Female', 'Brown', 'Maple', 'Morgan Hill', 'CA', 95037, '515601914.jpg'),
(396, 1, '1', 'Boxer', 'Gentle and fun dog. ', 'Short', 'Teen', 'Large', 'Male', 'Brown', 'Ali', 'San Jose', 'CA', 98026, '437196770.jpg'),
(397, 1, '1', 'Labrador Retriever', 'Cute as a button', 'Short', 'Young', 'XSmall', 'Female', 'Yellow', 'Mobile', 'Beverly Hills', 'CA', 90210, '2099940709.jpg'),
(398, 1, '1', 'Australian Shepherd', 'Loves playing catch!', 'Long', 'Teen', 'Medium', 'Male', 'Brown', 'Hendrix', 'Edmonds', 'WA', 98026, '71937536.jpg'),
(399, 1, '2', 'Russian Blue', 'Sells gray coats.', 'Medium', 'Adult', 'Medium', 'Female', 'Gray', 'Baby', 'Aptos', 'CA', 95001, '129019251.jpeg'),
(400, 1, '1', 'Siamese', 'Lounges all day long. ', 'Short', 'Adult', 'Medium', 'Male', 'Brown', 'Shorti', 'Monterey', 'CA', 93940, '1111204678.jpeg'),
(401, 1, '2', 'Scottish Fold', 'Too cute to look at', 'Medium', 'Young', 'Small', 'Male', 'Yellow', 'Kilty', 'Santa Cruz', 'CA', 95026, '288907414.jpg'),
(402, 1, '1', 'Australian Cattle Dog', 'Never leaves a fallen stick behind', 'Medium', 'Teen', 'Medium', 'Male', 'Brown', 'Astro', 'St. Charles MO', 'MO', 63303, '252950580.jpg'),
(403, 1, '1', 'Cardigan Welsh Corgi', 'Lowrider', 'Medium', 'Adult', 'Small', 'Female', 'Brown', 'Sailor', 'Palo Alto', 'CA', 94020, '524452219.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `cat_id` int(2) NOT NULL DEFAULT '0',
  `subcategory` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`cat_id`, `subcategory`) VALUES
(2, 'Abyssinian'),
(1, 'Akita'),
(2, 'Bengal'),
(1, 'Boxer'),
(2, 'Chartreux'),
(1, 'Chow'),
(1, 'Dalmation'),
(2, 'Devon Rex');

-- --------------------------------------------------------

--
-- Table structure for table `useroptions`
--

CREATE TABLE `useroptions` (
  `id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(16) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `temp_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useroptions`
--

INSERT INTO `useroptions` (`id`, `username`, `question`, `answer`, `temp_pass`) VALUES
(1, 'Admin', NULL, NULL, ''),
(2, 'Root', NULL, NULL, NULL),
(3, 'norma', NULL, NULL, NULL),
(4, 'galejo', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userlevel` enum('a','b') NOT NULL DEFAULT 'a',
  `ip` varchar(255) NOT NULL,
  `signup` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `notescheck` datetime NOT NULL,
  `activated` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `userlevel`, `ip`, `signup`, `lastlogin`, `notescheck`, `activated`) VALUES
(1, 'Admin', 'steven.c.hunt@gmail.com', '95c72a49c488d59f60c022fcfecf4382', 'b', '76.121.236.246', '2018-10-10 21:13:48', '2018-10-20 08:57:35', '2018-10-10 21:13:48', '1'),
(2, 'Root', 'sthunt@csumb.edu', '3858f62230ac3c915f300c664312c63f', 'a', '76.121.236.246', '2018-10-11 23:10:27', '2018-10-20 09:22:01', '2018-10-11 23:10:27', '1'),
(3, 'norma', 'nosanchez@csumb.edu', 'f96d67490c6bb34ff93924c89e159b03', 'a', '174.85.69.107', '2018-10-20 01:35:20', '2018-10-20 04:27:03', '2018-10-20 01:35:20', '1'),
(4, 'galejo', 'galejo@csumb.edu', '81dc9bdb52d04dc20036dbd8313ed055', 'a', '68.79.198.40', '2018-10-20 04:54:50', '2018-10-20 04:55:16', '2018-10-20 04:54:50', '1');

-- --------------------------------------------------------

--
-- Table structure for table `usersmeta`
--

CREATE TABLE `usersmeta` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` int(5) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersmeta`
--

INSERT INTO `usersmeta` (`id`, `uid`, `username`, `fname`, `lname`, `address1`, `address2`, `city`, `zipcode`, `state`, `phone`, `company`, `avatar`) VALUES
(1, 1, 'Admin', 'Steven', 'Hunt', '5118 144th St. SW', '#B', 'Edmonds', 98026, 'WA', '408966-3290', 'MK13', NULL),
(2, 2, 'Root', 'Steven', 'Hunt', '5118 144th St. SW.', '#B', 'Edmonds', 98026, 'WA', '(408) 966-3290', 'MK12', NULL),
(3, 3, 'norma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'galejo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `lost_pets`
--
ALTER TABLE `lost_pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adopt`
--
ALTER TABLE `pet_adopt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD UNIQUE KEY `subcategory` (`subcategory`);

--
-- Indexes for table `useroptions`
--
ALTER TABLE `useroptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `usersmeta`
--
ALTER TABLE `usersmeta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `lost_pets`
--
ALTER TABLE `lost_pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pet_adopt`
--
ALTER TABLE `pet_adopt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usersmeta`
--
ALTER TABLE `usersmeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
