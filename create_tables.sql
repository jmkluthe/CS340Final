#-- Table Creation Script

#-- Drop tables before recreating
DROP TABLE IF EXISTS person;
DROP TABLE IF EXISTS movie;
DROP TABLE IF EXISTS company;
DROP TABLE IF EXISTS genre;
DROP TABLE IF EXISTS award;
DROP TABLE IF EXISTS movie_to_person;
DROP TABLE IF EXISTS movie_to_award;

#-- nothing special, a person has a first, middle, last name and date of birth
CREATE TABLE person (
	id INT NOT NULL AUTO_INCREMENT,
	f_name VARCHAR(255) NOT NULL,
	m_name VARCHAR(255),
	l_name VARCHAR(255) NOT NULL,
	dob DATE,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a company has a name
CREATE TABLE company (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a genre has a name
CREATE TABLE genre (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;

#-- a movie has a title and release date, and a reference to a company and a genre
CREATE TABLE movie (
	id INT NOT NULL AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	release_date DATE,
	company_id INT,
	genre_id INT,
	PRIMARY KEY (id),
	FOREIGN KEY (company_id) REFERENCES company (id)
	ON DELETE SET NULL ON UPDATE SET NULL,
	FOREIGN KEY (genre_id) REFERENCES genre (id)
	ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB;


CREATE TABLE award (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB;


#-- job_role is part of the primary key to allow the same person to, for instance, both act and direct in a movie
CREATE TABLE movie_to_person (
	movie_id INT NOT NULL,
	person_id INT NOT NULL,
	job_role VARCHAR(255) NOT NULL,
	PRIMARY KEY (movie_id, person_id, job_role),
	FOREIGN KEY (movie_id) REFERENCES movie (id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (person_id) REFERENCES person (id)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE movie_to_award (
	movie_id INT NOT NULL,
	award_id INT NOT NULL,
	PRIMARY KEY (movie_id, award_id),
	FOREIGN KEY (movie_id) REFERENCES movie (id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (award_id) REFERENCES award (id)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

