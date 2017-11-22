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
  rocnik INTEGER
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
  cislo_vstup INTEGER AUTO_INCREMENT, 
  cena INTEGER,
  login CHAR(11) NOT NULL, 
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
  jako VARCHAR(10),
  od DATE, 
  do DATE 
);

CREATE TABLE interpret_udalost (
  interpret VARCHAR(50),
  udalost VARCHAR(50),
  dat_zac DATE,
  jako VARCHAR(10),
  od DATE,
  do DATE 
);

CREATE TABLE oblibenec (
  rc_zak CHAR(11),
  interpret VARCHAR(50)
);

ALTER TABLE uzivatel ADD CONSTRAINT PK_uzivatel PRIMARY KEY(login);
ALTER TABLE udalost ADD CONSTRAINT PK_udalost PRIMARY KEY(nazev, dat_zac);
ALTER TABLE album ADD CONSTRAINT PK_album PRIMARY KEY(nazev, rok_vydani);
ALTER TABLE interpret ADD CONSTRAINT PK_interpret PRIMARY KEY(jmeno);
ALTER TABLE umelec ADD CONSTRAINT PK_umelec PRIMARY KEY(jmeno, dat_narozeni);
ALTER TABLE stage ADD CONSTRAINT PK_stage PRIMARY KEY(nazev);
ALTER TABLE stage_udalost ADD CONSTRAINT PK_stage_udalost PRIMARY KEY(stage);
ALTER TABLE interpret_stage ADD CONSTRAINT PK_interpret_stage PRIMARY KEY(interpret);
ALTER TABLE interpret_udalost ADD CONSTRAINT PK_interpret_udalost PRIMARY KEY(interpret);
ALTER TABLE oblibenec ADD CONSTRAINT PK_oblibenec PRIMARY KEY(rc_zak, interpret);

ALTER TABLE oblibenec ADD CONSTRAINT FK_obl_zak FOREIGN KEY(rc_zak)
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
VALUES('Metallica', 'metal', '1981-02-02', NULL, 'Megaforce');

INSERT INTO interpret
VALUES('Dead Band', 'rock', '1985-09-12', '2000-06-25', 'Megaforce');

INSERT INTO umelec
VALUES('Kamil Horký', '1996-04-04', NULL, 'Proti Proudu');

INSERT INTO umelec
VALUES('James Hetfield', '1963-08-03', NULL, 'Metallica');

INSERT INTO umelec
VALUES('Lars Ulrich', '1963-12-26', NULL, 'Metallica');

INSERT INTO umelec
VALUES('Kryštof Vegan', '1995-07-01', NULL, 'Proti Proudu');

INSERT INTO umelec
VALUES('Cobain Kurt', '1967-02-20', '1994-05-05', NULL);

INSERT INTO album 
VALUES('JEDEEM', 2011, 'pop', 'Proti Proudu');

INSERT INTO album 
VALUES('Master of Puppets', 1986, 'metal', 'Metallica');

INSERT INTO udalost
VALUES('nakej festak', '1999-01-01', '1999-01-02', 'Vrbice', 'punk', 'festival', NULL, 1);

INSERT INTO udalost
VALUES('Brutal Assault Festival', '2018-08-08', '2018-08-11', 'Jaroměř', 'metal', 'festival', NULL, 23);

INSERT INTO uzivatel
VALUES('Admin', 'tajne,Kappa', 'God', 'Heavens', 'god@mail.com', '777777777', 'admin');

INSERT INTO uzivatel
VALUES('a', 'a', 'a', 'a', 'a@mail.com', '', 'user');