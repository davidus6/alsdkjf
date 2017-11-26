SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS udalost CASCADE;
DROP TABLE IF EXISTS uzivatel CASCADE;
DROP TABLE IF EXISTS interpret CASCADE;
DROP TABLE IF EXISTS umelec CASCADE;
DROP TABLE IF EXISTS vstupenka CASCADE;
DROP TABLE IF EXISTS album CASCADE;
DROP TABLE IF EXISTS stage CASCADE;
DROP TABLE IF EXISTS stage_udalost CASCADE;
DROP TABLE IF EXISTS interpret_stage CASCADE;
DROP TABLE IF EXISTS interpret_udalost CASCADE;
DROP TABLE IF EXISTS oblibenec CASCADE;
SET FOREIGN_KEY_CHECKS=1;


CREATE TABLE udalost (
  nazev VARCHAR(50),
  dat_zac DATE,
  dat_kon DATE,
  misto_konani VARCHAR(30),
  zanr VARCHAR(20),
  typ VARCHAR (10),
  kapacita INTEGER,
  rocnik INTEGER,
  cena_zaklad INTEGER,
  cena_vip INTEGER
  );
  
CREATE TABLE uzivatel (
  login VARCHAR(30) NOT NULL,
  heslo VARCHAR(30) NOT NULL, 
  jmeno VARCHAR(50) NOT NULL,
  mesto VARCHAR(30),
  email VARCHAR(50) NOT NULL,
  tel_cislo VARCHAR(20),
  prava VARCHAR(10) DEFAULT 'user'
);

CREATE TABLE interpret (
  jmeno VARCHAR(50), 
  zanr VARCHAR(20),
  dat_vzniku DATE,
  dat_rozpusteni DATE,
  label VARCHAR(20)
);

CREATE TABLE umelec (
  jmeno VARCHAR(50), 
  dat_narozeni DATE, 
  dat_umrti DATE,
  jm_interpreta VARCHAR(50)
);

CREATE TABLE vstupenka (
  cislo_vstup INTEGER NOT NULL AUTO_INCREMENT, 
  cena INTEGER,
  login CHAR(30) NOT NULL, 
  typ VARCHAR(10) NOT NULL,
  udalost VARCHAR(50),
  dat_zac DATE,
  PRIMARY KEY (cislo_vstup)
);

CREATE TABLE album (
  nazev VARCHAR(30), 
  rok_vydani INTEGER, 
  zanr VARCHAR(20),
  autor VARCHAR(50) NOT NULL 
);

CREATE TABLE stage (
  nazev VARCHAR(30), 
  kapacita_mist INTEGER,
  kapacita_interpretu INTEGER,
  plocha INTEGER
);

CREATE TABLE stage_udalost (
  udalost VARCHAR(50),
  dat_zac DATE,
  stage VARCHAR(30)
);

CREATE TABLE interpret_stage (
  interpret VARCHAR(50),
  stage VARCHAR(30),
  jako VARCHAR(20),
  od DATE, 
  do DATE 
);

CREATE TABLE interpret_udalost (
  interpret VARCHAR(50),
  udalost VARCHAR(50),
  dat_zac DATE,
  jako VARCHAR(20),
  od DATE,
  do DATE 
);

CREATE TABLE oblibenec (
  login CHAR(30),
  interpret VARCHAR(50)
);

ALTER TABLE uzivatel ADD CONSTRAINT PK_uzivatel PRIMARY KEY(login);
ALTER TABLE udalost ADD CONSTRAINT PK_udalost PRIMARY KEY(nazev, dat_zac);
ALTER TABLE album ADD CONSTRAINT PK_album PRIMARY KEY(nazev, rok_vydani);
ALTER TABLE interpret ADD CONSTRAINT PK_interpret PRIMARY KEY(jmeno);
ALTER TABLE umelec ADD CONSTRAINT PK_umelec PRIMARY KEY(jmeno, dat_narozeni);
ALTER TABLE stage ADD CONSTRAINT PK_stage PRIMARY KEY(nazev);
ALTER TABLE stage_udalost ADD CONSTRAINT PK_stage_udalost PRIMARY KEY(udalost, dat_zac, stage);
ALTER TABLE interpret_stage ADD CONSTRAINT PK_interpret_stage PRIMARY KEY(interpret, stage);
ALTER TABLE interpret_udalost ADD CONSTRAINT PK_interpret_udalost PRIMARY KEY(interpret, udalost, dat_zac);
ALTER TABLE oblibenec ADD CONSTRAINT PK_oblibenec PRIMARY KEY(login, interpret);

