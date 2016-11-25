#-- Table Creation Script

#-- Drop tables before recreating
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS Company;
DROP TABLE IF EXISTS Genre;
DROP TABLE IF EXISTS Award;
DROP TABLE IF EXISTS Movie;
DROP TABLE IF EXISTS Movie_to_Person;
DROP TABLE IF EXISTS Movie_to_Award;
SET FOREIGN_KEY_CHECKS = 1;

#-- nothing special, a person has a first, middle, last name and date of birth
CREATE TABLE Person (
	id INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	dob DATE,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a company has a name
CREATE TABLE Company (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a genre has a name
CREATE TABLE Genre (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a movie has a title and release date, and a reference to a company and a genre
CREATE TABLE Movie (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	company_id INT NOT NULL,
	genre_id INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (company_id) REFERENCES Company (id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (genre_id) REFERENCES Genre (id)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE Award (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;


#-- job_role is part of the primary key to allow the same person to, for instance, both act and direct in a movie
CREATE TABLE Movie_to_Person (
	movie_id INT NOT NULL,
	person_id INT NOT NULL,
	job_role VARCHAR(255) NOT NULL,
	PRIMARY KEY (movie_id, person_id, job_role),
	FOREIGN KEY (movie_id) REFERENCES Movie (id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (person_id) REFERENCES Person (id)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE Movie_to_Award (
	movie_id INT NOT NULL,
	award_id INT NOT NULL,
	PRIMARY KEY (movie_id, award_id),
	FOREIGN KEY (movie_id) REFERENCES Movie (id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (award_id) REFERENCES Award (id)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

