-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 17, 2021 alle 19:37
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hw2`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `acquisto` (IN `email` VARCHAR(50), IN `metodo` VARCHAR(30), IN `Nome` VARCHAR(50), IN `Cognome` VARCHAR(50), IN `numero_metodo` VARCHAR(30))  BEGIN
/*CALCOLA L'IMPORTO DELLA TRANSAZIONE*/
 SET @TOTALE=( SELECT SUM(s.Costo_licenza*t.n_copie) FROM software s JOIN tmp t ON LOWER(s.Nome)=t.software); 
 /*INSERIRE LA TUPLA IN TRANSAZIONE*/
 CALL ins_transaction (email,metodo,Nome,Cognome,numero_metodo,@TOTALE,CURRENT_TIMESTAMP(),@ID);
 /*INSERISCE LE TUPLE IN COPIA PRIVATA*/
 SET @N = (SELECT MAX(indice) FROM TMP);
 WHILE ( @N >= 0 ) DO
  SET @software_name= (SELECT software FROM TMP  WHERE Indice=@N);
  SET @n_copie= (SELECT n_copie FROM TMP  WHERE software=@software_name); 
  WHILE (@n_copie > 0) DO
    CALL p11 (@software_name,@ID);
    SET @n_copie=@n_copie-1;
  END WHILE;
  SET @N = @N -1;
 END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_tc` (IN `software_name` VARCHAR(30), IN `email` VARCHAR(50), IN `metodo` VARCHAR(30), IN `Nome` VARCHAR(50), IN `Cognome` VARCHAR(50), IN `numero_metodo` VARCHAR(30))  BEGIN
SET @A=(SELECT Costo_licenza FROM software s WHERE s.Nome=software_name);
CALL ins_transaction(email,metodo,Nome,Cognome,numero_metodo,@A,CURRENT_TIMESTAMP(),@ID);
CALL p11 (software_name,@ID);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_tc_n` (IN `software_name` VARCHAR(30), IN `n_copie` INTEGER, IN `email` VARCHAR(50), IN `metodo` VARCHAR(30), IN `Nome` VARCHAR(50), IN `Cognome` VARCHAR(50), IN `numero_metodo` VARCHAR(30))  BEGIN
SET @A=(SELECT Costo_licenza FROM software s WHERE s.Nome=software_name)*n_copie;
CALL ins_transaction(email,metodo,Nome,Cognome,numero_metodo,@A,CURRENT_TIMESTAMP(),@ID);
WHILE (n_copie>0)
 DO
  CALL p11 (software_name,@ID);
  SET n_copie=n_copie-1;
 END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ins_transaction` (IN `email` VARCHAR(50), IN `metodo` VARCHAR(30), IN `Nome` VARCHAR(50), IN `Cognome` VARCHAR(50), IN `numero_metodo` VARCHAR(30), IN `importo` FLOAT, IN `data` DATETIME, OUT `id` INTEGER)  BEGIN
 SET @A=
  CASE
  WHEN (EXISTS (SELECT * FROM transazione t)) THEN (SELECT MAX(t.Id)FROM transazione t)+1
  ELSE 1
END;
INSERT INTO transazione VALUES (@A,email,metodo,nome,cognome,numero_metodo,importo,data);
SELECT @A INTO id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p10` (IN `email` VARCHAR(50), IN `nome_software` VARCHAR(30), IN `numero` INTEGER)  BEGIN
SET @A=(SELECT so.Costo_licenza
        FROM software so
        WHERE so.Nome=nome_software);
SET @A =
 CASE 
  WHEN ((SELECT c.Tipo FROM cliente_istituzionale c WHERE c.Email=email)='Università') THEN @A*numero*0.65
  ELSE @A*numero
END;
SET @B = 
 CASE
    WHEN (EXISTS (SELECT * FROM contratto c WHERE c.Email_cliente=email)) THEN (SELECT MAX(c.Numero_contratto) FROM contratto c WHERE c.Email_cliente=email) +1
	ELSE 1
END;
INSERT INTO contratto VALUES (@B,email,nome_software,numero,@A);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p11` (IN `software_name` VARCHAR(30), IN `id_transazione` INTEGER)  BEGIN
SET @A = 
 CASE
 /*calcola il numero di copia*/
   WHEN (EXISTS (SELECT * FROM copia_pvt c WHERE c.Software=software_name)) THEN (SELECT MAX(c.Numero) FROM copia_pvt c WHERE c.Software=software_name) + 1
	ELSE 1