ALTER TABLE oblibenec ADD CONSTRAINT FK_obl_zak FOREIGN KEY(login)
REFERENCES uzivatel(login);
ALTER TABLE oblibenec ADD CONSTRAINT FK_obl_interpret FOREIGN KEY(interpret)
REFERENCES interpret(jmeno);

ALTER TABLE album ADD CONSTRAINT FK_album_autor FOREIGN KEY(autor)
REFERENCES interpret(jmeno);

ALTER TABLE umelec ADD CONSTRAINT FK_umelec_clen FOREIGN KEY(jm_interpreta)
REFERENCES interpret(jmeno);

ALTER TABLE vstupenka ADD CONSTRAINT FK_vstupenka_login FOREIGN KEY(login)
REFERENCES uzivatel(login);
ALTER TABLE vstupenka ADD CONSTRAINT FK_vstupenka_ud FOREIGN KEY(udalost, dat_zac)
REFERENCES udalost(nazev, dat_zac);

ALTER TABLE stage_udalost ADD CONSTRAINT FK_su_stage FOREIGN KEY(stage)
REFERENCES stage(nazev);
ALTER TABLE stage_udalost ADD CONSTRAINT FK_su_udalost FOREIGN KEY(udalost, dat_zac)
REFERENCES udalost(nazev, dat_zac);

ALTER TABLE interpret_udalost ADD CONSTRAINT FK_iu_udalost FOREIGN KEY(udalost, dat_zac)
REFERENCES udalost(nazev, dat_zac);
ALTER TABLE interpret_udalost ADD CONSTRAINT FK_iu_interpret FOREIGN KEY(interpret)
REFERENCES interpret(jmeno);

ALTER TABLE interpret_stage ADD CONSTRAINT FK_is_stage FOREIGN KEY(stage)
REFERENCES stage(nazev);
ALTER TABLE interpret_stage ADD CONSTRAINT FK_is_interpret FOREIGN KEY(interpret)
REFERENCES interpret(jmeno);




INSERT INTO interpret
VALUES('Proti Proudu', 'punk', '2010-06-05', NULL, NULL);

INSERT INTO interpret
VALUES('Metal Bros', 'metal', '2015-06-06', NULL, NULL);

INSERT INTO interpret
VALUES('Dovahkin', 'metal', '2011-11-11', NULL, 'Bethesda');

INSERT INTO interpret
VALUES('Metallica', 'metal', '1981-02-02', NULL, 'Megaforce');

INSERT INTO interpret
VALUES('Dead Band', 'rock', '1985-09-12', '2000-06-25', 'Megaforce');

INSERT INTO umelec
VALUES('Adam Šiška', '1996-09-12', NULL, 'Metal Bros');

INSERT INTO umelec
VALUES('Michael Šiška', '1998-03-31', NULL, 'Metal Bros');

INSERT INTO umelec
VALUES('Lydia Carl', '1990-03-12', NULL, 'Dovahkin');

INSERT INTO umelec
VALUES('Alduin Smith', '2000-12-24', NULL, 'Dovahkin');

INSERT INTO umelec
VALUES('Kamil Horký', '1996-04-04', NULL, 'Proti Proudu');

INSERT INTO umelec
VALUES('Kryštof Vegan', '1995-07-01', NULL, 'Proti Proudu');

INSERT INTO umelec
VALUES('James Hetfield', '1963-08-03', NULL, 'Metallica');

INSERT INTO umelec
VALUES('Lars Ulrich', '1963-12-26', NULL, 'Metallica');

INSERT INTO umelec
VALUES('Kurt Cobain', '1967-02-20', '1994-05-05', NULL);

INSERT INTO album 
VALUES('Bádoš', 2016, 'metal', 'Metal Bros');

INSERT INTO album 
VALUES('Kňourek', 2017, 'metal', 'Metal Bros');

INSERT INTO album 
VALUES('JEDEEM', 2014, 'punk', 'Proti Proudu');

INSERT INTO album 
VALUES('Master of Puppets', 1986, 'thrash metal', 'Metallica');

INSERT INTO album 
VALUES('Ride the Lightning', 1984, 'thrash metal', 'Metallica');

INSERT INTO album 
VALUES('Metallica', 1991, 'heavy metal', 'Metallica');

INSERT INTO album 
VALUES('Load', 1996, 'hard rock', 'Metallica');

