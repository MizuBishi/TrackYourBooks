SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS Trackit
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;
USE Trackit;


###########################################################################
##### USER TABLE ##########################################################
###########################################################################

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id         INT(11)     NOT NULL AUTO_INCREMENT,
  username   VARCHAR(45) NOT NULL,
  email      VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO users (username, email, password) VALUES
  ('Bookfreak', 'bookfreak@gmail.com', 'bookfreak'),
  ('Buchwurm', 'buchwurm@gmail.com', 'buchwurm');


###########################################################################
##### BOOKS TABLE #########################################################
###########################################################################

DROP TABLE IF EXISTS books;
CREATE TABLE IF NOT EXISTS books (
  id     INT(11)      NOT NULL AUTO_INCREMENT,
  author VARCHAR(255) NOT NULL,
  title  VARCHAR(255) NOT NULL,
  `year` INT(11)               DEFAULT NULL,
  pages  INT(11)      NOT NULL,
  genre  VARCHAR(255)          DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO books (title, author, year, pages, genre) VALUES
  ('Inside IS - 10 Tage im ''Islamischen Staat''', 'Jürgen Todenhöfer', 2015, 288, 'Nonfiction Book'),
  ('Astronomie', 'August Ferdinand Möbius', 2000, 176, 'Nonfiction Book'),
  ('Sagen des klassischen Altertums', 'Gustav Schwab', 2015, 544, 'Nonfiction Book'),
  ('Polyamorie - ein alternativer Lebensentwurf', 'Susanne Riedel', 2014, 176, 'Nonfiction Book'),
  ('Mit Miss Marple aufs Land', 'Luise Berg-Ehlers', 2015, 143, 'Crime'),
  ('Das Versprechen', 'Friedrich Dürrenmatt', 2014, 188, 'Crime'),
  ('Die Wahrheit über den Fall Harry Quebert', 'Joël Dicker', 2014, 736, 'Crime'),
  ('Alice', 'Judith Hermann', 2011, 188, 'Novel'),
  ('Nichts als Gespenster', 'Judith Hermann', 2011, 317, 'Novel'),
  ('Zündels Abgang', 'Markus Werner', 2004, 159, 'Novel'),
  ('Nacht ist der Tag', 'Peter Stamm', 2011, 256, 'Novel'),
  ('Zusammen ist man weniger allein', 'Anna Gavalda', 2005, 550, 'Novel'),
  ('Siddhartha', 'Hermann Hesse', 2012, 204, 'Classic'),
  ('Moby Dick', 'Herman Melville,', 2014, 124, 'Classic'),
  ('Die unendliche Geschichte', 'Michael Ende', 2014, 480, 'Classic'),
  ('Romeo & Julia', 'William Shakespeare', 2013, 96, 'Classic'),
  ('Conan the Barbarian', 'Brian Wood', 2015, 45, 'Comic'),
  ('Hawkeye', 'Matt Fraction', 2015, 228, 'Comic'),
  ('Berlin', 'Jason Lutes', 2000, 98, 'Comic'),
  ('Nausicaa of the Valley of the Wind', 'Hayao Miyazaki', 2004, 136, 'Comic'),
  ('Habibi', 'Craig Thompson', 2011, 672, 'Comic'),
  ('Mother, Come Home', 'Paul Hornschemeier', 2009, 128, 'Comic'),
  ('Der Brenner und der liebe Gott', 'Wolf Haas', 2011, 221, 'Novel'),
  ('Banksy - Exit Through The Gift Shop - Limited Edition', 'Banksy', 2011, 357, 'Art'),
  ('Das kommunistische Manifest', 'Karl Marx, Friedrich Engels', 2015, 304, 'New Publication'),
  ('Das Spiel des Poeten', 'Andrea Camilleri', 2015, 272, 'New Publication'),
  ('Die Widerspenstigkeit des Glücks', 'Gabrielle Zevin', 2015, 288, 'New Publication'),
  ('Children of the Sea, Volume 1', 'Daisuke Igarashi', 2009, 320, 'Comic'),
  ('Lustiges Taschenbuch Weihnachtsgeschichten 02', 'Walt Disney', 2015, 256, 'Comic'),
  ('Die unerträgliche Leichtigkeit des Seins', 'Milan Kundera', 1995, 896, 'Novel'),
  ('Seide', 'Alessandro Baricco', 2011, 126, 'Novel');


###########################################################################
##### USER <-> BOOKS TABLE ################################################
###########################################################################

DROP TABLE IF EXISTS users_books;
CREATE TABLE IF NOT EXISTS users_books (
  books_id  INT(11)  NOT NULL,
  users_id  INT(11)  NOT NULL,
  added     DATETIME NOT NULL,
  finished  DATETIME     DEFAULT NULL,
  `comment` VARCHAR(255) DEFAULT NULL,
  FOREIGN KEY (books_id)
  REFERENCES books (id)
    ON DELETE CASCADE,
  FOREIGN KEY (users_id)
  REFERENCES users (id)
    ON DELETE CASCADE
);

INSERT INTO users_books (books_id, users_id, added, finished, comment) VALUES
  (1, 1, '2015-01-11 17:03:13', '2015-01-11 17:20:15', 'so ein riesen Scheiss!'),
  (9, 1, '2015-01-11 17:03:13', NULL, NULL),
  (16, 1, '2015-02-06 12:25:13', NULL, NULL),
  (23, 1, '2015-01-06 08:12:13', NULL, NULL),
  (10, 1, '2015-03-06 15:12:13', NULL, NULL),
  (6, 1, '2015-04-06 15:12:13', NULL, NULL),
  (5, 1, '2015-01-06 15:12:13', '2015-01-23 18:30:15', 'Miss Marple war und ist einfach langweillig!'),
  (4, 1, '2015-05-06 15:12:13', NULL, NULL),
  (24, 1, '2015-06-06 15:12:13', NULL, NULL),
  (25, 1, '2015-04-06 11:30:13', NULL, NULL);





###########################################################################
##### SESSIONS TABLE ######################################################
###########################################################################

DROP TABLE IF EXISTS sessions;
CREATE TABLE IF NOT EXISTS sessions (
  books_id  INT(11)  NOT NULL,
  users_id  INT(11)  NOT NULL,
  `start`   DATETIME NOT NULL,
  `stop`    DATETIME NOT NULL,
  pages     INT(11)  NOT NULL,
  `comment` VARCHAR(255) DEFAULT '',
  FOREIGN KEY (books_id)
  REFERENCES books (id)
    ON DELETE CASCADE,
  FOREIGN KEY (users_id)
  REFERENCES users (id)
    ON DELETE CASCADE
);

INSERT INTO sessions (books_id, users_id, start, stop, pages, comment) VALUES
  (1, 1, '2015-01-11 17:03:13', '2015-01-11 17:20:15', 5, ''),
  (9, 1, '2015-01-11 17:03:13', '2015-01-11 18:30:15', 34, ''),
  (9, 1, '2015-01-23 22:02:13', '2015-01-23 23:54:15', 23, ''),
  (9, 1, '2015-02-01 12:25:13', '2015-02-01 15:30:15', 65, ''),
  (9, 1, '2015-02-23 16:45:13', '2015-02-23 18:30:15', 80, ''),
  (9, 1, '2015-03-15 20:37:13', '2015-03-15 23:57:15', 100, ''),
  (9, 1, '2015-03-25 15:34:13', '2015-03-25 18:30:15', 15, ''),
  (16, 1, '2015-02-06 12:25:13', '2015-02-06 15:30:15', 23, ''),
  (16, 1, '2015-03-06 12:25:13', '2015-03-06 15:30:15', 35, ''),
  (16, 1, '2015-05-06 15:25:13', '2015-05-06 20:30:15', 38, ''),
  (23, 1, '2015-01-06 08:12:13', '2015-01-06 10:30:15', 65, ''),
  (23, 1, '2015-01-07 08:12:13', '2015-01-07 10:30:15', 65, ''),
  (23, 1, '2015-02-06 08:12:13', '2015-02-06 12:30:15', 91, ''),
  (10, 1, '2015-03-06 15:12:13', '2015-03-06 18:30:15', 34, ''),
  (10, 1, '2015-04-06 15:12:13', '2015-04-06 18:30:15', 45, ''),
  (10, 1, '2015-05-06 15:12:13', '2015-05-06 18:30:15', 80, ''),
  (6, 1, '2015-04-06 15:12:13', '2015-04-06 18:30:15', 56, ''),
  (6, 1, '2015-05-06 15:12:13', '2015-05-06 18:30:15', 73, ''),
  (6, 1, '2015-06-06 15:12:13', '2015-06-06 18:30:15', 59, ''),
  (5, 1, '2015-01-06 15:12:13', '2015-01-06 18:30:15', 12, ''),
  (5, 1, '2015-01-07 15:12:13', '2015-01-07 18:30:15', 10, ''),
  (4, 1, '2015-05-06 15:12:13', '2015-05-06 18:30:15', 12, ''),
  (4, 1, '2015-05-10 15:12:13', '2015-05-10 18:30:15', 23, ''),
  (4, 1, '2015-06-06 15:12:13', '2015-06-06 18:30:15', 34, ''),
  (24, 1, '2015-06-06 15:12:13', '2015-06-06 18:30:15', 12, ''),
  (24, 1, '2015-06-08 15:12:13', '2015-06-08 18:30:15', 23, ''),
  (24, 1, '2015-06-11 15:12:13', '2015-06-11 18:30:15', 42, ''),
  (25, 1, '2015-02-06 15:12:13', '2015-02-06 18:30:15', 12, ''),
  (25, 1, '2015-03-06 15:12:13', '2015-03-06 18:30:15', 56, ''),
  (25, 1, '2015-04-06 11:30:13', '2015-04-06 14.35:15', 34, '');
