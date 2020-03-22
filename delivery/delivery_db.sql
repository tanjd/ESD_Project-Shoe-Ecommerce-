SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

DROP TABLE IF EXISTS `delivery`;
CREATE TABLE IF NOT EXISTS `delivery` (
  `invoice_id` INTEGER NOT NULL ,
  `address` VARCHAR(1000) NOT NULL ,
  `status` VARCHAR(120) NOT NULL
) ENGINE = MYISAM ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

DROP TABLE IF EXISTS `markers`;
CREATE TABLE IF NOT EXISTS `markers` (
   `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `name` VARCHAR( 60 ) NOT NULL ,
  `address` VARCHAR( 80 ) NOT NULL ,
  `lat` FLOAT( 10, 6 ) NOT NULL ,
  `lng` FLOAT( 10, 6 ) NOT NULL ,
  `type` VARCHAR( 30 ) NOT NULL
) ENGINE = MYISAM ;
COMMIT;

INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('1', 'Pasir Ris White Sands Collection Point', 'Pasir Ris White Sands', '1.3724', '103.9497', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('2', 'Serangoon Nex Collection Point', 'Serangoon', '1.3508', '103.8723', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('3', 'Jurong Point Collection Point', 'Jurong', '1.3404', '103.7090', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('4', 'City Hall Collection Point', 'City Hall', '1.2907', '103.8517', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('5', 'Chinatown Collection Point', 'Chinatown', '1.2815', '103.8448', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('6', 'Clementi Collection Point', 'Clementi', '1.3162', '103.7649', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('7', 'Somerset313 Collection Point', 'Somerset', '1.3009', '103.8384', 'collection');
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES ('8', 'Punggol Waterway Collection Point', 'Punggol', '1.3984', '103.9072', 'collection');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