END;
INSERT INTO copia_pvt VALUES (@A,software_name,id_transazione);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p12` (IN `software_name` VARCHAR(30), IN `versione` INTEGER, IN `pericolosità` VARCHAR(30), IN `tipo` VARCHAR(30))  BEGIN
SET @A = SUBSTR((SELECT so.Nome FROM software so  WHERE so.Nome=software_name),1,3);
SET @B =
 CASE
  WHEN (EXISTS(SELECT * FROM bug b WHERE b.Software=software_name AND b.versione=versione)) THEN (SELECT MAX(CONVERT(SUBSTR(b.Codice,4,6),UNSIGNED)) FROM bug b WHERE b.Software=software_name AND b.versione=versione)+1
  ELSE 1
END;
SET @A = CONCAT(@A,@B);
INSERT INTO bug VALUES (@A,software_name,versione,pericolosità,tipo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `p12c` (IN `software_name` VARCHAR(30), IN `pericolosità` VARCHAR(30), IN `tipo` VARCHAR(30))  BEGIN
SET @A = SUBSTR((SELECT so.Nome FROM software so  WHERE so.Nome=software_name),1,3);
SET @B = (SELECT s.versione_corrente FROM software s WHERE s.nome=software_name);
SET @C =
 CASE
  WHEN (EXISTS(SELECT * FROM bug b WHERE b.Software=software_name AND b.versione=@B)) THEN (SELECT MAX(CONVERT(SUBSTR(b.Codice,4,6),UNSIGNED)) FROM bug b WHERE b.Software=software_name AND b.versione=@B)+1
  ELSE 1
END;
SET @A = CONCAT(@A,@C);
INSERT INTO bug VALUES (@A,software_name,@B,pericolosità,tipo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `retrieve_transactions` (IN `email` VARCHAR(50))  BEGIN
SELECT t.Id,t.`DATA`,t.Metodo,t.Numero_metodo,t.Importo,cp.Software,COUNT(cp.Software) as N_copie
FROM cliente_privato c JOIN transazione t ON c.Email=t.Email_cliente JOIN copia_pvt cp ON t.Id=cp.Id_transazione
WHERE c.Email=email
GROUP BY t.Id,cp.Software;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `s1` (IN `software_name` VARCHAR(30), IN `n_copie` INTEGER, INOUT `TOTALE` FLOAT)  BEGIN
SET TOTALE = (SELECT s.Costo_licenza FROM software s WHERE LOWER(s.Nome)=software_name) * n_copie;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `bug`
--

CREATE TABLE `bug` (
  `Codice` varchar(10) NOT NULL,
  `Software` varchar(30) NOT NULL,
  `Versione` int(11) NOT NULL,
  `Pericolosità` varchar(20) DEFAULT NULL CHECK (`Pericolosità` = 'Alta' or `Pericolosità` = 'Bassa' or `Pericolosità` = 'Media'),
  `Tipo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `bug`
--

INSERT INTO `bug` (`Codice`, `Software`, `Versione`, `Pericolosità`, `Tipo`) VALUES
('Gal1', 'Galileo', 1, 'Media', 'tttttt'),
('Gal2', 'Galileo', 1, 'Alta', 'uuuuuu'),
('Gal3', 'Galileo', 1, 'Alta', 'vvvvv'),
('Pho1', 'PhotoEdit', 1, 'Bassa', 'xxxxx'),
('Pho2', 'PhotoEdit', 1, 'Bassa', 'xxxxx'),
('Pho3', 'PhotoEdit', 1, 'Bassa', 'aaaaa'),
('Pho4', 'PhotoEdit', 1, 'Bassa', 'bbbbb');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente_istituzionale`
--

CREATE TABLE `cliente_istituzionale` (
  `Email` varchar(50) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Sede` varchar(100) NOT NULL,
  `Stato` varchar(30) NOT NULL,
  `Tipo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cliente_istituzionale`
--

INSERT INTO `cliente_istituzionale` (`Email`, `Nome`, `Sede`, `Stato`, `Tipo`) VALUES
('Aisi@aisi.gov', 'A.I.S.I.', 'Roma', 'Italia', 'Agenzia governativa'),
('Cia@cia.gov', 'C.I.A.', 'Virginia,Langley', 'U.S.A.', 'Agenzia governativa'),
('Esa@esa.gov', 'E.S.A.', 'Parigi', 'Francia', 'Agenzia Internazionale'),
('Nasa@nasa.gov', 'N.A.S.A.', 'Washington', 'U.S.A.', 'Agenzia governativa'),
('Nsa@nsa.gov', 'N.S.A.', 'Maryland', 'U.S.A.', 'Agenzia governativa'),
('Sapienza@sapienza.it', 'Università La Sapienza', 'Roma', 'Italia', 'Università'),
('std@stanford.us', 'Stanford University', 'California,Santa Clara', 'U.S.A.', 'Università'),
('UniCt@unict.it', 'Università Catania', 'Catania', 'Italia', 'Università');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente_privato`
--

CREATE TABLE `cliente_privato` (
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `Indirizzo` varchar(100) NOT NULL,
  `Stato` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cliente_privato`
--

INSERT INTO `cliente_privato` (`Email`, `Password`, `Nome`, `Cognome`, `Indirizzo`, `Stato`) VALUES
('a@gmail.com', 'MzBkODg0ZjdiOTZjOTFjNWYyMDYwMjBkZjc1OWU4ZmM1MDM0YjY0YWNmOGExMDI5MmM5YTM5YjkzMTVjNTU5OQ==', 'Carlo', 'Pio', 'egsg,wegqeg,24', 'enaoeo'),
('ab@email.com', '4566688ygia', 'AAAAA', 'BBBBB', 'xxxxx', 'Cina'),
('alfre@email.it', 'ZWQzN2ZlNDhjNTA1ZWExMDdmZDFmOTMwZDNhMDQ3NWIyNjRmMWIzODg2NDI0NmQ0YWY5OWJlNGEwMTM3YTM1Ng==', 'Alfredo', 'Caio', 'Catania,Via Etnea,1', 'Italia'),
('aroon@email.com', '9hfqhfhq0ghq3urjawnf0q3u', 'Aroon', 'Brhars', 'COAISFOIAF', 'Francia'),
('cd@email.com', 'uiahfaiovboiadavifa', 'CCCCC', 'DDDDD', 'xxxxx', 'Italia'),
('frm@email.it', 'MmRlYjY2ZmI5Njk4ZmI5MGQwNzNhYTZhNDhiYjQ3MTRiMDY5ZmIzMzY4YTI1NmRhMTJiMGZjODQ1ZTQ4YjBlMw==', 'Francesco', 'Messina', 'Trento,Via della Republica,167', 'Italia'),
('gre@email.com', 'ajbvaionvoian', 'GGRRR', 'EEEEE', 'xxxxx', 'Inghilterra');

-- --------------------------------------------------------

--
-- Struttura della tabella `consulenza`
--

