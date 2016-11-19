#-- these are some insert values for testing purposes. They can be easily modified into actual values as necessary

#-- some values borrowed and slightly modified from MySql Sakila example database

#-- delete all the table data before re-adding it
#-- must turn off foreign key checking to allow truncation
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE movie_to_person;
TRUNCATE TABLE movie_to_award;
TRUNCATE TABLE person;
TRUNCATE TABLE movie;
TRUNCATE TABLE company;
TRUNCATE TABLE genre;
TRUNCATE TABLE award;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO person VALUES 
(1,'PENELOPE','MIDDLE','GUINESS','2006-02-15 04:34:33'),
(2,'NICK','MIDDLE','WAHLBERG','2006-02-15 04:34:33'),
(3,'ED','MIDDLE','CHASE','2006-02-15 04:34:33'),
(4,'JENNIFER','MIDDLE','DAVIS','2006-02-15 04:34:33');

INSERT INTO movie VALUES
(1, 'Jurassic Park', '1993-06-06 00:00:00', NULL, NULL),
(2, 'V for Vendetta', '2006-06-06 00:00:00', NULL, NULL),
(3, 'Titanic', '1997-06-06 00:00:00', NULL, NULL),
(4, 'Independence Day', '1996-06-06 00:00:00', NULL, NULL);

INSERT INTO company VALUES
(1, 'Warner Bros'),
(2, 'Disney'),
(3, '20th Century Fox');

INSERT INTO award VALUES
(1, 'Best Picture'),
(2, 'Best Effects'),
(3, 'Best Stuff');

INSERT INTO genre VALUES
(1, 'Action'),
(2, 'Aliens'),
(3, 'Ships/Romance');

INSERT INTO movie_to_person VALUES
((SELECT id FROM movie WHERE title = 'Jurassic Park'),(SELECT id FROM person WHERE f_name = 'PENELOPE' AND l_name = 'GUINESS'),'Actor'),
((SELECT id FROM movie WHERE title = 'Jurassic Park'),(SELECT id FROM person WHERE f_name = 'PENELOPE' AND l_name = 'GUINESS'),'Director'),
((SELECT id FROM movie WHERE title = 'V for Vendetta'),(SELECT id FROM person WHERE f_name = 'NICK' AND l_name = 'WAHLBERG'),'Actor'),
((SELECT id FROM movie WHERE title = 'Titanic'),(SELECT id FROM person WHERE f_name = 'ED' AND l_name = 'CHASE'),'Director'),
((SELECT id FROM movie WHERE title = 'Independence Day'),(SELECT id FROM person WHERE f_name = 'JENNIFER' AND l_name = 'DAVIS'),'Actor');

INSERT INTO movie_to_award VALUES
((SELECT id FROM movie WHERE title = 'Jurassic Park'),(SELECT id FROM award WHERE name = 'Best Picture')),
((SELECT id FROM movie WHERE title = 'Jurassic Park'),(SELECT id FROM award WHERE name = 'Best Effects')),
((SELECT id FROM movie WHERE title = 'V for Vendetta'),(SELECT id FROM award WHERE name = 'Best Stuff')),
((SELECT id FROM movie WHERE title = 'Titanic'),(SELECT id FROM award WHERE name = 'Best Picture')),
((SELECT id FROM movie WHERE title = 'Independence Day'),(SELECT id FROM award WHERE name = 'Best Effects'));

UPDATE movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Warner Bros") WHERE title = 'Jurassic Park';
UPDATE movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "20th Century Fox") WHERE title = 'V for Vendetta';
UPDATE movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Disney") WHERE title = 'Titanic';
UPDATE movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Warner Bros") WHERE title = 'Independence Day';

UPDATE movie SET genre_id = (SELECT g.id FROM genre g WHERE g.name = "Action") WHERE title = 'Jurassic Park';
UPDATE movie SET genre_id = (SELECT g.id FROM genre g WHERE g.name = "Action") WHERE title = 'V for Vendetta';
UPDATE movie SET genre_id = (SELECT g.id FROM genre g WHERE g.name = "Ships/Romance") WHERE title = 'Titanic';
UPDATE movie SET genre_id = (SELECT g.id FROM genre g WHERE g.name = "Aliens") WHERE title = 'Independence Day';
