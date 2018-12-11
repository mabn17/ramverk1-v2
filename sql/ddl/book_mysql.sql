--
-- Creating a small table.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--



--
-- Create a database for test
--
DROP DATABASE IF EXISTS ramverk1;
CREATE DATABASE IF NOT EXISTS ramverk1;
USE ramverk1;



--
-- Create a database user for the test database
--
GRANT ALL ON ramverk1.* TO user@localhost IDENTIFIED BY 'pass';



-- Ensure UTF8 on the database connection
SET NAMES utf8;



--
-- Table Book
--
DROP TABLE IF EXISTS Book;
CREATE TABLE Book (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(256) NOT NULL,
    `author` VARCHAR(256) NOT NULL,
    `picture` VARCHAR(256) DEFAULT "http://www.cullompton.devon.sch.uk/i/layout/foobox/no-img.jpg"
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `Book` (`title`, `author`, `picture`)
VALUES
    ("The Road", "Cormac McCarthy", "https://s2.adlibris.com/images/1816664/the-road.jpg"),
    ("Catch 22", "Joseph Heller", "https://upload.wikimedia.org/wikipedia/en/9/99/Catch22.jpg")