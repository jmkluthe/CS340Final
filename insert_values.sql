#-- these are some insert values for testing purposes. They can be easily modified into actual values as necessary

#-- some values borrowed and slightly modified from MySql Sakila example database

#-- delete all the table data before re-adding it
#-- must turn off foreign key checking to allow truncation
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE Movie_to_Person;
TRUNCATE TABLE Movie_to_Award;
TRUNCATE TABLE Person;
TRUNCATE TABLE Movie;
TRUNCATE TABLE Company;
TRUNCATE TABLE Genre;
TRUNCATE TABLE Award;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO Person VALUES 
(1,'PENELOPE','GUINESS','2006-02-15 04:34:33'),
(2,'NICK','WAHLBERG','2006-02-15 04:34:33'),
(3,'ED','CHASE','2006-02-15 04:34:33'),
(4,'JENNIFER','DAVIS','2006-02-15 04:34:33');

INSERT INTO Company VALUES
(1, 'Warner Bros'),
(2, 'Disney'),
(3, '20th Century Fox');

INSERT INTO Award VALUES
(1, 'Best Picture'),
(2, 'Best Effects'),
(3, 'Best Stuff');

INSERT INTO Genre VALUES
(1, 'Action'),
(2, 'Aliens'),
(3, 'Ships/Romance');

INSERT INTO Movie VALUES
(1, 'Jurassic Park', (SELECT c.id FROM Company c WHERE c.name = "Warner Bros"), (SELECT g.id FROM Genre g WHERE g.name = "Action")),
(2, 'V for Vendetta', (SELECT c.id FROM Company c WHERE c.name = "20th Century Fox"), (SELECT g.id FROM Genre g WHERE g.name = "Action")),
(3, 'Titanic', (SELECT c.id FROM Company c WHERE c.name = "Disney"), (SELECT g.id FROM Genre g WHERE g.name = "Ships/Romance")),
(4, 'Independence Day', (SELECT c.id FROM Company c WHERE c.name = "Warner Bros"), (SELECT g.id FROM Genre g WHERE g.name = "Aliens"));

INSERT INTO Movie_to_Person VALUES
((SELECT id FROM Movie WHERE title = 'Jurassic Park'),(SELECT id FROM Person WHERE first_name = 'PENELOPE' AND last_name = 'GUINESS'),'Actor'),
((SELECT id FROM Movie WHERE title = 'Jurassic Park'),(SELECT id FROM Person WHERE first_name = 'PENELOPE' AND last_name = 'GUINESS'),'Director'),
((SELECT id FROM Movie WHERE title = 'V for Vendetta'),(SELECT id FROM Person WHERE first_name = 'NICK' AND last_name = 'WAHLBERG'),'Actor'),
((SELECT id FROM Movie WHERE title = 'Titanic'),(SELECT id FROM Person WHERE first_name = 'ED' AND last_name = 'CHASE'),'Director'),
((SELECT id FROM Movie WHERE title = 'Independence Day'),(SELECT id FROM Person WHERE first_name = 'JENNIFER' AND last_name = 'DAVIS'),'Actor');

INSERT INTO Movie_to_Award VALUES
((SELECT id FROM Movie WHERE title = 'Jurassic Park'),(SELECT id FROM Award WHERE name = 'Best Picture')),
((SELECT id FROM Movie WHERE title = 'Jurassic Park'),(SELECT id FROM Award WHERE name = 'Best Effects')),
((SELECT id FROM Movie WHERE title = 'V for Vendetta'),(SELECT id FROM Award WHERE name = 'Best Stuff')),
((SELECT id FROM Movie WHERE title = 'Titanic'),(SELECT id FROM Award WHERE name = 'Best Picture')),
((SELECT id FROM Movie WHERE title = 'Independence Day'),(SELECT id FROM Award WHERE name = 'Best Effects'));

#--UPDATE Movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Warner Bros") WHERE title = 'Jurassic Park';
#--UPDATE Movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "20th Century Fox") WHERE title = 'V for Vendetta';
#--UPDATE Movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Disney") WHERE title = 'Titanic';
#--UPDATE Movie SET company_id = (SELECT c.id FROM company c WHERE c.name = "Warner Bros") WHERE title = 'Independence Day';

#--UPDATE Movie SET genre_id = (SELECT g.id FROM Genre g WHERE g.name = "Action") WHERE title = 'Jurassic Park';
#--UPDATE Movie SET genre_id = (SELECT g.id FROM Genre g WHERE g.name = "Action") WHERE title = 'V for Vendetta';
#--UPDATE Movie SET genre_id = (SELECT g.id FROM Genre g WHERE g.name = "Ships/Romance") WHERE title = 'Titanic';
#--UPDATE Movie SET genre_id = (SELECT g.id FROM Genre g WHERE g.name = "Aliens") WHERE title = 'Independence Day';
