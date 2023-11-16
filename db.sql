SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(60) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `avatar` (
  `user_id` int(255) NOT NULL,
  `head_color` varchar(6) NOT NULL,
  `torso_color` varchar(6) NOT NULL,
  `right_arm_color` varchar(6) NOT NULL,
  `left_arm_color` varchar(6) NOT NULL,
  `right_leg_color` varchar(6) NOT NULL,
  `left_leg_color` varchar(6) NOT NULL,
  `face` int(11) NOT NULL DEFAULT 0,
  `shirt` int(255) NOT NULL DEFAULT 0,
  `pants` int(255) NOT NULL DEFAULT 0,
  `tshirt` int(255) NOT NULL DEFAULT 0,
  `hat1` int(11) NOT NULL DEFAULT 0,
  `hat2` int(11) NOT NULL DEFAULT 0,
  `hat3` int(11) NOT NULL DEFAULT 0,
  `hat4` int(11) NOT NULL DEFAULT 0,
  `hat5` int(11) NOT NULL DEFAULT 0,
  `tool` int(11) NOT NULL DEFAULT 0,
  `head` int(11) NOT NULL DEFAULT 0,
  `cache` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `awards` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `beta_users` (
  `id` int(11) NOT NULL,
  `username` varchar(26) NOT NULL,
  `usernameL` varchar(100) NOT NULL,
  `password` varchar(70) NOT NULL,
  `IP` varchar(46) NOT NULL,
  `birth` date NOT NULL,
  `gender` enum('male','female','hidden') NOT NULL DEFAULT 'hidden',
  `date` date DEFAULT NULL,
  `last_online` datetime NOT NULL,
  `daily_bits` datetime NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `views` int(11) NOT NULL,
  `bucks` int(11) NOT NULL DEFAULT 1,
  `bits` int(11) NOT NULL DEFAULT 10,
  `primary_group` int(11) DEFAULT -1,
  `power` int(1) NOT NULL DEFAULT 0,
  `avatar_id` int(11) NOT NULL,
  `unique_key` varchar(20) NOT NULL,
  `theme` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `clans` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(26) NOT NULL,
  `tag` varchar(4) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `members` int(11) NOT NULL,
  `approved` enum('yes','no','declined') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `clans_members` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rank` int(2) NOT NULL DEFAULT 1,
  `status` enum('in','out','banned') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `clans_ranks` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `power` int(3) NOT NULL,
  `name` varchar(26) NOT NULL,
  `perm_ranks` enum('yes','no') NOT NULL,
  `perm_posts` enum('yes','no') NOT NULL,
  `perm_members` enum('yes','no') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `clans_walls` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `post` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `type` enum('pinned','normal','deleted') NOT NULL DEFAULT 'normal'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `clans_walls` (`id`, `group_id`, `owner_id`, `post`, `time`, `type`) VALUES
(1, 1, 1, 'test', '2022-12-12 16:15:00', 'normal'),
(2, 1, 1, '<script>alert(\'lmfaoooo\');</script>', '2022-12-21 16:33:35', 'normal');

CREATE TABLE `crate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `serial` int(11) NOT NULL DEFAULT 0,
  `payment` enum('bits','bucks') NOT NULL DEFAULT 'bits',
  `price` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `own` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verified` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `forum_boards` (
  `id` int(11) NOT NULL,
  `name` varchar(26) NOT NULL,
  `description` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `forum_posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `forum_threads` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `pinned` enum('yes','no') NOT NULL DEFAULT 'no',
  `deleted` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `views` int(11) NOT NULL,
  `latest_post` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `creator_id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `playing` int(6) NOT NULL DEFAULT 0,
  `visits` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(15) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `creator_id` int(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `type` enum('hat','shirt') NOT NULL,
  `robux` int(11) NOT NULL,
  `tickets` int(11) NOT NULL,
  `method` enum('free','both','robux','tickets','offsale') NOT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `item_comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership` int(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `length` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `membership_values` (
  `value` int(11) NOT NULL,
  `name` varchar(12) NOT NULL,
  `daily_bucks` int(11) NOT NULL,
  `sets` int(11) NOT NULL,
  `items` int(1) NOT NULL,
  `create_clans` int(2) NOT NULL,
  `join_clans` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `membership_values` (`value`, `name`, `daily_bucks`, `sets`, `items`, `create_clans`, `join_clans`) VALUES
(1, 'verified', 5, 99, 0, 99, 99);

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `author_id` varchar(26) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(52) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `read` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `misc` (
  `featured_game_id` varchar(1) NOT NULL,
  `alert` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `moderation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_note` text NOT NULL,
  `issued` datetime NOT NULL,
  `length` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `quests` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `replies` int(11) NOT NULL,
  `bucks` int(11) NOT NULL,
  `friends` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `l_upd` datetime NOT NULL DEFAULT current_timestamp(),
  `done` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `quests`
--

INSERT INTO `quests` (`id`, `uid`, `name`, `replies`, `bucks`, `friends`, `item`, `l_upd`, `done`) VALUES
(0, 1, 'Stylish Forumer!', 10, 0, 0, 36, '2023-01-17 17:34:41', 1),
(1, 1, 'friendship!', 0, 0, 5, 5, '2023-01-15 23:54:29', 1),
(2, 2, 'test the second (get 5 replies)', 5, 0, 5, 37, '2023-01-16 00:09:56', 0),
(3, 1, 'rich man', 0, 999, 0, 37, '2023-01-17 18:18:08', 1);

CREATE TABLE `reg_keys` (
  `id` int(255) NOT NULL,
  `key_content` varchar(1000) NOT NULL,
  `used` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `r_type` varchar(10) NOT NULL,
  `r_id` int(11) NOT NULL,
  `r_reason` text DEFAULT NULL,
  `seen` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `shop_items` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(52) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `bucks` int(11) NOT NULL DEFAULT -1,
  `bits` int(11) NOT NULL DEFAULT -1,
  `type` varchar(10) NOT NULL COMMENT 'HAT | FACE | TOOL | SHIRT | TSHIRT | PANTS | HEAD',
  `date` date NOT NULL,
  `last_updated` date NOT NULL,
  `offsale` enum('yes','no') NOT NULL DEFAULT 'no',
  `collectible` enum('yes','no') NOT NULL DEFAULT 'no',
  `collectable-edition` enum('yes','no') NOT NULL DEFAULT 'no',
  `collectible_q` int(11) NOT NULL DEFAULT 0,
  `zoom` varchar(11) DEFAULT NULL,
  `approved` enum('yes','no','declined') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `special_sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `serial` int(11) NOT NULL,
  `bucks` int(11) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `body` varchar(124) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `crap` varchar(60) NOT NULL,
  `uid` int(11) NOT NULL,
  `l_upd` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`id`, `crap`, `uid`, `l_upd`) VALUES
(1, 'test', 1, '2023-01-13 13:56:51'),
(2, 'wtf', 1, '2023-01-13 14:01:26'),
(3, '', 1, '2023-01-13 14:02:11'),
(4, 'testset', 1, '2023-01-13 14:02:34'),
(5, '', 1, '2023-01-13 14:02:47');

-- --------------------------------------------------------

--
-- Структура таблицы `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `theme selected` enum('defualt','theme1') NOT NULL DEFAULT 'defualt'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `trades`
--

CREATE TABLE `trades` (
  `tradeid` int(11) NOT NULL,
  `tradesender` int(11) NOT NULL,
  `tradereceiver` int(11) NOT NULL,
  `decision` int(11) NOT NULL DEFAULT 5,
  `itemget` int(11) NOT NULL,
  `itemsent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- the earliest implementation of trading, without the concept ofc

INSERT INTO `trades` (`tradeid`, `tradesender`, `tradereceiver`, `decision`, `itemget`, `itemsent`) VALUES
(1, 1, 7, 5, 18, 14);

CREATE TABLE `user_rewards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_id` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `avatar`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `beta_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clans`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clans_members`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clans_ranks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clans_walls`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `crate`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_boards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `item_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `membership_values`
  ADD PRIMARY KEY (`value`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `misc`
  ADD KEY `featured_game_id` (`featured_game_id`);

ALTER TABLE `moderation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `quests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `reg_keys`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `shop_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `special_sellers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `trades`
  ADD PRIMARY KEY (`tradeid`);

ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `avatar`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `awards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `beta_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `clans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `clans_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `clans_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `clans_walls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `crate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `forum_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `forum_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `forum_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `item_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `membership_values`
  MODIFY `value` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `moderation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `reg_keys`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `shop_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

ALTER TABLE `special_sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `trades`
  MODIFY `tradeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `user_rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
