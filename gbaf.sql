create table users(
	id int primary key auto_increment not null,
	name varchar(255),
	firtname varchar(255),
	username varchar(255),
	`password` varchar(255),
	secret_question_id int,
	secret_answer varchar(255)	
)ENGINE = InnoDB;
INSERT INTO users (id,name,firstname,username,password,secret_question_id,secret_answer) VALUES 
(1,'user','test', 'user0', 'password','1',:'secret_answer');

create table secret_questions(
	id int primary key auto_increment not null,
	question varchar(255) not null
)ENGINE = InnoDB;

INSERT INTO secret_questions (question) VALUES 
('Quel est le nom et prénom de votre premier amour ?'),
('Quel est le nom de famille de votre professeur d’enfance préféré ?'),
('Quel est le prénom de votre arrière-grand-mère maternelle ?'),
('Dans quelle ville se sont rencontrés vos parents ?'),
('Qu’est-ce vous vouliez devenir plus grand, lorsque vous étiez enfant ?');

create table partners(
	id int primary key auto_increment not null,
	logo varchar(255) not null,
	title varchar(255) not null,
	description text,
	`like` tinyint,
	`dislike` tinyint
)ENGINE = InnoDB;

create table comments(
	id int primary key auto_increment not null,
	user_id int not null,
	comment text,
	`date` datetime,
	partner_id int not null
)ENGINE = InnoDB;