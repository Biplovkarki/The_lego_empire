-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 11:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legoempire`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_data`
--

CREATE TABLE `admin_data` (
  `adminId` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_data`
--

INSERT INTO `admin_data` (`adminId`, `name`, `phone`, `email`, `password`) VALUES
(1, 'Admin', 9800000000, 'admin@gmail.com', '$2y$10$QtQfLap.LlrNtwiQVy6HmurYqMicVS1eQYr7HbkaygSogytUhAWuW');

-- --------------------------------------------------------

--
-- Table structure for table `article_data`
--

CREATE TABLE `article_data` (
  `articleId` int(11) NOT NULL,
  `title` text NOT NULL,
  `subtext` text NOT NULL,
  `description` text NOT NULL,
  `remdescription` text NOT NULL,
  `mainimage` text NOT NULL,
  `displayimage` text NOT NULL,
  `imageone` text NOT NULL,
  `imagetwo` text NOT NULL,
  `imagethree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article_data`
--

INSERT INTO `article_data` (`articleId`, `title`, `subtext`, `description`, `remdescription`, `mainimage`, `displayimage`, `imageone`, `imagetwo`, `imagethree`) VALUES
(1, 'Vikings return! Why the new LEGO® Ideas Viking Village was worth the wait', 'Step into a world of Nordic legends and myths with our latest LEGO® Ideas set. Our LEGO designers tell you everything you need to know...', 'Pop culture and movies catapulted stories of Nordic adventures into the mainstream, and unbeknownst to some, this popularity of the Vikings crossed over in the LEGO® brick world too. In fact, it wasn’t that long ago that these ocean-going Scandinavian explorers had their own range of LEGO sets. The LEGO Vikings line, released in the mid-2000s, featured a range of Vikings defending their fortresses and ships from terrifying creatures inspired by the elaborate and rich world of Nordic mythology. Ever since that line ended, there has been a distinctly Viking-shaped hole in the hearts of many LEGO fans and designers worldwide. Well, now the Vikings are back, bigger and better than ever, and to celebrate, we met the design team behind the Nordic-inspired new set.', 'The LEGO Viking Village began life on LEGO Ideas, the fan-generated ideas platform. It came from the mind of fan designer BrickHammer, who worked closely with the team through the development of this set. Jordan Scott, a design manager at LEGO Ideas, tells us the whole story. “The first Viking Village iteration got 10,000 votes (this is what you need for your idea to be considered), but when it went into review, other products were chosen for production,” says Jordan. “But the Viking theme is very popular, so when Target wanted to do a new set, we suggested some sets that had reached 10,000 votes but weren’t approved. This one was up against a few others in a public vote, but – in the end – this won.” And so, the Viking set has the rare honor of being voted for not once but twice. Once victorious, our expert LEGO design teams set to task to elaborate and bring the original fan vision to life.<br><br>“I did a lot of research on clothing styles and what kind of materials and colors they were using,” says Johanna Wurm Jensen, graphic designer on the project. Johanna was responsible for designing the shields’ elaborate iconography and the minifigures’ clothing. “We imagined how Vikings would have dressed and tried to include small detailing on the jewelry and necklaces that were common in the era. We also tried to use colors to create a natural theme.” <br><br>“I really love the shields! They bring a new color combination; we had never had a green-and-yellow shield before, and the intricate printed details on them worked out very well.” While they tried to keep the set more on the realistic side, there are some fun nods to mythology with fantastical elements. For example, Vikings didn’t actually have horns on their helmets! They also included some tributes to classic Viking sets of the past, including a dragon logo from the original theme, which has been used on the runestone and barrels, plus a little Easter egg to pay homage to the original fan designer (try to spot it). <br><br>It’s wonderful to welcome the Vikings back into the LEGO set line-up, and we think that fans both old and new will love building the LEGO Ideas Viking Village. In stories, songs, films and LEGO sets, Vikings have been going strong for over eight hundred years. There’s no reason why they should stop now.', 'viking-news.jpg', 'viking-display.jpg', 'viking-one.jpeg', 'viking-two.jpeg', 'viking-three.jpeg'),
(2, 'LEGO® Star Wars™ Black Friday Sets', 'May the Force be with you this Black Friday! Channel your inner Jedi with LEGO® Star Wars™ building toys for all ages and abilities, guaranteed to bring that \"galaxy far, far away\" much closer.', 'Ready your Lightsabers and prepare for an epic Black Friday adventure to across the galaxy!\n\nWhether you’re recreating iconic scenes from the saga or teaming up with beloved characters like Luke Skywalker, Princess Leia, the Mandalorian™, Ahsoka Tano and more, our collection of LEGO® Star Wars™ building sets has something for fans of all ages and skill levels.\n\nDiscover our best LEGO® Star Wars™ sets for Black Friday below!', 'From the swamps of Dagobah™ to the halls of the infamous Death Star, our collection of LEGO® Star Wars™ dioramas puts adult fans right at the heart of iconic scenes from the saga. Each diorama depicts action from recognizable Star Wars™ locations, complete with authentic details to bring the display to life. Join Luke Skywalker, Han Solo, Princess Leia and Chewbacca to escape the Death Star’s trash compactor, complete Jedi training alongside Luke and Yoda on Dagobah, or fly through the forests of Endor™ on a speeder bike. Whichever scene you choose to recreate, a rewarding and nostalgic building experience awaits! LEGO minifigures of beloved Star Wars™ characters accompany the dioramas, as well as plaques inscribed with legendary lines like Luke’s “I am a Jedi, like my father before me” and Darth Vader’s “The Force is strong with this one”. With 5 breathtaking diorama models available, this Black Friday is the perfect time to start collecting – or add exciting new scenes to a growing collection of LEGO® Star Wars™ sets! <br><br>Another spectacular addition to the LEGO® Star Wars™ Ultimate Collector Series, this build-and-display model of a Republic Gunship lets fans relive the Battle of Geonosis in glorious detail.  The 3,292-piece set is filled with authentic features, including pilot cockpits, swing-out spherical gun turrets, 2 cannons, super-long wings, opening sides and rear hatch, and interior details. Plus, the display stand features an information plaque and space for the 2 included LEGO® minifigures: a clone trooper Commander and legendary Jedi Master Mace Windu!  Gear up, assemble your troops, and create memories that will last a lifetime with the Ultimate Collector Series Republic Gunship. <br><br>Whether you’re a valiant rebel fighter or a temptingly powerful Sith Lord, there’s no better way to showcase your loyalty – or demonstrate your LEGO building prowess – than with our range of beautifully crafted LEGO® Star Wars™ Helmets.  Show your respect for a fearless 501st Legion Clone Commander with the build-and-display Captain Rex Helmet (75349) model, straight out of Star Wars: The Clone Wars™ and into your hands. Capture the smooth metallic sheen of beskar armor as you build a stunning LEGO recreation of the Mandalorian’s™ helmet (75328), and pair it with a buildable Dark Trooper Helmet (75343) as seen in Star Wars: The Mandalorian™ Season 2.  Prepare to take on the Empire with the Luke Skywalker (Red Five) Helmet (75327) – or if you\'re yearning for the dark side, let our menacing replica of the mighty Darth Vader™ Helmet (75305) be your ultimate symbol of power. <br><br> No matter which iconic helmet calls your name, each of these strikingly detailed build-and-display models are guaranteed to bring some serious Star Wars™ style into any home.', 'starwars-news.jpg', 'starwars-display.jpg', 'starwars-one.jpeg', 'starwars-two.jpg', 'starwars-three.jpeg'),
(3, 'Best Halloween Gifts for Kids & Adults', 'Explore haunted hideouts and face fearsome creatures with the very best LEGO® Halloween gifts for kids and adults!', 'Get your cauldron brewing and prepare for a ghoulishly good time with the very best LEGO® Halloween gifts for kids and adults!\n\nWhether you\'re looking to surprise a loved one with a bewitching building set, or searching for the perfect Halloween toys for goodie bags, we\'ve got you covered with these fantastic treats. And with a wide variety of builds that are ideal for kids and parents to build together too, there’s plenty of opportunity to create a magical Halloween for your family.\n\nFrom haunted hideouts to bone-chilling monster trucks, these LEGO sets will send shivers of excitement down everyone’s spines.', 'Give the cute Baby Groot a gruesome Halloween makeover with the LEGO® Marvel Venomized Groot figure, oozing eerie features from head to toe. Marvel fans aged 10 and up can delight in bringing this Venomized version of Baby Groot to life, altering the appearance with more bricks as the alien Venom fully takes over. Venom’s grisly long tongue, razor-sharp teeth and terrifying tentacles complete the transformation, making a truly frightful figure! Featuring movable arms, legs, hips and head, this Venomized Groot figure is a great Halloween gift for kids aged 10+ and young adults who love Marvel.<br><br>\nFans of Disney’s The Haunted Mansion ride can recreate its chilling atmosphere in their own home with this scarily good miniature model. Feel the thrill as you build and spot details from the ride, including the ghoulishly entertaining dining room, chandelier and gallery. Keep a keen eye out for recognizable paintings of the Hitchhiking Ghosts, Madame Leota and the Gravekeeper too, as well as an exclusive Butler minifigure to watch over the eerie house. Full of ghostly fun and scary surprises, this model is perfect for both play and display, making it a spine-tingling treat for fans aged 12 and up this Halloween.<br><br>\nFor young fans of the hugely popular video game Minecraft®, there’s no better way to celebrate Halloween than with bone-chilling LEGO® Minecraft® sets packed with creepy characters and captivating features to explore! Kids aged 8+ can pay a visit to The Pumpkin Farm (21248), building a cozy pumpkin-shaped house and tending to the pumpkin patch before teaming up with hero Steve to fend off a fearsome witch. But the adventure doesn’t end there – they can also continue their journey to The Skeleton Dungeon (21189) and take on scary skeletons, journeying through stalagmites and stalactites to reach the dungeon and defeat the malicious mobs.<br><br>\n And for players aged 10 and up, there\'s an extra treat in store. They can take home their very own version of the game\'s most iconic hostile mob with the LEGO BrickHeadz™ Zombie (40626), building and displaying the frightful figure in all its blocky glory!', 'halloween-news.jpg', 'halloween-display.jpg', 'halloween-one.jpeg', 'halloween-two.jpeg', 'halloween-three.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `cart_data`
--

CREATE TABLE `cart_data` (
  `itemId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `legoId` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lego_data`
--

CREATE TABLE `lego_data` (
  `legoId` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` text NOT NULL,
  `category` varchar(55) NOT NULL,
  `age` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `itemNumber` int(11) NOT NULL,
  `specifications` text NOT NULL,
  `specificationspoint` text NOT NULL,
  `titleone` text NOT NULL,
  `titletwo` text NOT NULL,
  `titlethree` text NOT NULL,
  `mainimage` text NOT NULL,
  `secondaryimage` text NOT NULL,
  `imageone` text NOT NULL,
  `imagetwo` text NOT NULL,
  `imagethree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lego_data`
--

INSERT INTO `lego_data` (`legoId`, `title`, `price`, `stock`, `category`, `age`, `pieces`, `points`, `itemNumber`, `specifications`, `specificationspoint`, `titleone`, `titletwo`, `titlethree`, `mainimage`, `secondaryimage`, `imageone`, `imagetwo`, `imagethree`) VALUES
(1, 'LEGO® Minifigures Marvel Series 2', 700, '8', 'Marvel', 15, 795, 650, 5545, 'LEGO® Marvel Endgame Final Battle (76266) recreates the ultimate showdown from Marvel Studios’ Avengers: Endgame. 6 Super Heroes take on the foremost super villain in a 360-degree playset created for kids aged 10 and up.<br><br>\r\n\r\nMultifaceted Marvel action<br>\r\nKids join an iconic cast in a playset packed with innovative features and movie-accurate details. 7 characters are included – Captain Marvel, Okoye, Wanda Maximoff, Shuri, Valkyrie, Thanos and The Wasp. The action takes place among the ruins of the Avengers’ compound. The authentically detailed battleground contains lots of places to attach the minifigures, plus hidden surprises for kids to discover: Captain America\'s shield, Thor\'s hammer, the time stone and the portal-opening rat. Pulling on a pair of built-in handles causes the battleground to expand for even more adventures! For added digital fun, builders can zoom in, rotate sets in 3D and track their progress using the fun, intuitive LEGO Builder app.', 'Avengers battle action – LEGO® Marvel Endgame Final Battle (76266) recreates the decisive showdown at the end of Marvel Studios’ Avengers: Endgame with classic characters in an inspiring setting\r\nFamous minifigures – The set includes Captain Marvel, Okoye, Wanda Maximoff, Shuri and Valkyrie minifigures, plus a Thanos big figure and The Wasp microfigure\r\nMany ways to play – There are lots of places to attach the minifigures around the highly detailed, 360-degree battleground, which also reconfigures to a more shelf-friendly, linear design\r\nHidden surprises – Iconic items from the Marvel Avengers movies are concealed within the set for kids to discover: Captain America\'s Shield, Thor\'s hammer, the time stone and the portal-opening rat\r\nGift for Marvel movie fans – Give this multifaceted playset as a birthday, holiday or any-day gift to a young Super Hero aged 10 and up', 'Marvel Heroes Unite!', 'Recreate scenes from Hawkeye', 'A Hero and his alter ego', 'marvel-main.jpg', 'marvel-sec.jpg', 'marvel-one.jpg', 'marvel-two.jpg', 'marvel-three.jpg'),
(2, 'Endgame Final Battle', 800, '51', 'Marvel', 10, 795, 650, 6045, 'LEGO® Marvel Endgame Final Battle (76266) recreates the ultimate showdown from Marvel Studios’ Avengers: Endgame. 6 Super Heroes take on the foremost super villain in a 360-degree playset created for kids aged 10 and up.<br><br>\r\n\r\nMultifaceted Marvel action<br>\r\nKids join an iconic cast in a playset packed with innovative features and movie-accurate details. 7 characters are included – Captain Marvel, Okoye, Wanda Maximoff, Shuri, Valkyrie, Thanos and The Wasp. The action takes place among the ruins of the Avengers’ compound. The authentically detailed battleground contains lots of places to attach the minifigures, plus hidden surprises for kids to discover: Captain America\'s shield, Thor\'s hammer, the time stone and the portal-opening rat. Pulling on a pair of built-in handles causes the battleground to expand for even more adventures! For added digital fun, builders can zoom in, rotate sets in 3D and track their progress using the fun, intuitive LEGO Builder app.', 'Avengers battle action – LEGO® Marvel Endgame Final Battle (76266) recreates the decisive showdown at the end of Marvel Studios’ Avengers: Endgame with classic characters in an inspiring setting\r\nFamous minifigures – The set includes Captain Marvel, Okoye, Wanda Maximoff, Shuri and Valkyrie minifigures, plus a Thanos big figure and The Wasp microfigure\r\nMany ways to play – There are lots of places to attach the minifigures around the highly detailed, 360-degree battleground, which also reconfigures to a more shelf-friendly, linear design\r\nHidden surprises – Iconic items from the Marvel Avengers movies are concealed within the set for kids to discover: Captain America\'s Shield, Thor\'s hammer, the time stone and the portal-opening rat\r\nGift for Marvel movie fans – Give this multifaceted playset as a birthday, holiday or any-day gift to a young Super Hero aged 10 and up', 'Iconic location', 'Hidden surprises', 'Expandable fun', 'marvel-main.jpg', 'marvel-sec.jpg', 'marvel-one.jpg', 'marvel-two.jpg', 'marvel-three.jpg'),
(3, 'Endgame Final Battle', 750, '45', 'Marvel', 10, 795, 650, 5555, 'LEGO® Marvel Endgame Final Battle (76266) recreates the ultimate showdown from Marvel Studios’ Avengers: Endgame. 6 Super Heroes take on the foremost super villain in a 360-degree playset created for kids aged 10 and up.<br><br>\r\n\r\nMultifaceted Marvel action<br>\r\nKids join an iconic cast in a playset packed with innovative features and movie-accurate details. 7 characters are included – Captain Marvel, Okoye, Wanda Maximoff, Shuri, Valkyrie, Thanos and The Wasp. The action takes place among the ruins of the Avengers’ compound. The authentically detailed battleground contains lots of places to attach the minifigures, plus hidden surprises for kids to discover: Captain America\'s shield, Thor\'s hammer, the time stone and the portal-opening rat. Pulling on a pair of built-in handles causes the battleground to expand for even more adventures! For added digital fun, builders can zoom in, rotate sets in 3D and track their progress using the fun, intuitive LEGO Builder app.', 'Avengers battle action – LEGO® Marvel Endgame Final Battle (76266) recreates the decisive showdown at the end of Marvel Studios’ Avengers: Endgame with classic characters in an inspiring setting\r\nFamous minifigures – The set includes Captain Marvel, Okoye, Wanda Maximoff, Shuri and Valkyrie minifigures, plus a Thanos big figure and The Wasp microfigure\r\nMany ways to play – There are lots of places to attach the minifigures around the highly detailed, 360-degree battleground, which also reconfigures to a more shelf-friendly, linear design\r\nHidden surprises – Iconic items from the Marvel Avengers movies are concealed within the set for kids to discover: Captain America\'s Shield, Thor\'s hammer, the time stone and the portal-opening rat\r\nGift for Marvel movie fans – Give this multifaceted playset as a birthday, holiday or any-day gift to a young Super Hero aged 10 and up', 'Iconic location', 'Hidden surprises', 'Expandable fun', 'marvel-main.jpg', 'marvel-sec.jpg', 'marvel-one.jpg', 'marvel-two.jpg', 'marvel-three.jpg'),
(4, 'Endgame Final Battle', 555, '36', 'Marvel', 10, 795, 650, 7555, 'LEGO® Marvel Endgame Final Battle (76266) recreates the ultimate showdown from Marvel Studios’ Avengers: Endgame. 6 Super Heroes take on the foremost super villain in a 360-degree playset created for kids aged 10 and up.<br><br>\r\n\r\nMultifaceted Marvel action<br>\r\nKids join an iconic cast in a playset packed with innovative features and movie-accurate details. 7 characters are included – Captain Marvel, Okoye, Wanda Maximoff, Shuri, Valkyrie, Thanos and The Wasp. The action takes place among the ruins of the Avengers’ compound. The authentically detailed battleground contains lots of places to attach the minifigures, plus hidden surprises for kids to discover: Captain America\'s shield, Thor\'s hammer, the time stone and the portal-opening rat. Pulling on a pair of built-in handles causes the battleground to expand for even more adventures! For added digital fun, builders can zoom in, rotate sets in 3D and track their progress using the fun, intuitive LEGO Builder app.', 'Avengers battle action – LEGO® Marvel Endgame Final Battle (76266) recreates the decisive showdown at the end of Marvel Studios’ Avengers: Endgame with classic characters in an inspiring setting\r\nFamous minifigures – The set includes Captain Marvel, Okoye, Wanda Maximoff, Shuri and Valkyrie minifigures, plus a Thanos big figure and The Wasp microfigure\r\nMany ways to play – There are lots of places to attach the minifigures around the highly detailed, 360-degree battleground, which also reconfigures to a more shelf-friendly, linear design\r\nHidden surprises – Iconic items from the Marvel Avengers movies are concealed within the set for kids to discover: Captain America\'s Shield, Thor\'s hammer, the time stone and the portal-opening rat\r\nGift for Marvel movie fans – Give this multifaceted playset as a birthday, holiday or any-day gift to a young Super Hero aged 10 and up', 'Iconic location', 'Hidden surprises', 'Expandable fun', 'marvel-main.jpg', 'marvel-sec.jpg', 'marvel-one.jpg', 'marvel-two.jpg', 'marvel-three.jpg'),
(5, 'Endgame Final Battle', 900, '41', 'Marvel', 10, 795, 650, 6969, 'LEGO® Marvel Endgame Final Battle (76266) recreates the ultimate showdown from Marvel Studios’ Avengers: Endgame. 6 Super Heroes take on the foremost super villain in a 360-degree playset created for kids aged 10 and up.<br><br>\r\n\r\nMultifaceted Marvel action<br>\r\nKids join an iconic cast in a playset packed with innovative features and movie-accurate details. 7 characters are included – Captain Marvel, Okoye, Wanda Maximoff, Shuri, Valkyrie, Thanos and The Wasp. The action takes place among the ruins of the Avengers’ compound. The authentically detailed battleground contains lots of places to attach the minifigures, plus hidden surprises for kids to discover: Captain America\'s shield, Thor\'s hammer, the time stone and the portal-opening rat. Pulling on a pair of built-in handles causes the battleground to expand for even more adventures! For added digital fun, builders can zoom in, rotate sets in 3D and track their progress using the fun, intuitive LEGO Builder app.', 'Avengers battle action – LEGO® Marvel Endgame Final Battle (76266) recreates the decisive showdown at the end of Marvel Studios’ Avengers: Endgame with classic characters in an inspiring setting\r\nFamous minifigures – The set includes Captain Marvel, Okoye, Wanda Maximoff, Shuri and Valkyrie minifigures, plus a Thanos big figure and The Wasp microfigure\r\nMany ways to play – There are lots of places to attach the minifigures around the highly detailed, 360-degree battleground, which also reconfigures to a more shelf-friendly, linear design\r\nHidden surprises – Iconic items from the Marvel Avengers movies are concealed within the set for kids to discover: Captain America\'s Shield, Thor\'s hammer, the time stone and the portal-opening rat\r\nGift for Marvel movie fans – Give this multifaceted playset as a birthday, holiday or any-day gift to a young Super Hero aged 10 and up', 'Iconic location', 'Hidden surprises', 'Expandable fun', 'marvel-main.jpg', 'marvel-sec.jpg', 'marvel-one.jpg', 'marvel-two.jpg', 'marvel-three.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lego_rating`
--

CREATE TABLE `lego_rating` (
  `ratingId` int(11) NOT NULL,
  `legoId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lego_rating`
--

INSERT INTO `lego_rating` (`ratingId`, `legoId`, `userId`, `rating`, `review`) VALUES
(1, 3, 1, 3, ''),
(2, 4, 1, 4, ''),
(3, 5, 1, 5, ''),
(4, 2, 1, 4, ''),
(5, 1, 1, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `legoId` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transactionId` varchar(100) NOT NULL,
  `status` text NOT NULL,
  `delieverStatus` varchar(55) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`orderId`, `userId`, `legoId`, `title`, `price`, `quantity`, `transactionId`, `status`, `delieverStatus`) VALUES
(1, 1, 1, 'LEGO® Minifigures Marvel Series 2', 700, 1, 'ukY9Wb3vsuWgnMsP69amCe', 'Paid', 'Delivered'),
(2, 1, 4, 'Endgame Final Battle', 555, 1, 'Pmo57mAytEWCXHz9wrzbeD', 'Paid', 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `profile_data`
--

CREATE TABLE `profile_data` (
  `userId` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `landmark` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_data`
--

INSERT INTO `profile_data` (`userId`, `name`, `phone`, `email`, `landmark`, `address`, `area`, `city`, `province`) VALUES
(1, 'User', 9800000000, 'user@gmail.com', 'Near KUSOM', 'Deko Marg', 'Gwarko', 'Lalitpur', 'Bagmati');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `userId` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`userId`, `name`, `phone`, `email`, `password`) VALUES
(1, 'User', 9800000000, 'user@gmail.com', '$2y$10$FT9dpP.MLlMY6rNfpvnlyOr7.EkAUOue.zpMixkJD7Y.BIx/F7CHO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_data`
--
ALTER TABLE `admin_data`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `article_data`
--
ALTER TABLE `article_data`
  ADD PRIMARY KEY (`articleId`);

--
-- Indexes for table `cart_data`
--
ALTER TABLE `cart_data`
  ADD PRIMARY KEY (`itemId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `legoId` (`legoId`);

--
-- Indexes for table `lego_data`
--
ALTER TABLE `lego_data`
  ADD PRIMARY KEY (`legoId`);

--
-- Indexes for table `lego_rating`
--
ALTER TABLE `lego_rating`
  ADD PRIMARY KEY (`ratingId`),
  ADD KEY `legoId` (`legoId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `profile_data`
--
ALTER TABLE `profile_data`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_data`
--
ALTER TABLE `admin_data`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `article_data`
--
ALTER TABLE `article_data`
  MODIFY `articleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_data`
--
ALTER TABLE `cart_data`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lego_data`
--
ALTER TABLE `lego_data`
  MODIFY `legoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lego_rating`
--
ALTER TABLE `lego_rating`
  MODIFY `ratingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_data`
--
ALTER TABLE `order_data`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profile_data`
--
ALTER TABLE `profile_data`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_data`
--
ALTER TABLE `cart_data`
  ADD CONSTRAINT `cart_data_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`),
  ADD CONSTRAINT `cart_data_ibfk_2` FOREIGN KEY (`legoId`) REFERENCES `lego_data` (`legoId`);

--
-- Constraints for table `lego_rating`
--
ALTER TABLE `lego_rating`
  ADD CONSTRAINT `lego_rating_ibfk_1` FOREIGN KEY (`legoId`) REFERENCES `lego_data` (`legoId`),
  ADD CONSTRAINT `lego_rating_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
