drop schema if exists NagyHazi;
CREATE SCHEMA NagyHazi DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
use NagyHazi;

/*Csak, hogy ne adjon Warning-ot, amúgy teljesen okés a warning is,
 mivel a SCHEMA-t minden egyes újra futtatáskor DROP-olja*/
 /*A végőig azért kiszedem, hogy jelezze, ha csokis lenne a palacsinta
set sql_notes = 0; */
SET SQL_SAFE_UPDATES = 0;

drop table if exists Hamburgerezo;
create table Hamburgerezo(
	ID int primary key auto_increment,
    Arkategoria nvarchar(15) not NULL,
    Ertekeles numeric(3,1) not NULL,
    Uzletnev nvarchar(200) not NULL,
    Nyitas int not NULL
);

drop table if exists HamburgerezoCim;
create table HamburgerezoCim(
	HamburgerezoID int not NULL,
    Iranyitoszam nvarchar(4) not NULL,
    Kerulet nvarchar(6),
    Varos nvarchar(150) not NULL,
    UtcaPlusHazszam nvarchar(400) not NULL,
    foreign key (HamburgerezoID) references Hamburgerezo(ID)
);

drop table if exists Hamburger;
create table Hamburger(
	ID int primary key auto_increment,
    Ara numeric(6,0) not NULL,
    Fantazianev nvarchar(100) not NULL,
    Osszetevok nvarchar(700) not NULL,
    Kep nvarchar(500) not NULL,
    HamburgerezoID int not NULL,
    foreign key (HamburgerezoID) references Hamburgerezo(ID)
);

drop table if exists Ertekeles;
create table Ertekeles (
	HamburgerID int not NULL,
    Szumma int DEFAULT '80',
    Db int DEFAULT '10',
    foreign key (HamburgerID) references Hamburger(ID)
);

drop table if exists Velemeny;
create table Velemeny(
	HamburgerID int not NULL,
	ID int primary key auto_increment,
    Nev nvarchar(200) not NULL,
    Ido timestamp,
    /* 500 karakter-re figyelmeztetni kell a felhasználót! */
    Komment nvarchar(500),
    Ertek numeric(3,1) not NULL,
    foreign key (HamburgerID) references Hamburger(ID)
);


/* ------------------------ ELEMEK BEILLESZTÉSE/FELVÉTELE ------------------------*/
/* ------------ Burgerezők: ------------
Hamburgerezők listája ---> TODO: kb 5 hely kell 3 burgerrel [ ]
$ kb 600FT*/
INSERT INTO Hamburgerezo VALUES(1, '$$$', 10.0, 'Bamba Marha', 2015);
INSERT INTO Hamburgerezo VALUES(2, '$$$$$',7.5, 'T.G.I.Friday&#039;s', 1999);
INSERT INTO Hamburgerezo VALUES(3, '$$', 8.5, 'ZING', 2013);
INSERT INTO Hamburgerezo VALUES(4, '$$$$', 8.0, 'W35', 2013);

/* ------------ Hamburgerezők címe ------------ */
INSERT INTO HamburgerezoCim VALUES(1, 1051, '5','BP','Október u 6');
INSERT INTO HamburgerezoCim VALUES(2, 1062, '6','BP','Váci út 1-3');
INSERT INTO HamburgerezoCim VALUES(3, 1117, '6','BP','ALLEE Váli utcai bejáratánál');
INSERT INTO HamburgerezoCim VALUES(4, 1075, '6','BP','Wesselényi utca 35');


/* ------------ Hambik ------------
Figyelmeztetni kell a felhasználót,
 hogy csak 64KB alatti képet töltsön fel
 és ki is kell ezt kezelni h ne tölthessen fel akkorát*/
 /* Bamba Marha*/
