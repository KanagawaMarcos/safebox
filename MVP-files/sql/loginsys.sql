-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2018 at 01:31 PM
-- Server version: 5.5.49-0+deb8u1
-- PHP Version: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loginsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `caixinhas`
--

CREATE TABLE IF NOT EXISTS `caixinhas` (
  `caixinha_id` varchar(256) NOT NULL,
  `caixinha_value` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `caixinhas`
--

INSERT INTO `caixinhas` (`caixinha_id`, `caixinha_value`) VALUES
('1', '2831.2400000000016'),
('2', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_uid` varchar(256) NOT NULL,
  `user_first` varchar(256) NOT NULL,
  `user_last` varchar(256) NOT NULL,
  `user_email` varchar(256) NOT NULL,
  `user_saldo1` varchar(256) NOT NULL,
  `user_saldo2` varchar(256) NOT NULL,
  `user_permission` varchar(256) NOT NULL,
  `user_pwd` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_uid`, `user_first`, `user_last`, `user_email`, `user_saldo1`, `user_saldo2`, `user_permission`, `user_pwd`) VALUES
(4, 'gebraz', 'Geraldo', 'Braz', 'ge.braz@gmail.com', '7675.889999999997', '0', '3', '$2y$10$QEv.tv/crw88GBR4jYuO6efGmBuN0mq7hkNbcwrVRnD2lXZBA47BG'),
(5, 'marcos', 'Marcos', 'Costa', 'mcs1901@outlook.com', '-10', '0', '1', '$2y$10$Rs5aKLVdHVODzDkY.YKD6Of5afFfBCFi8DBuAGi5CUIRvNogUYib.'),
(6, 'antonio', 'Antonio', 'Moreira Pinto', 'antoniomorara@gmail.com', '-10', '0', '1', '$2y$10$hxi9Oxul0OA2bBHcD5Qu.O6vWvshkhLOOuY7ZDOC7CN.RzfV8U.1q'),
(7, 'Caio', 'Caio', 'Manfredini', 'caiomanfredini.15@gmail.com', '-10', '0', '1', '$2y$10$BGJqdmTSi99cW5zi9wC6KuXou2ihJVXj9X6ghD14xH0lzNuU/9Yqu'),
(8, 'sky', 'Celielma', 'Costa', 'celielma19@gmai.com', '-10', '0', '1', '$2y$10$SyQQ5RL6ufvqCQuOCjDdxemt60u3WwEqw72j74KLF46GUZpQsxXnW'),
(9, 'micaellgoms', 'Micael', 'Gomes', 'micaellgoms@gmail.com', '-10', '0', '1', '$2y$10$cDfsiakBzo.aAY6rvmSPd.9QBqU7MCPYCYGZu3QEOvGc6G5xALBK.'),
(10, 'aabreu', 'Lucas', 'Abreu', 'lucasreisabreu@hotmail.com', '-10', '0', '2', '$2y$10$H5da9tuI4/BnfRwr8LgoHel3FA6p7xhxOSjrNfsC5v31B1DTKtoKK'),
(11, 'oliveira', 'Diego', 'Oliveira', 'psychodiego100@gmail.com', '-10', '0', '2', '$2y$10$zlCq3PGkpeIRRJPbobEwaOiOtGQCyPWHQNWWdq.Dz2DD3mmglYiMu'),
(12, 'ednara', 'Ednara', 'Santos', 'ednara.asp@gmail.com', '-10', '0', '1', '$2y$10$VL6sTMV7xs6kufgVdYJL0.kx2ZxnRImeGLP3M88erXgf55S73i2Aa'),
(13, 'arthurcst', 'Arthur', 'Serra', 'arthurserra10@gmail.com', '10', '0', '1', '$2y$10$W850qW6b7kBi7VJz0JaKI.i301izxylb.KiSTwxLvEh6cNHgELrF2'),
(16, 'vitorfranca', 'Vitor', 'Franca', 'vitoorbr@gmail.com', '-10', '0', '1', '$2y$10$LkLx.f2elsHfjNg2WOvzcOTKyxBjFkeNQs3ZD5ti0RsTTzcd0B.Rm');

-- --------------------------------------------------------

--
-- Table structure for table `varys`
--

CREATE TABLE IF NOT EXISTS `varys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `valor` float NOT NULL,
  `agente` varchar(255) NOT NULL,
  `origem` varchar(255) DEFAULT NULL,
  `destino` varchar(255) DEFAULT NULL,
  `dataAcao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imagem` varchar(1024) NOT NULL,
  `justificativa` varchar(2048) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `varys`
--

INSERT INTO `varys` (`id`, `tipo`, `valor`, `agente`, `origem`, `destino`, `dataAcao`, `imagem`, `justificativa`) VALUES
(39, 'deposito', 5011.06, 'gebraz', '', 'caixinha1', '2017-12-22 18:28:31', '../comprovantes/sit_atual.pdf', 'Lançamento inicial do dinheiro atual do petComp.'),
(40, 'saque', 315, 'gebraz', 'caixinha1', '', '2017-12-22 18:30:21', '../comprovantes/pizza2017.jpg', 'Compra de 10 pizzas da pizzaria Tomate, para confraternização de encerramento do ano de 2017.'),
(41, 'deposito', 20, 'arthurcst', '', 'caixinha1', '2018-01-02 18:49:27', '', 'Pagamento de débito com a caixa geral'),
(42, 'deposito', 270, 'gebraz', '', 'caixinha1', '2018-01-05 13:24:12', '', 'DevoluÃ§Ã£o do dinheiro da viagem para o Marapet'),
(43, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 14:57:51', '../comprovantes/5a4f926f610833.37795820.jpeg', 'InscriÃ§Ã£o Enepet de Ednara'),
(44, 'pagamento', 126.4, 'gebraz', 'caixinha1', '', '2018-01-05 14:58:55', '../comprovantes/5a4f92af7e1870.15295241.jpeg', 'InscriÃ§Ã£o Enepet - Alisson'),
(45, 'deposito', 180, 'gebraz', '', 'caixinha1', '2018-01-05 15:00:00', '', 'DevoluÃ§Ã£o do dinheiro da viagem para o Marapet'),
(46, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 15:05:21', '../comprovantes/5a4f94315358a5.25524154.jpeg', 'InscriÃ§Ã£o Enepet de Micael'),
(47, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 15:11:12', '../comprovantes/5a4f9590d685f7.16871679.pdf', 'InscriÃ§Ã£o Enepet de Lucas'),
(48, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 15:12:52', '../comprovantes/5a4f95f4b5fcd0.31399683.pdf', 'InscriÃ§Ã£o do Enepet - NÃ©lia'),
(49, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 15:13:56', '../comprovantes/5a4f9634e4a0f2.90879456.pdf', 'InscriÃ§Ã£o enepet - Diego'),
(50, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-01-05 15:14:58', '../comprovantes/5a4f9672535838.72408283.pdf', 'InscriÃ§Ã£o Enepet - Arthur'),
(72, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-02-06 17:22:22', '../comprovantes/5a79e44e361032.24974906.pdf', 'InscriÃ§Ã£o Enepet G. Phelipe'),
(73, 'saque', 146.23, 'gebraz', 'caixinha1', '', '2018-02-06 17:22:45', '', 'InscriÃ§Ã£o Eduardo Roger (reembolso)'),
(74, 'saque', 94.16, 'gebraz', 'caixinha1', '', '2018-02-06 17:23:10', '', 'InscriÃ§Ã£o Enepet 2018 Geraldo (Reembolso)'),
(75, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-02-06 17:23:46', '../comprovantes/5a79e4a251fe83.36045214.pdf', 'InscriÃ§Ã£o enepet 2018 - Caio Manfredini'),
(76, 'pagamento', 147.23, 'gebraz', 'caixinha1', '', '2018-02-06 17:24:11', '../comprovantes/5a79e4bbc0d542.07289093.pdf', 'InscriÃ§Ã£o enepet 2018 - Vinicius'),
(77, 'pagamento', 168.07, 'gebraz', 'caixinha1', '', '2018-02-06 17:24:42', '../comprovantes/5a79e4da96b166.52500671.pdf', 'InscriÃ§Ã£o enepet 2018 - Marcos'),
(78, 'pagamento', 168.07, 'gebraz', 'caixinha1', '', '2018-02-06 17:25:10', '../comprovantes/5a79e4f6266df1.07093115.pdf', 'InscriÃ§Ã£o enepet 2018 - gabriel monteles'),
(79, 'pagamento', 168.07, 'gebraz', 'caixinha1', '', '2018-02-06 17:25:40', '../comprovantes/5a79e514392541.32678335.pdf', 'InscriÃ§Ã£o enepet 2018 - JoÃ£o Vitor'),
(80, 'pagamento', 168.07, 'gebraz', 'caixinha1', '', '2018-02-06 17:26:12', '../comprovantes/5a79e534876fe2.45369189.pdf', 'InscriÃ§Ã£o enepet 2018 - Celielma Baldez'),
(81, 'deposito', 0.04, 'gebraz', '', 'caixinha1', '2018-02-06 17:31:16', '', 'Juros em 01/01/2018'),
(82, 'deposito', 6.43, 'gebraz', '', 'caixinha1', '2018-02-06 17:31:34', '', 'Juros em 18/01/2018'),
(83, 'deposito', 10.77, 'gebraz', '', 'caixinha1', '2018-02-06 17:31:55', '', 'Juros em 20/01/2018'),
(84, 'deposito', 0.04, 'gebraz', '', 'caixinha1', '2018-02-06 17:33:42', '', 'Juros em 01/02/2018'),
(85, 'deposito', 12.04, 'gebraz', '', 'caixinha1', '2018-02-06 17:35:01', '', 'CompensaÃ§Ã£o pag-enepet2018 por geraldo, que cobre taxas por transferÃªncia de R$ 2,10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