CREATE TABLE `consulenza` (
  `Nome` varchar(30) NOT NULL,
  `Tipo` varchar(30) NOT NULL DEFAULT 'Non Disponibile',
  `Costo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `consulenza`
--

INSERT INTO `consulenza` (`Nome`, `Tipo`, `Costo`) VALUES
('CyberDefense', 'Digital Forensic', 500000),
('E.S.S.', 'Comunicazioni', 500000),
('Elettronica.spa', 'Comunicazioni Satellitari', 300000),
('Space Engineering.spa', 'Ingegneria Aerospaziale', 200000);

-- --------------------------------------------------------

--
-- Struttura della tabella `contratto`
--

CREATE TABLE `contratto` (
  `Numero_contratto` int(11) NOT NULL,
  `Email_cliente` varchar(50) NOT NULL,
  `Software` varchar(30) NOT NULL,
  `N_copie` int(11) DEFAULT NULL,
  `Importo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `contratto`
--

INSERT INTO `contratto` (`Numero_contratto`, `Email_cliente`, `Software`, `N_copie`, `Importo`) VALUES
(1, 'Aisi@aisi.gov', 'Hydra', 1, 2000000),
(3, 'Aisi@aisi.gov', 'RCAS', 1, 1000000),
(2, 'Aisi@aisi.gov', 'SCC', 10, 5000000),
(1, 'Cia@cia.gov', 'Hydra', 1, 2000000),
(2, 'Cia@cia.gov', 'SCC', 100, 50000000),
(2, 'Esa@esa.gov', 'AeroLAB', 10, 50000),
(1, 'Esa@esa.gov', 'SCC', 1, 500000),
(1, 'Nasa@nasa.gov', 'AeroLAB', 10, 50000),
(2, 'Nasa@nasa.gov', 'SCC', 1, 500000),
(1, 'Nsa@nsa.gov', 'Hydra', 1, 2000000),
(2, 'Nsa@nsa.gov', 'RCAS', 1, 1000000),
(1, 'Sapienza@sapienza.it', 'Galileo', 20000, 3248700),
(1, 'std@stanford.us', 'Galileo', 10000, 1624350),
(1, 'UniCt@unict.it', 'Galileo', 5000, 812175);

-- --------------------------------------------------------

--
-- Struttura della tabella `copia_pvt`
--

CREATE TABLE `copia_pvt` (
  `Numero` int(11) NOT NULL,
  `Software` varchar(30) NOT NULL,
  `Id_transazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `copia_pvt`
--

INSERT INTO `copia_pvt` (`Numero`, `Software`, `Id_transazione`) VALUES
(1, 'AeroLAB', 5),
(1, 'EasyOffice', 1),
(1, 'Galileo', 3),
(1, 'V.I.A.D.', 4),
(1, 'VideoEdit', 10),
(2, 'AeroLAB', 5),
(2, 'EasyOffice', 2),
(2, 'galileo', 6),
(2, 'V.I.A.D.', 4),
(2, 'VideoEdit', 10),
(3, 'AeroLAB', 5),
(3, 'EasyOffice', 5),
(3, 'galileo', 6),
(3, 'V.I.A.D.', 4),
(3, 'VideoEdit', 10),
(4, 'aerolab', 6),
(4, 'easyoffice', 6),
(4, 'galileo', 6),
(4, 'V.I.A.D.', 5),
(5, 'aerolab', 6),
(5, 'EasyOffice', 9),
(5, 'galileo', 8),
(5, 'V.I.A.D.', 5),
(6, 'aerolab', 7),
(6, 'EasyOffice', 9),
(6, 'galileo', 8),
(6, 'V.I.A.D.', 10),
(7, 'aerolab', 8),
(7, 'EasyOffice', 9),
(7, 'galileo', 8),
(7, 'V.I.A.D.', 12),
(8, 'AeroLAB', 9),
(8, 'EasyOffice', 12),
(8, 'Galileo', 12),
(9, 'AeroLAB', 9),
(9, 'Galileo', 12),
(10, 'AeroLAB', 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente`
--

CREATE TABLE `dipendente` (
  `Codice` int(11) NOT NULL,
  `Ruolo` varchar(30) NOT NULL DEFAULT 'Non_specificato',
  `Reparto` varchar(30) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `Nazione` varchar(30) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `Data_nascita` date NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Indirizzo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dipendente`
--

INSERT INTO `dipendente` (`Codice`, `Ruolo`, `Reparto`, `Email`, `Nazione`, `Nome`, `Cognome`, `Data_nascita`, `Telefono`, `Indirizzo`) VALUES
(1, 'Presidente', 'A1', 'sdrt@email.com', 'Italia', 'Ettore', 'Rossi', '1980-09-21', '23471593', 'Roma,Via Venezia,23'),
(2, 'Amministratore delegato', 'A1', 'YuKa@email.com', 'Russia', 'Yuri', 'Kazhkov', '1982-10-01', '256271593', 'Roma,Via Trieste,112'),
(3, 'Segretario', 'A1', 'Gius.pe@email.it', 'Italia', 'Giuseppe', 'Fiorante', '1988-02-21', '0971624', 'Roma,Via Alberti,230'),
(4, 'Rappresentante legale', 'A1', 'sa.to@legal.com', 'Italia', 'Saverio', 'Tommasi', '1979-09-09', '817471593', 'Roma,Via Apollo,10'),
(5, 'Capo risore umane', 'A1', 'Sandro12@email.com', 'Italia', 'Sandro', 'Mattei', '1986-12-12', '8974293', 'Roma,Via Marte,09'),
(6, 'Direttore', 'M1', 'oppl@email.com', 'Italia', 'Orazio', 'Oppoldo', '1989-02-11', '878975892', 'Roma,Via Delle Viole,16'),
(7, 'Addetto', 'M1', 'NiccoloF@email.com', 'Italia', 'Niccolo', 'Ferro', '1995-05-05', '2347784323', 'Roma,Via Maiorana,45'),
(8, 'Addetto', 'M1', 'Rbrt@email.us', 'U.S.A', 'Robert', 'Smithson', '1991-04-21', '87923723', 'Roma,Via Otranto,112'),
(9, 'Direttore', 'M5', 'LeonPouis113@email.com', 'Francia', 'Leon', 'Pouis', '1989-07-01', '71593364', 'Roma,Via Saturno,90'),
(10, 'Addetto', 'M5', 'Aiace@email.com', 'Italia', 'Aiace', 'Bainchi', '1992-05-27', '715253693', 'Roma,Via Fiori,11'),
(11, 'Addetto', 'M5', 'Frk@email.Uk', 'Inghilterra', 'Frank', 'Canterbury', '1993-08-21', '8978493', 'Roma,Via Sicilia,34'),
(12, 'Direttore', 'A3', 'Nik@email.ru', 'Russia', 'Nikolaj', 'Lavrajilc', '1978-09-21', '897295', 'Mosca,Gavriloskaja,23'),
(13, 'Addetto', 'A3', 'Serj95@email.ru', 'Russia', 'Sergej', 'Ptokrest', '1995-07-22', '8898925295', 'Mosca,Poliloskaja,78'),
(14, 'Addetto', 'A3', 'Nik@email.ru', 'Russia', 'Vasilj', 'Mokratu', '1992-10-21', '8236625', 'Mosca,Pilskaja,02'),
(15, 'Direttore', 'A2', 'Til@email.us', 'U.S.A.', 'Tim', 'Pilos', '1979-06-20', '844365', 'Praga,Ulice Plachty,78'),
(16, 'Addetto', 'A2', 'Tmmn@email.rp', 'Republica Ceca', 'Timos', 'Mannesìnckè', '1987-01-02', '843295', 'Praga,Ulice Vlavskà,1345'),
(17, 'Addetto', 'A2', 'Sbnbu@email.rp', 'Republica Ceca', 'Sebastian', 'Busàstevnickè', '1998-10-23', '624367295', 'Praga,Ulice Ostrovskèho,3'),
(18, 'Direttore', 'A4', 'Pttar@email.us', 'U.S.A.', 'Patt', 'Taris', '1979-06-01', '47463295', 'Houston,Street 65,367'),
(19, 'Addetto', 'A4', 'TomJo@email.us', 'U.S.A.', 'Tomas', 'Johns', '1983-01-19', '7457495', 'Houston,Street 689,37'),
(20, 'Addetto', 'A4', 'Cha34@email.us', 'U.S.A.', 'Charles', 'Diron', '1995-08-01', '4746737349', 'Houston,Street 90,976'),
(21, 'Direttore', 'M2', 'Kevin19@email.us', 'Repubblica Ceca', 'Kevin', 'Dytèàh', '1990-03-08', '19875135', 'Praga,Ulice Plachty,110'),
(22, 'Direttore', 'A3', 'Zak@email.ru', 'Russia', 'Imran', 'Zakhaev', '1988-12-01', '89987215', 'Mosca,Albitarskaja,238'),
(23, 'Direttore', 'M4', 'Lud@email.it', 'Italia', 'Ludovico', 'Friedel', '1987-04-09', '951223', 'Houston,Street 012,89'),
(24, 'Capo', 'S1', 'Andr456@email.it', 'Italia', 'Andrea', 'Simonetti', '1986-02-09', '2234144', 'Roma,Via Appennini,890'),
(25, 'Esperto cyber-security', 'S1', 'mttt@email.it', 'Italia', 'Matteo', 'Rostro', '1994-05-14', '0092567', 'Roma,Via Appalachi,88'),
(26, 'Sviluppatore', 'S1', 'Giulia89@email.it', 'Italia', 'Giulia', 'Annichiarico', '1989-08-03', '1443463', 'Roma,Via Aldo Moro,76'),
(27, 'Sviluppatore', 'S1', 'Ellc@email.it', 'Italia', 'Elisa', 'Cavaleri', '1999-04-21', '2234144', 'Roma,Via Aldo Moro,76'),
(28, 'Capo', 'S6', 'Ettore11@email.it', 'Italia', 'Ettore', 'Guerrieri', '1984-05-08', '4472525', 'Roma,Via Sole,97'),
(29, 'Esperto cyber-security', 'S6', 'Giul@email.it', 'Italia', 'Giuliano', 'Terra', '1996-02-08', '42623462525', 'Roma,Via Cavour,7'),
(30, 'Sviluppatore', 'S6', 'Vladimir@email.ru', 'Russia', 'Vladimir', 'Dakjhan', '1997-11-08', '8633425', 'Roma,Via Luna,970'),
(31, 'Capo', 'S12', 'Mrk23@email.it', 'U.S.A', 'Markus', 'Fonten', '1990-12-08', '44773765', 'Roma,Via Acqua,109'),
(32, 'Capo', 'S5', 'Jose@email.com', 'Messico', 'Jose', 'Sanchez', '1994-09-10', '367362525', 'Roma,Via Plutone,12'),
(33, 'Capo', 'S3', 'Mario23@email.it', 'Italia', 'Mario', 'Petrini', '1987-12-08', '43748525', 'Praga,Ulice Poktàrsè,45'),
(34, 'Sviluppatore', 'S3', 'Giuseppe.90@email.it', 'Italia', 'Giuseppe', 'Franchi', '1990-01-20', '5346525', 'Praga,Ulice Khoètrù,66'),
(35, 'Sviluppatore', 'S3', 'Mia87@email.it', 'Italia', 'Mia', 'Bianchi', '1987-02-23', '7586525', 'Praga,Ulice Sretè,660'),
(36, 'Capo', 'S5', 'Regina@email.ru', 'Russia', 'Regina', 'Rokolenko', '1992-06-20', '5348436325', 'Praga,Ulice Porèàh,778'),
(37, 'Capo', 'S7', 'Sarah@email.ru', 'Russia', 'Sarah', 'Emilianenko', '1986-09-21', '54857225', 'Praga,Ulice Kertho,876'),
(38, 'Capo', 'S17', 'Arvela@email.pr', 'Repubblica Ceca', 'Arvela', 'Pkotyoh', '1987-07-07', '697057225', 'Praga,Ulice Kerotrè,86'),
(39, 'Capo', 'S4', 'Carlo11@email.it', 'Italia', 'Carlo', 'Montagna', '1997-04-23', '4684725', 'Mosca,Oiuloskaya,96'),
(40, 'Esperto Cyber-security', 'S4', 'vkt@email.ru', 'Russia', 'Viktor', 'Vholenko', '1997-07-13', '44584725', 'Mosca,Ulitsa tkreon,777'),
(41, 'Esperto Cyber-security', 'S4', 'sasha@email.ru', 'Russia', 'Sasha', 'Trolonkenko', '1999-08-11', '447725', 'Mosca,Ulitsa ouphkoon,792'),
(42, 'Penetration-tester', 'S4', 'Gbb45@email.us', 'U.S.A.', 'Gabriel', 'Bane', '1997-11-13', '7236325', 'Mosca,Ulitsa yuepn,844'),
(43, 'Esperto Remote Control', 'S4', 'Arty@email.ru', 'Russia', 'Artyom', 'Miralenko', '1999-08-11', '58474725', 'Mosca,Ulitsa prypyatskaja,56'),
(44, 'Capo', 'S8', 'vn34@email.ru', 'Russia', 'Ivan', 'Olennyat', '1987-05-10', '4449332725', 'Mosca,Ulitsa utrhejo,892'),
(45, 'Sviluppatore', 'S8', 'Raissa@email.ru', 'Russia', 'Raissa', 'Netsko', '1998-05-30', '4755325', 'Mosca,Ulitsa Narkoman,45'),
(46, 'Capo', 'S9', 'Denn@email.us', 'U.S.A.', 'Denise', 'Reid', '1999-02-06', '980962', 'Mosca,Ulitsa Brat,2'),
(47, 'Capo', 'S18', 'mln@email.us', 'U.S.A.', 'Melanie', 'May', '1985-02-10', '4486332725', 'Mosca,Ulitsa Btriakll,25'),
(48, 'Capo', 'S10', 'vn34@email.us', 'U.S.A.', 'Vincent', 'O\'Connor', '1995-11-30', '845825', 'Houston,Street 78,256'),
(49, 'Sviluppatore', 'S10', 'sh@email.us', 'U.S.A.', 'Sean', 'O\'Malley', '1981-09-01', '84837725', 'Houston,Street 90,123'),
(50, 'Capo', 'S11', 'Chd@email.us', 'U.S.A.', 'Charlotte', 'Bourke', '1997-12-28', '94356825', 'Houston,Street 10,26'),
(51, 'Sviluppatore', 'S11', 'jj@email.us', 'U.S.A.', 'Jimmy', 'Johns', '1999-10-30', '97971889525', 'Houston,Street 8,6'),
(52, 'Capo', 'S13', 'NesB@email.us', 'U.S.A.', 'Neston', 'Burke', '1984-03-26', '848362525', 'Houston,Street 82,56'),
(53, 'Capo', 'S14', 'Gnn@email.us', 'Italia', 'Giovanni', 'Piotti', '1985-11-23', '889897891255', 'Houston,Street 786,226'),
(54, 'Capo', 'S19', 'All@email.ru', 'Russia', 'Aliosha', 'Vernho', '1988-01-06', '59566425', 'Praga,Ulice Shtrekoh,656'),
(55, 'Capo', 'S20', 'Tmm@email.it', 'Italia', 'Tommaso', 'Rossi', '1991-01-30', '84583675', 'Mosca,Adenoskaja,896'),
(56, 'Capo', 'S16', 'Fab@email.it', 'Italia', 'Fabio', 'Santi', '1998-09-27', '8335', 'Houston,Street 99,641'),
(57, 'Esperto cyber-security', 'S6', 'Frnc@email.it', 'Italia', 'Francesco', 'Sazzu', '1989-08-08', '72525', 'Roma,Via Nettuno,65');

-- --------------------------------------------------------

--
-- Struttura della tabella `reparto`
--

CREATE TABLE `reparto` (
  `Nome` varchar(40) NOT NULL,
  `Tipo` varchar(30) DEFAULT NULL CHECK (`Tipo` = 'Amministrazione' or `Tipo` = 'Marketing' or `Tipo` = 'Sviluppo'),
  `Sede` varchar(30) DEFAULT NULL CHECK (`Sede` = 'Praga' or `Sede` = 'Roma' or `Sede` = 'Houston' or `Sede` = 'Mosca')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `reparto`
--

INSERT INTO `reparto` (`Nome`, `Tipo`, `Sede`) VALUES
('A1', 'Amministrazione', 'Roma'),
('A2', 'Amministrazione', 'Praga'),
('A3', 'Amministrazione', 'Mosca'),
('A4', 'Amministrazione', 'Houston'),
('A5', 'Amministrazione', 'Roma'),
('M1', 'Marketing', 'Roma'),
('M2', 'Marketing', 'Praga'),
('M3', 'Marketing', 'Mosca'),
('M4', 'Marketing', 'Houston'),
('M5', 'Marketing', 'Roma'),
('S1', 'Sviluppo', 'Roma'),
('S10', 'Sviluppo', 'Houston'),
('S11', 'Sviluppo', 'Houston'),
('S12', 'Sviluppo', 'Roma'),
('S13', 'Sviluppo', 'Houston'),
('S14', 'Sviluppo', 'Houston'),
('S15', 'Sviluppo', 'Roma'),
('S16', 'Sviluppo', 'Houston'),
('S17', 'Sviluppo', 'Praga'),
('S18', 'Sviluppo', 'Mosca'),
('S19', 'Sviluppo', 'Praga'),
('S2', 'Sviluppo', 'Roma'),
('S20', 'Sviluppo', 'Mosca'),
('S3', 'Sviluppo', 'Praga'),
('S4', 'Sviluppo', 'Mosca'),
('S5', 'Sviluppo', 'Praga'),
('S6', 'Sviluppo', 'Roma'),
('S7', 'Sviluppo', 'Praga'),
('S8', 'Sviluppo', 'Mosca'),
('S9', 'Sviluppo', 'Mosca');

-- --------------------------------------------------------

--
-- Struttura della tabella `report_i`
--

CREATE TABLE `report_i` (
  `Cliente` varchar(50) NOT NULL,
  `Bug` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `report_p`
--

CREATE TABLE `report_p` (
  `Cliente` varchar(50) NOT NULL,
  `Bug` varchar(10) DEFAULT NULL,
  `Codice` int(11) NOT NULL,
  `software` varchar(30) NOT NULL,
  `versione_software` int(11) NOT NULL,
  `Descrizione` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `report_p`
--

INSERT INTO `report_p` (`Cliente`, `Bug`, `Codice`, `software`, `versione_software`, `Descrizione`) VALUES
('alfre@email.it', NULL, 1, 'v.i.a.d.', 11, 'jnoiaojwqojnanddvojaoaopkoabviahiojdioajvaninio jaiofjapan nadjaosopdaspcopn ponopadopajvinaoahioiopcn p najdcpoascmpoaviaefiajsnpanpacjpavpaviaopckaovapiv');

-- --------------------------------------------------------

--
-- Struttura della tabella `software`
--

CREATE TABLE `software` (
  `Nome` varchar(30) NOT NULL,
  `Versione_corrente` int(11) DEFAULT NULL,
  `Tipo` varchar(30) DEFAULT 'None',
  `Costo_licenza` float NOT NULL,
  `Ricavo` double DEFAULT NULL,
  `N_Download` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `software`
--

INSERT INTO `software` (`Nome`, `Versione_corrente`, `Tipo`, `Costo_licenza`, `Ricavo`, `N_Download`) VALUES
('AeroLAB', 2, 'Prototipazione Aerospaziale', 5000, 0, 0),
('EasyOffice', 9, 'Ufficio', 100, 0, 0),
('Galileo', 5, 'Calcolo scientifico', 249.9, 0, 0),
('Hydra', 1, 'Spionaggio', 2000000, 0, 0),
('MACK', 5, 'DBMS', 100000, 0, 0),
('PhotoEdit', 8, 'Elaborazione immaggini', 29.9, 0, 0),
('RCAS', 3, 'Spionaggio', 1000000, 0, 0),
('SCC', 4, 'Comunicazione Satellitare', 500000, 0, 0),
('V.I.A.D.', 11, 'Antivirus', 129.9, 0, 0),
('VideoEdit', 10, 'Elaborazione Video', 49.9, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `sviluppo`
--

CREATE TABLE `sviluppo` (
  `Software` varchar(30) DEFAULT NULL,
  `Team_sviluppo` varchar(40) DEFAULT NULL,
  `Consulente` varchar(30) DEFAULT NULL,
  `Data_inizio` date NOT NULL,
  `Data_fine` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sviluppo`
--

INSERT INTO `sviluppo` (`Software`, `Team_sviluppo`, `Consulente`, `Data_inizio`, `Data_fine`) VALUES
('Hydra', 'S6', NULL, '2018-02-03', NULL),
('Hydra', 'S4', NULL, '2018-02-03', NULL),
('AeroLAB', 'S12', NULL, '2014-07-01', NULL),
('AeroLAB', 'S1', NULL, '2014-07-01', NULL),
('AeroLAB', 'S10', NULL, '2016-09-10', '2018-01-10'),
('Hydra', NULL, 'E.S.S.', '2018-06-12', '2018-08-11'),
('AeroLAB', NULL, 'Space Engineering.spa', '2016-09-10', '2017-02-09'),
('RCAS', 'S4', NULL, '2010-05-09', '2018-01-01'),
('RCAS', 'S6', NULL, '2010-05-09', '2018-01-01'),
('RCAS', 'S15', NULL, '2018-01-01', NULL),
('RCAS', 'S18', NULL, '2018-01-01', NULL),
('RCAS', NULL, 'CyberDefense', '2018-01-01', '2018-03-01'),
('SCC', 'S11', NULL, '2014-04-11', NULL),
('SCC', 'S10', NULL, '2014-05-11', NULL),
('SCC', NULL, 'Elettronica.spa', '2014-05-11', '2014-06-10'),
('Galileo', 'S7', NULL, '2013-10-01', NULL),
('Galileo', 'S13', NULL, '2013-10-01', NULL),
('EasyOffice', 'S8', NULL, '2013-05-12', NULL),
('EasyOffice', 'S16', NULL, '2013-05-12', NULL),
('MACK', 'S2', NULL, '2013-04-21', NULL),
('MACK', 'S3', NULL, '2013-04-21', NULL),
('PhotoEdit', 'S1', NULL, '2011-05-10', '2014-06-28'),
('PhotoEdit', 'S2', NULL, '2011-05-10', '2013-04-16'),
('PhotoEdit', 'S9', NULL, '2013-04-16', NULL),
('PhotoEdit', 'S14', NULL, '2013-04-16', NULL),
('VideoEdit', 'S17', NULL, '2014-08-10', NULL),
('VideoEdit', 'S19', NULL, '2014-08-10', NULL),
('V.I.A.D.', 'S20', NULL, '2015-09-13', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `transazione`
--

CREATE TABLE `transazione` (
  `Id` int(11) NOT NULL,
  `Email_cliente` varchar(50) NOT NULL,
  `Metodo` varchar(30) NOT NULL,
  `Nome_intestatario` varchar(50) NOT NULL,
  `Cognome_intestatario` varchar(50) NOT NULL,
  `Numero_metodo` varchar(30) NOT NULL,
  `Importo` float NOT NULL,
  `DATA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `transazione`
--

INSERT INTO `transazione` (`Id`, `Email_cliente`, `Metodo`, `Nome_intestatario`, `Cognome_intestatario`, `Numero_metodo`, `Importo`, `DATA`) VALUES
(1, 'aroon@email.com', 'Carta di credito', 'Aroon', 'Brhars', '0101010101', 100, '2021-05-14 00:00:00'),
(2, 'gre@email.com', 'Carta prepagata', 'GGRRR', 'EEEEE', '012553210101', 100, '2021-03-11 00:10:00'),
(3, 'ab@email.com', 'Carta di credito', 'AAAAA', 'BBBBB', '82378237429', 249.9, '2021-05-11 09:26:49'),
(4, 'gre@email.com', 'Carta di credito', 'Mario', 'Rossi', '357486485', 389.7, '2021-05-11 20:56:05'),
(5, 'aroon@email.com', 'Carta di credito', 'Aroon', 'Maurici', '3634735745', 15359.8, '2021-05-12 17:06:10'),
(6, 'a@gmail.com', 'Carta di credito', 'Carlo', 'Pace', '214135', 10849.7, '2021-05-23 01:01:12'),
(7, 'a@gmail.com', 'Carta di credito', 'asgag', 'asgasgad', '1231532', 5000, '2021-05-23 01:04:21'),
(8, 'a@gmail.com', 'Carta di credito', 'asd', 'asd', '25464', 5749.7, '2021-05-23 19:50:53'),
(9, 'a@gmail.com', 'Carta di credito', 'aaaaa', 'bbbbb', '12442', 10300, '2021-06-13 20:16:30'),
(10, 'a@gmail.com', 'Carta di credito', 'alaja', 'mufassa', '122345', 279.6, '2021-06-13 20:24:08'),
(11, 'alfre@email.it', 'Carta di credito', 'Alfredo', 'Caio', '111111111111', 5000, '2021-06-15 12:12:37'),
(12, 'alfre@email.it', 'Carta di credito', 'Alfredo', 'Nocera', '324162748246', 729.7, '2021-06-17 13:16:40');

-- --------------------------------------------------------

--
-- Struttura della tabella `versione`
--

CREATE TABLE `versione` (
  `Numero` int(11) NOT NULL,
  `Software` varchar(30) NOT NULL,
  `Data_rilascio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `versione`
--

INSERT INTO `versione` (`Numero`, `Software`, `Data_rilascio`) VALUES
(1, 'AeroLAB', '2018-01-10'),
(1, 'EasyOffice', '2014-03-01'),
(1, 'Galileo', '2015-09-10'),
(1, 'Hydra', '2021-01-05'),
(1, 'MACK', '2015-07-20'),
(1, 'PhotoEdit', '2013-09-09'),
(1, 'RCAS', '2013-03-05'),
(1, 'SCC', '2018-03-21'),
(1, 'V.I.A.D.', '2018-05-19'),
(1, 'VideoEdit', '2016-03-01'),
(2, 'AeroLAB', '2020-07-25'),
(2, 'EasyOffice', '2015-03-01'),
(2, 'Galileo', '2015-12-21'),
(2, 'MACK', '2015-11-02'),
(2, 'PhotoEdit', '2014-09-09'),
(2, 'RCAS', '2017-08-11'),
(2, 'SCC', '2019-08-11'),
(2, 'V.I.A.D.', '2018-08-19'),
(2, 'VideoEdit', '2016-09-01'),
(3, 'EasyOffice', '2015-09-01'),
(3, 'Galileo', '2016-06-02'),
(3, 'MACK', '2016-09-18'),
(3, 'PhotoEdit', '2015-09-09'),
(3, 'RCAS', '2020-11-02'),
(3, 'SCC', '2020-10-09'),
(3, 'V.I.A.D.', '2018-11-19'),
(3, 'VideoEdit', '2017-03-01'),
(4, 'EasyOffice', '2016-03-01'),
(4, 'Galileo', '2018-08-12'),
(4, 'MACK', '2017-04-11'),
(4, 'PhotoEdit', '2016-09-09'),
(4, 'SCC', '2021-01-18'),
(4, 'V.I.A.D.', '2019-02-19'),
(4, 'VideoEdit', '2017-09-01'),
(5, 'EasyOffice', '2016-09-01'),
(5, 'Galileo', '2019-04-20'),
(5, 'MACK', '2019-08-25'),
(5, 'PhotoEdit', '2017-09-09'),
(5, 'V.I.A.D.', '2019-05-19'),
(5, 'VideoEdit', '2018-03-01'),
(6, 'EasyOffice', '2017-09-01'),
(6, 'PhotoEdit', '2018-09-09'),
(6, 'V.I.A.D.', '2019-08-19'),
(6, 'VideoEdit', '2018-09-01'),
(7, 'EasyOffice', '2018-03-01'),
(7, 'PhotoEdit', '2019-09-09'),
(7, 'V.I.A.D.', '2019-11-19'),
(7, 'VideoEdit', '2019-03-01'),
(8, 'EasyOffice', '2018-09-01'),
(8, 'PhotoEdit', '2020-09-09'),
(8, 'V.I.A.D.', '2020-02-19'),
(8, 'VideoEdit', '2019-09-01'),
(9, 'EasyOffice', '2019-03-01'),
(9, 'V.I.A.D.', '2020-05-19'),
(9, 'VideoEdit', '2020-03-01'),
(10, 'V.I.A.D.', '2020-08-19'),
(10, 'VideoEdit', '2020-09-01'),
(11, 'V.I.A.D.', '2020-11-19');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bug`
--
ALTER TABLE `bug`
  ADD PRIMARY KEY (`Codice`,`Software`,`Versione`),
  ADD KEY `idx_s` (`Software`),
  ADD KEY `idx_v` (`Versione`);

--
-- Indici per le tabelle `cliente_istituzionale`
--
ALTER TABLE `cliente_istituzionale`
  ADD PRIMARY KEY (`Email`);

--
-- Indici per le tabelle `cliente_privato`
--
ALTER TABLE `cliente_privato`
  ADD PRIMARY KEY (`Email`);

--
-- Indici per le tabelle `consulenza`
--
ALTER TABLE `consulenza`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `contratto`
--
ALTER TABLE `contratto`
  ADD PRIMARY KEY (`Email_cliente`,`Software`,`Numero_contratto`),
  ADD KEY `idx_n` (`Numero_contratto`),
  ADD KEY `idx_e` (`Email_cliente`),
  ADD KEY `idx_s` (`Software`);

--
-- Indici per le tabelle `copia_pvt`
--
ALTER TABLE `copia_pvt`
  ADD UNIQUE KEY `Numero` (`Numero`,`Software`,`Id_transazione`),
  ADD KEY `idx_n` (`Numero`),
  ADD KEY `idx_i` (`Id_transazione`),
  ADD KEY `idx_s` (`Software`);

--
-- Indici per le tabelle `dipendente`
--
ALTER TABLE `dipendente`
  ADD PRIMARY KEY (`Codice`),
  ADD KEY `Reparto` (`Reparto`);

--
-- Indici per le tabelle `reparto`
--
ALTER TABLE `reparto`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `report_i`
--
ALTER TABLE `report_i`
  ADD PRIMARY KEY (`Cliente`,`Bug`),
  ADD KEY `idx_c` (`Cliente`),
  ADD KEY `idx_b` (`Bug`);

--
-- Indici per le tabelle `report_p`
--
ALTER TABLE `report_p`
  ADD PRIMARY KEY (`Codice`),
  ADD KEY `idx_c` (`Cliente`),
  ADD KEY `idx_b` (`Bug`),
  ADD KEY `idx_v` (`versione_software`),
  ADD KEY `software` (`software`);

--
-- Indici per le tabelle `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `sviluppo`
--
ALTER TABLE `sviluppo`
  ADD KEY `idx_s` (`Software`),
  ADD KEY `idx_t` (`Team_sviluppo`),
  ADD KEY `idx_c` (`Consulente`);

--
-- Indici per le tabelle `transazione`
--
ALTER TABLE `transazione`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idx_e` (`Email_cliente`);

--
-- Indici per le tabelle `versione`
--
ALTER TABLE `versione`
  ADD PRIMARY KEY (`Numero`,`Software`),
  ADD KEY `idx_s` (`Software`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bug`
--
ALTER TABLE `bug`
  ADD CONSTRAINT `bug_ibfk_1` FOREIGN KEY (`Software`) REFERENCES `software` (`Nome`),
  ADD CONSTRAINT `bug_ibfk_2` FOREIGN KEY (`Versione`) REFERENCES `versione` (`Numero`);

--
-- Limiti per la tabella `contratto`
--
ALTER TABLE `contratto`
  ADD CONSTRAINT `contratto_ibfk_1` FOREIGN KEY (`Email_cliente`) REFERENCES `cliente_istituzionale` (`Email`),
  ADD CONSTRAINT `contratto_ibfk_2` FOREIGN KEY (`Software`) REFERENCES `software` (`Nome`);

--
-- Limiti per la tabella `copia_pvt`
--
ALTER TABLE `copia_pvt`
  ADD CONSTRAINT `copia_pvt_ibfk_2` FOREIGN KEY (`Software`) REFERENCES `software` (`Nome`),
  ADD CONSTRAINT `copia_pvt_ibfk_3` FOREIGN KEY (`Id_transazione`) REFERENCES `transazione` (`Id`);

--
-- Limiti per la tabella `dipendente`
--
ALTER TABLE `dipendente`
  ADD CONSTRAINT `dipendente_ibfk_1` FOREIGN KEY (`Reparto`) REFERENCES `reparto` (`Nome`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `report_i`
--
ALTER TABLE `report_i`
  ADD CONSTRAINT `report_i_ibfk_1` FOREIGN KEY (`Cliente`) REFERENCES `cliente_istituzionale` (`Email`),
  ADD CONSTRAINT `report_i_ibfk_2` FOREIGN KEY (`Bug`) REFERENCES `bug` (`Codice`);

--
-- Limiti per la tabella `report_p`
--
ALTER TABLE `report_p`
  ADD CONSTRAINT `report_p_ibfk_1` FOREIGN KEY (`software`) REFERENCES `software` (`Nome`),
  ADD CONSTRAINT `report_p_ibfk_2` FOREIGN KEY (`Bug`) REFERENCES `bug` (`Codice`),
  ADD CONSTRAINT `report_p_ibfk_3` FOREIGN KEY (`Cliente`) REFERENCES `cliente_privato` (`Email`);

--
-- Limiti per la tabella `sviluppo`
--
ALTER TABLE `sviluppo`
  ADD CONSTRAINT `sviluppo_ibfk_1` FOREIGN KEY (`Software`) REFERENCES `software` (`Nome`),
  ADD CONSTRAINT `sviluppo_ibfk_2` FOREIGN KEY (`Team_sviluppo`) REFERENCES `reparto` (`Nome`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sviluppo_ibfk_3` FOREIGN KEY (`Consulente`) REFERENCES `consulenza` (`Nome`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `transazione`
--
ALTER TABLE `transazione`
  ADD CONSTRAINT `transazione_ibfk_1` FOREIGN KEY (`Email_cliente`) REFERENCES `cliente_privato` (`Email`);

--
-- Limiti per la tabella `versione`
--
ALTER TABLE `versione`
  ADD CONSTRAINT `versione_ibfk_1` FOREIGN KEY (`Software`) REFERENCES `software` (`Nome`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