INSERT INTO album 
VALUES('Reload', 1997, 'hard rock', 'Metallica');

INSERT INTO udalost
VALUES('Fesťák', '2018-03-02', '2018-03-03', 'Vrbice', 'punk', 'festival', NULL, 1, 20, 50);

INSERT INTO udalost
VALUES('Brutal Assault Festival', '2018-08-08', '2018-08-11', 'Jaroměř', 'metal', 'festival', NULL, 23, 2100, 5200);

INSERT INTO udalost
VALUES('U Marka', '2018-09-02', '2018-09-02', 'Houkdovice', 'alternative rock', 'koncert', 250, NULL, 100, 300);

INSERT INTO stage 
VALUES('Stage Martina Bednáře', 100, 1, 250);

INSERT INTO stage 
VALUES('Cool Stage', 7500, 3, 35000);

INSERT INTO stage 
VALUES('Very Cool Stage', 15000, 8, 70000);

INSERT INTO stage_udalost
VALUES('Fesťák', '2018-03-02', 'Stage Martina Bednáře');

INSERT INTO stage_udalost 
VALUES('Brutal Assault Festival', '2018-08-08', 'Cool Stage');

INSERT INTO stage_udalost 
VALUES('Brutal Assault Festival', '2018-08-08', 'Very Cool Stage');

INSERT INTO interpret_udalost
VALUES('Metallica', 'Brutal Assault Festival', '2018-08-08', NULL, '2018-08-08', '2018-08-11');

INSERT INTO interpret_udalost
VALUES('Metal Bros', 'Brutal Assault Festival', '2018-08-08', NULL, '2018-08-08', '2018-08-11');

INSERT INTO interpret_udalost
VALUES('Proti Proudu', 'Brutal Assault Festival', '2018-08-08', NULL, '2018-08-08', '2018-08-11');

INSERT INTO interpret_udalost
VALUES('Proti Proudu', 'Fesťák', '2018-03-02', NULL, '2018-03-02', '2018-03-03');

INSERT INTO interpret_udalost
VALUES('Metal Bros', 'Fesťák', '2018-03-02', 'headliner', '2018-03-02', '2018-03-03');

INSERT INTO interpret_udalost
VALUES('Proti Proudu', 'U Marka', '2018-09-02', 'hlavní kapela', '2018-09-02', '2018-09-02');

INSERT INTO interpret_udalost
VALUES('Dovahkin', 'U Marka', '2018-09-02', 'předkapela', '2018-09-02', '2018-09-02');

INSERT INTO interpret_udalost
VALUES('Metal Bros', 'U Marka', '2018-09-02', 'předkapela', '2018-09-02', '2018-09-02');

INSERT INTO interpret_stage
VALUES('Proti Proudu', 'Stage Martina Bednáře', NULL, '2018-03-02', '2018-03-03');

INSERT INTO interpret_stage
VALUES('Metal Bros', 'Stage Martina Bednáře', 'headliner', '2018-03-02', '2018-03-03');

INSERT INTO interpret_stage
VALUES('Metallica', 'Very Cool Stage', 'headliner', '2018-08-08', '2018-08-11');

INSERT INTO interpret_stage
VALUES('Metal Bros', 'Very Cool Stage', NULL, '2018-08-08', '2018-08-09');

INSERT INTO interpret_stage
VALUES('Metal Bros', 'Cool Stage', NULL, '2018-08-09', '2018-08-11');

INSERT INTO interpret_stage
VALUES('Proti Proudu', 'Cool Stage', 'headliner', '2018-08-08', '2018-08-11');

INSERT INTO uzivatel
VALUES('Admin', 'admin', 'God', 'Heavens', 'god@mail.com', '777 777 777', 'admin');

INSERT INTO uzivatel
VALUES('a', 'a', 'a', 'a', 'a@mail.com', '', 'user');

INSERT INTO uzivatel
VALUES('User', 'user', 'User', 'Brno', 'user@mail.com', '', 'user');

INSERT INTO uzivatel
VALUES('b', 'b', 'b', 'b', 'b@mail.com', '', 'user');

INSERT INTO uzivatel
VALUES('q', 'q', 'q', 'q', 'q@mail.com', '', 'admin');

INSERT INTO vstupenka
(cena, login, typ, udalost, dat_zac) VALUES(500, 'Admin', 'základní', 'Fesťák', '2018-03-02');

INSERT INTO oblibenec
VALUES ('Admin', 'Metallica');