INSERT INTO Hamburger VALUES(1, 2190, 'La Bamba Mexicana Burger',
 'Marhahúspogácsa, cheddar sajt, babpüré, mole szósz, avokádókrém,
 jalapeno, nachos chips, római saláta', 'mexa.jpg',1);
INSERT INTO Hamburger VALUES(2, 1990, 'Mega-Vega Burger', 'Grill 
kecskesajt, friss paradicsom, petrezselyem-pesztó, madársaláta', 'vega.jpg', 1);
INSERT INTO Hamburger VALUES(3, 1890, 'Elvis Burger', 'Marhahúspogácsa,
 áfonyadzsem, grillezett bacon, banán, mogyoróvaj', 'elvis.jpg', 1);

/* TGI Friday's*/
INSERT INTO Hamburger VALUES(4, 3590, 'Cowboy Triple Meat Burger', 'Tökéletesen fûszerezett
 hamburgerhús, lassú tűzön, BBQ szószban kisütött omlós marhahússal, Cheddar sajttal, krémes
 tormás szósszal, tetején megkoronázva ropogós baconnel és lyoni hagymával', 'cowboy.jpg',2);
INSERT INTO Hamburger VALUES(5, 3690, 'Italian Stackhouse Burger', 'Hamburgerhús, ropogós,
 sült mozzarella, Provolone sajt, szeletelt pepperoni, kockázott paradicsom, rukkola, friss
 bazsalikom levél, gazdagon meglocsolva marinara szósszal, tetejét Parmezán ropogóssal megkoronázva', 'ita.jpg',2);
INSERT INTO Hamburger VALUES(6, 2990, 'Jack Daniel’s® Burger', 'Jack Daniel’s® szósszal
 készült hamburger, ropogós baconnel és Monterey Jack sajttal, pirított zsemlében', 'jack.jpg',2);

/* ZING */
INSERT INTO Hamburger VALUES(7, 1150, 'Street Burger', 'Chili Mayo, karamellizált 
hagyma, húspogácsa, cheddar, ketchup, mustár, uborka', 'street.jpg',3);
INSERT INTO Hamburger VALUES(8, 1290, 'Chili Burger', 'Pepper mayo, lilahagyma,
 húspogácsa, cheddar, chili szósz, mustár, jalapeno', 'chili.jpg', 3);
INSERT INTO Hamburger VALUES(9, 1790, 'Guitar Hero Burger', 'Chili Mayo, karamellizált
 hagyma, dupla húspogácsa, dupla cheddar, bacon, BBQ szósz, mustár,', 'gh.jpg', 3);
 
 /* W35 */
INSERT INTO Hamburger VALUES(10, 2590, 'Dupla Classic', ' Házi buci, majonéz alapú
 burgerszószunk, római saláta, salátahagyma, paradicsom, 13 dkg-os vagy 2x13 dkg-os
 marhahúspogácsa, paradicsomlekváros cheddarkrém, tojás, bacon, coleslaw salátával, libazsírban
 sült burgonyával', 'toj.jpg',4);
INSERT INTO Hamburger VALUES(11, 2190, 'Fire in the Hole', 'Házi buci, majonéz alapú 
burgerszószunk, házi chiliszósz +18, római saláta, salátahagyma, paradicsom,
13 dkg-os marhahúspogácsa, paradicsomlekváros cheddarkrém, bacon, coleslaw salátával, 
libazsírban sült burgonyával', 'chorizo.jpg', 4);


/* ------------ Értékelések: ------------*/
/* Bamba Marha*/
INSERT INTO Ertekeles VALUES(1,95,10); /*Mexicana 9.5*/
INSERT INTO Ertekeles VALUES(2,70,10); /*Kega-vega 7.0*/
INSERT INTO Ertekeles VALUES(3,85,10); /*Elvis 8.5*/

/* TGI Friday's*/
INSERT INTO Ertekeles VALUES(4,70,10); /*Cowboy 7.0*/
INSERT INTO Ertekeles VALUES(5,70,10); /*Italian 7.0*/
INSERT INTO Ertekeles VALUES(6,65,10); /*Jack 6.5*/

/* ZING */
INSERT INTO Ertekeles VALUES(7,85,10); /*Street 8.5*/
INSERT INTO Ertekeles VALUES(8,80,10); /*Chili 8.0*/
INSERT INTO Ertekeles VALUES(9,80,10); /*GH 8.0*/

/* W35 */
INSERT INTO Ertekeles VALUES(10,75,10); /*Street 7.5*/
INSERT INTO Ertekeles VALUES(11,80,10); /*Chili 8.0*/

/*SELECT id FROM hamburgerezo where uzletnev like '%T.G.I.Friday&#039;s%';*/