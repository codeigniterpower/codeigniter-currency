-- jue 11 may 2023 13:29:20
-- Model: New Model    Version: 1.0

-- -----------------------------------------------------
-- Schema elcurrencydb
-- -----------------------------------------------------
-- currencylib databse for management

-- -----------------------------------------------------
-- Table `cur_tasas_moneda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_tasas_moneda` (
  `cod_tasa` VARCHAR(40) NOT NULL COMMENT 'YYYYMMDDhhmmss',
  `cod_moneda_base` VARCHAR(40) NOT NULL COMMENT 'cos_iso - moneda en el cual se basa la tasa, base',
  `mon_tasa_moneda` DECIMAL(40,20) NOT NULL COMMENT 'monto: cuanto moneda -destino- vale moneda -base- cada una tiene una x/1 para la inversa',
  `cod_moneda_destino` VARCHAR(40) NOT NULL COMMENT 'cos_iso - moneda el cual esta elmonto equiparado',
  `cod_tasa_tipo` VARCHAR(40) NOT NULL DEFAULT 'OFICIAL' COMMENT 'OFICIAL|INTERNA',
  `sessionflag` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien modifico YYYYMMDDhhmmss + codger + . + ficha',
  `sessionficha` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien lo creo YYYYMMDDhhmmss + codger + . + ficha',
  PRIMARY KEY (`cod_tasa`))
COMMENT = 'tabla de tasas diarias - solo se ingresa en las cod moneda tasa base existentes';


-- -----------------------------------------------------
-- Table `cur_moneda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_moneda` (
  `cod_moneda` VARCHAR(40) NOT NULL COMMENT 'moneda codigo interno',
  `iso4217a3` VARCHAR(40) NOT NULL COMMENT 'codigo iso 4217-1 de 3 letras',
  `simbolo_unicode` VARCHAR(40) NOT NULL DEFAULT '¤' COMMENT 'simbolo unicode de moneda',
  `nombre_moneda` VARCHAR(40) NULL DEFAULT 'indefinido' COMMENT 'nombre moneda comun oficial',
  `estado` VARCHAR(40) NOT NULL DEFAULT 'ACTIVO' COMMENT 'ACTIVO|INACTIVO',
  `notas_pais` VARCHAR(2000) NULL DEFAULT NULL COMMENT 'observaciones',
  `sessionflag` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien modifico YYYYMMDDhhmmss + codger + . + ficha',
  `sessionficha` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien lo creo YYYYMMDDhhmmss + codger + . + ficha',
  PRIMARY KEY (`cod_moneda`))
COMMENT = 'listado monedas en que aplica los sistemas y codigos isos';


-- -----------------------------------------------------
-- Table `cur_banco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_banco` (
  `cod_banco` VARCHAR(40) NOT NULL COMMENT 'tres primeros numeros o identificador de sus cuentas',
  `cod_pais` VARCHAR(40) NULL COMMENT 'pais codigo iso 3166 numerico de donde reside el banco',
  `cod_swif` VARCHAR(40) NULL COMMENT 'codigo SWIFT internacional',
  `cod_bic` VARCHAR(45) NULL,
  `nombre_banco` VARCHAR(40) NULL DEFAULT NULL COMMENT 'nombre natural del banco por el que se le conoce',
  `estado` VARCHAR(40) NOT NULL COMMENT 'ACTIVO|INACTIVO',
  `sessionflag` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien modifico YYYYMMDDhhmmss + codger + . + ficha',
  `sessionficha` VARCHAR(40) NULL DEFAULT NULL COMMENT 'codigo BIC internacional',
  PRIMARY KEY (`cod_banco`))
COMMENT = 'codigos y nombres de bancos';


-- -----------------------------------------------------
-- Table `cur_pais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_pais` (
  `cod_pais` VARCHAR(40) NOT NULL COMMENT 'pais codigo iso 3166 numerico',
  `nombre_pais` VARCHAR(400) NOT NULL COMMENT 'nombre comun conocido',
  `nombre_iso` VARCHAR(400) NOT NULL COMMENT 'nombre iso 3166-1',
  `iso3166a2` VARCHAR(40) NOT NULL COMMENT 'codigo iso 3166 alfa 2 letras',
  `iso3166a3` VARCHAR(40) NOT NULL COMMENT 'codigo iso 3166 alfa 3 letras',
  `estado` VARCHAR(40) NULL DEFAULT 'ACTIVO' COMMENT 'ACTIVO|INACTIVO',
  `notas_pais` VARCHAR(2000) NULL DEFAULT NULL COMMENT 'observaciones',
  `sessionflag` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien modifico YYYYMMDDhhmmss + codger + . + ficha',
  `sessionficha` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien lo creo YYYYMMDDhhmmss + codger + . + ficha',
  PRIMARY KEY (`cod_pais`))
COMMENT = 'listado paises en que aplica los sistemas y codigos isos';


-- -----------------------------------------------------
-- Table `cur_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_usuarios` (
  `user_id` VARCHAR(40) NOT NULL COMMENT 'intranet o correo del usuario',
  `user_status` VARCHAR(40) NULL DEFAULT 'PASIVO' COMMENT 'PASIVO|ACTIVO',
  `cur_monedas_base` VARCHAR(40) NULL COMMENT 'lista separada por comas de monedas preferida base',
  `cur_monedas_dest` VARCHAR(40) NULL COMMENT 'lista separada monedas get rates',
  `sessionflag` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien modifico YYYYMMDDhhmmss + codger + . + ficha',
  `sessionficha` VARCHAR(40) NULL DEFAULT NULL COMMENT 'quien lo creo YYYYMMDDhhmmss + codger + . + ficha',
  PRIMARY KEY (`user_id`))
COMMENT = 'acceso, entra o no entra segun aparezca, autentica es con el mta';


-- -----------------------------------------------------
-- Table `cur_session`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cur_session` (
  `user_id` VARCHAR(40) NOT NULL COMMENT 'username or user mail',
  `user_extra` VARCHAR(45) NULL COMMENT 'reserved column for extra data',
  `sessionuser` VARCHAR(40) NOT NULL COMMENT 'YYYYMMDDHHmmss.ip.XXXXXXXX',
  PRIMARY KEY (`sessionuser`))
COMMENT = 'stored the current sesions active';


-- -----------------------------------------------------
-- Data for table `cur_tasas_moneda`
-- -----------------------------------------------------
INSERT INTO `cur_tasas_moneda` (`cod_tasa`, `cod_moneda_base`, `mon_tasa_moneda`, `cod_moneda_destino`, `cod_tasa_tipo`, `sessionflag`, `sessionficha`) VALUES ('20201211080000', '928', 0.00000092576231029539, '840', 'INTERNA', 'NULL', 'NULL');
INSERT INTO `cur_tasas_moneda` (`cod_tasa`, `cod_moneda_base`, `mon_tasa_moneda`, `cod_moneda_destino`, `cod_tasa_tipo`, `sessionflag`, `sessionficha`) VALUES ('20201211080001', '840', 1080190.87500000000000000000, '928', 'INTERNA', 'NULL', 'NULL');


-- -----------------------------------------------------
-- Data for table `cur_moneda`
-- -----------------------------------------------------
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('104', 'MMK', 'K', 'Kyat', 'ACTIVO', 'Myanmar (Burma)', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('108', 'BIF', '₣', 'Burundi Franc', 'ACTIVO', 'Burundi', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('116', 'KHR', '៛', 'Riel', 'ACTIVO', 'Cambodia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('012', 'DZD', 'د.ج', 'Algerian Dinar', 'ACTIVO', 'Algeria', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('124', 'CAD', '$', 'Canadian Dollar', 'ACTIVO', 'Canada', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('132', 'CVE', '$', 'Cape Verde Escudo', 'ACTIVO', 'Cape Verde', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('136', 'KYD', '$', 'Cayman Islands Dollar', 'ACTIVO', 'Cayman Islands', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('144', 'LKR', 'Rs', 'Sri Lanka Rupee', 'ACTIVO', 'Sri Lanka', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('152', 'CLP', '$', 'Chilean Peso', 'ACTIVO', 'Chile', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('156', 'CNY', '¥', 'Yuan', 'ACTIVO', 'China', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('170', 'COP', '$', 'Colombian Peso', 'ACTIVO', 'Colombia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('188', 'CRC', '₡', 'Costa Rican Colon', 'ACTIVO', 'Costa Rica', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('191', 'HRK', 'Kn', 'Croatian Kuna', 'ACTIVO', 'Croatia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('192', 'CUP', '$', 'Cuban Peso', 'ACTIVO', 'Cuba', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('203', 'CZK', 'Kč', 'Czech Koruna', 'ACTIVO', 'Czech Republic', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('208', 'DKK', 'kr', 'Danish Krone', 'ACTIVO', 'Denmark', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('214', 'DOP', '$', 'Dominican Peso', 'ACTIVO', 'Dominican Republic', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('230', 'ETB', '¤', 'Ethiopian Birr', 'ACTIVO', 'Ethiopia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('232', 'ERN', 'Nfk', 'Nakfa', 'ACTIVO', 'Eritrea', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('238', 'FKP', '£', 'Falkland Islands Pound', 'ACTIVO', 'Falkland Islands', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('242', 'FJD', '$', 'Fiji Dollar', 'ACTIVO', 'Fiji', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('262', 'DJF', '₣', 'Djibouti Franc', 'ACTIVO', 'Djibouti', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('270', 'GMD', 'D', 'Dalasi', 'ACTIVO', 'Gambia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('292', 'GIP', '£', 'Gibraltar Pound', 'ACTIVO', 'Gibraltar', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('032', 'ARS', '$', 'Argentine Peso', 'ACTIVO', 'Argentina', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('320', 'GTQ', 'Q', 'Quetzal', 'ACTIVO', 'Guatemala', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('324', 'GNF', '₣', 'Guinea Franc', 'ACTIVO', 'Guinea', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('328', 'GYD', '$', 'Guyana Dollar', 'ACTIVO', 'Guyana', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('332', 'HTG', 'G', 'Gourde', 'ACTIVO', 'Haiti', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('340', 'HNL', 'L', 'Lempira', 'ACTIVO', 'Honduras', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('344', 'HKD', '$', 'Hong Kong Dollar', 'ACTIVO', 'Hong Kong', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('348', 'HUF', 'Ft', 'Forint', 'ACTIVO', 'Hungary', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('352', 'ISK', 'Kr', 'Iceland Krona', 'ACTIVO', 'Iceland', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('356', 'INR', '₹', 'Indian Rupee', 'ACTIVO', 'Bhutan India', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('036', 'AUD', '$', 'Australian Dollar', 'ACTIVO', 'Australia Kiribati Coconut Islands Nauru Tuvalu', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('360', 'IDR', 'Rp', 'Rupiah', 'ACTIVO', 'Indonesia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('364', 'IRR', '﷼', 'Iranian Rial', 'ACTIVO', 'Iran', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('368', 'IQD', 'ع.د', 'Iraqi Dinar', 'ACTIVO', 'Iraq', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('376', 'ILS', '₪', 'New Israeli Shekel', 'ACTIVO', 'Israel Palestine', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('388', 'JMD', '$', 'Jamaican Dollar', 'ACTIVO', 'Jamaica', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('392', 'JPY', '¥', 'Yen', 'ACTIVO', 'Japan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('398', 'KZT', '〒', 'Tenge', 'ACTIVO', 'Kazakhstan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('400', 'JOD', 'د.ا', 'Jordanian Dinar', 'ACTIVO', 'Jordan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('404', 'KES', 'Sh', 'Kenyan Shilling', 'ACTIVO', 'Kenya', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('408', 'KPW', '₩', 'North Korean Won', 'ACTIVO', 'North Korea', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('410', 'KRW', '₩', 'South Korean Won', 'ACTIVO', 'South Korea', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('414', 'KWD', 'د.ك', 'Kuwaiti Dinar', 'ACTIVO', 'Kuwait', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('417', 'KGS', '¤', 'Som', 'ACTIVO', 'Kyrgyzstan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('418', 'LAK', '₭', 'Kip', 'ACTIVO', 'Laos', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('422', 'LBP', 'ل.ل', 'Lebanese Pound', 'ACTIVO', 'Lebanon', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('426', 'LSL', 'L', 'Loti', 'ACTIVO', 'Lesotho', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('430', 'LRD', '$', 'Liberian Dollar', 'ACTIVO', 'Liberia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('434', 'LYD', 'ل.د', 'Libyan Dinar', 'ACTIVO', 'Libya', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('044', 'BSD', '$', 'Bahamian Dollar', 'ACTIVO', 'Bahamas', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('446', 'MOP', 'P', 'Pataca', 'ACTIVO', 'Macao', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('454', 'MWK', 'MK', 'Kwacha', 'ACTIVO', 'Malawi', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('458', 'MYR', 'RM', 'Malaysian Ringgit', 'ACTIVO', 'Malaysia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('462', 'MVR', 'ރ.', 'Rufiyaa', 'ACTIVO', 'Maldives', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('048', 'BHD', 'ب.د', 'Bahraini Dinar', 'ACTIVO', 'Bahrain', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('480', 'MUR', '₨', 'Mauritius Rupee', 'ACTIVO', 'Mauritius', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('484', 'MXN', '$', 'Mexican Peso', 'ACTIVO', 'Mexico', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('496', 'MNT', '₮', 'Tugrik', 'ACTIVO', 'Mongolia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('498', 'MDL', 'L', 'Moldovan Leu', 'ACTIVO', 'Moldova', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('050', 'BDT', '৳', 'Taka', 'ACTIVO', 'Bangladesh', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('504', 'MAD', 'د.م.', 'Moroccan Dirham', 'ACTIVO', 'Morocco', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('051', 'AMD', 'Դ', 'Armenian Dram', 'ACTIVO', 'Armenia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('512', 'OMR', 'ر.ع.', 'Rial Omani', 'ACTIVO', 'Oman', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('516', 'NAD', '$', 'Namibia Dollar', 'ACTIVO', 'Namibia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('052', 'BBD', '$', 'Barbados Dollar', 'ACTIVO', 'Barbados', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('524', 'NPR', '₨', 'Nepalese Rupee', 'ACTIVO', 'Nepal', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('533', 'AWG', 'ƒ', 'Aruban Guilder/Florin', 'ACTIVO', 'Aruba', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('548', 'VUV', 'Vt', 'Vatu', 'ACTIVO', 'Vanuatu', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('554', 'NZD', '$', 'New Zealand Dollar', 'ACTIVO', 'Cook Islands New Zealand Niue Pitcairn Island', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('558', 'NIO', 'C$', 'Cordoba Oro', 'ACTIVO', 'Nicaragua', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('566', 'NGN', '₦', 'Naira', 'ACTIVO', 'Nigeria', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('578', 'NOK', 'kr', 'Norwegian Krone', 'ACTIVO', 'Norway', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('586', 'PKR', '₨', 'Pakistan Rupee', 'ACTIVO', 'Pakistan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('590', 'PAB', 'B/.', 'Balboa', 'ACTIVO', 'Panama', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('598', 'PGK', 'K', 'Kina', 'ACTIVO', 'Papua New Guinea', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('060', 'BMD', '$', 'Bermudian Dollar', 'ACTIVO', 'Bermuda', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('600', 'PYG', '₲', 'Guarani', 'ACTIVO', 'Paraguay', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('604', 'PEN', 'S/.', 'Nuevo Sol', 'ACTIVO', 'Peru', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('608', 'PHP', '₱', 'Philippine Peso', 'ACTIVO', 'Philippines', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('634', 'QAR', 'ر.ق', 'Qatari Rial', 'ACTIVO', 'Qatar', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('064', 'BTN', '¤', 'Ngultrum', 'ACTIVO', 'Bhutan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('643', 'RUB', 'р.', 'Russian Ruble', 'ACTIVO', 'Russia South Ossetia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('646', 'RWF', '₣', 'Rwanda Franc', 'ACTIVO', 'Rwanda', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('654', 'SHP', '£', 'Saint Helena Pound', 'ACTIVO', 'Ascension Island Saint Helena Tristan da Cunha', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('068', 'BOB', 'Bs.', 'Boliviano', 'ACTIVO', 'Bolivia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('682', 'SAR', 'ر.س', 'Saudi Riyal', 'ACTIVO', 'Saudi Arabia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('690', 'SCR', '₨', 'Seychelles Rupee', 'ACTIVO', 'Seychelles', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('694', 'SLL', 'Le', 'Leone', 'ACTIVO', 'Sierra Leone', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('702', 'SGD', '$', 'Singapore Dollar', 'ACTIVO', 'Brunei Singapore', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('704', 'VND', '₫', 'Dong', 'ACTIVO', 'Vietnam', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('706', 'SOS', 'Sh', 'Somali Shilling', 'ACTIVO', 'Somalia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('710', 'ZAR', 'R', 'Rand', 'ACTIVO', 'Lesotho Namibia South Africa', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('072', 'BWP', 'P', 'Pula', 'ACTIVO', 'Botswana', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('748', 'SZL', 'L', 'Lilangeni', 'ACTIVO', 'Swaziland', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('752', 'SEK', 'kr', 'Swedish Krona', 'ACTIVO', 'Sweden', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('756', 'CHF', '₣', 'Swiss Franc', 'ACTIVO', 'Lichtenstein Switzerland', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('760', 'SYP', 'ل.س', 'Syrian Pound', 'ACTIVO', 'Syria', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('764', 'THB', '฿', 'Baht', 'ACTIVO', 'Thailand', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('776', 'TOP', 'T$', 'Pa’anga', 'ACTIVO', 'Tonga', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('780', 'TTD', '$', 'Trinidad and Tobago Dollar', 'ACTIVO', 'Trinidad and Tobago', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('784', 'AED', 'د.إ', 'UAE Dirham', 'ACTIVO', 'UAE', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('788', 'TND', 'د.ت', 'Tunisian Dinar', 'ACTIVO', 'Tunisia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('008', 'ALL', 'L', 'Lek', 'ACTIVO', 'Albania', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('800', 'UGX', 'Sh', 'Uganda Shilling', 'ACTIVO', 'Uganda', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('807', 'MKD', 'ден', 'Denar', 'ACTIVO', 'Macedonia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('818', 'EGP', '£', 'Egyptian Pound', 'ACTIVO', 'Egypt', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('826', 'GBP', '£', 'Pound Sterling', 'ACTIVO', 'Alderney British Indian Ocean Territory Great Britain Isle of Maine', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('834', 'TZS', 'Sh', 'Tanzanian Shilling', 'ACTIVO', 'Tanzania', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('084', 'BZD', '$', 'Belize Dollar', 'ACTIVO', 'Belize', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('840', 'USD', '$', 'US Dollar', 'ACTIVO', 'American Samoa British Indian Ocean Territory British Virgin Islands Guam Haiti Marshall Islands Micronesia Northern Mariana Islands Pacific Remote islands Palau Panama Puerto Rico Turks and Caicos Islands United States of America US Virgin Islands', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('858', 'UYU', '$', 'Peso Uruguayo', 'ACTIVO', 'Uruguay', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('860', 'UZS', '¤', 'Uzbekistan Sum', 'ACTIVO', 'Uzbekistan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('882', 'WST', 'T', 'Tala', 'ACTIVO', 'Samoa', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('886', 'YER', '﷼', 'Yemeni Rial', 'ACTIVO', 'Yemen', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('090', 'SBD', '$', 'Solomon Islands Dollar', 'ACTIVO', 'Solomon Islands', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('901', 'TWD', '$', 'Taiwan Dollar', 'ACTIVO', 'Taiwan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('928', 'VES', 'Bs', 'Bolivar Soberano', 'ACTIVO', 'Venezuela', 'NULL', 'NULL');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('929', 'MRU', 'UM', 'Ouguiya', 'ACTIVO', 'Mauritania', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('930', 'STN', 'Db', 'Dobra', 'ACTIVO', 'Sao Tome and Principe', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('932', 'ZWL', '$', 'Zimbabwe Dollar', 'ACTIVO', 'Zimbabwe', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('933', 'BYN', 'Br', 'Belarusian Ruble', 'ACTIVO', 'Belarus', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('934', 'TMT', 'm', 'Manat', 'ACTIVO', 'Turkmenistan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('936', 'GHS', '₵', 'Cedi', 'ACTIVO', 'Ghana', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('937', 'VEF', 'Bs F', 'Bolivar Fuerte', 'INACTIVO', 'Venezuela', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('938', 'SDG', '£', 'Sudanese Pound', 'ACTIVO', 'Sudan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('941', 'RSD', 'din', 'Serbian Dinar', 'ACTIVO', 'Kosovo Serbia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('943', 'MZN', 'MTn', 'Metical', 'ACTIVO', 'Mozambique', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('944', 'AZN', 'ман', 'Azerbaijanian Manat', 'ACTIVO', 'Azerbaijan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('946', 'RON', 'L', 'Leu', 'ACTIVO', 'Romania', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('949', 'TRY', '₤', 'Turkish Lira', 'ACTIVO', 'North Cyprus Turkey', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('950', 'XAF', '₣', 'CFA Franc BCEAO', 'ACTIVO', 'Benin Burkina Faso Cameroon Central African Republic Chad Congo (Brazzaville)', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('951', 'XCD', '$', 'East Caribbean Dollar', 'ACTIVO', 'Anguilla Antigua and Barbuda Dominica Grenada Montserrat Saint Kitts and Nevis Saint Lucia Saint Vincent and Grenadine', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('953', 'XPF', '₣', 'CFP Franc', 'ACTIVO', 'French Polynesia New Caledonia Wallis and Futuna', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('096', 'BND', '$', 'Brunei Dollar', 'ACTIVO', 'Brunei Singapore', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('967', 'ZMW', 'ZK', 'Zambian Kwacha', 'ACTIVO', 'Zambia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('968', 'SRD', '$', 'Suriname Dollar', 'ACTIVO', 'Suriname', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('969', 'MGA', '¤', 'Malagasy Ariary', 'ACTIVO', 'Madagascar', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('971', 'AFN', 'Af', 'Afghani', 'ACTIVO', 'Afghanistan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('972', 'TJS', 'ЅМ', 'Somoni', 'ACTIVO', 'Tajikistan', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('973', 'AOA', 'Kz', 'Kwanza', 'ACTIVO', 'Angola', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('975', 'BGN', 'лв', 'Bulgarian Lev', 'ACTIVO', 'Bulgaria', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('976', 'CDF', '₣', 'Congolese Franc', 'ACTIVO', 'Congo (Kinshasa)', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('977', 'BAM', 'КМ', 'Konvertibilna Marka', 'ACTIVO', 'Bosnia and Herzegovina', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('978', 'EUR', '€', 'Euro', 'ACTIVO', 'Akrotiri and Dhekelia  Andorra Austria Belgium Cyprus Estonia Finland France Germany Greece Ireland Italy Kosovo Latvia Lithuania  Luxembourg Malta Monaco Montenegro Netherlands Portugal San-Marino Slovakia  Slovenia Spain Vatican', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('980', 'UAH', '₴', 'Hryvnia', 'ACTIVO', 'Ukraine', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('981', 'GEL', 'ლ', 'Lari', 'ACTIVO', 'Georgia South Ossetia', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('985', 'PLN', 'zł', 'PZloty', 'ACTIVO', 'Poland', '', '');
INSERT INTO `cur_moneda` (`cod_moneda`, `iso4217a3`, `simbolo_unicode`, `nombre_moneda`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('986', 'BRL', 'R$', 'Brazilian Real', 'ACTIVO', 'Brazil', '', '');



-- -----------------------------------------------------
-- Data for table `cur_banco`
-- -----------------------------------------------------
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('102', '862', 'NACIONAL', 'NULL', 'BANCO DE VENEZUELA S.A.I.C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('104', '862', 'NACIONAL', 'NULL', 'BANCO VENEZOLANO DE CREDITO S.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('105', '862', 'NACIONAL', 'NULL', 'BANCO MERCANTIL C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('108', '862', 'NACIONAL', 'NULL', 'BANCO PROVINCIAL BBVA', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('114', '862', 'NACIONAL', 'NULL', 'BANCO DEL CARIBE C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('115', '862', 'NACIONAL', 'NULL', 'BANCO EXTERIOR C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('116', '862', 'NACIONAL', 'NULL', 'BANCO OCCIDENTAL DE DESCUENTO.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('121', '862', 'NACIONAL', 'NULL', 'CORP BANCA.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('128', '862', 'NACIONAL', 'NULL', 'BANCO CARONI C.A. BANCO UNIVERSAL', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('134', '862', 'NACIONAL', 'NULL', 'BANESCO BANCO UNIVERSAL  ', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('137', '862', 'NACIONAL', 'NULL', 'SOFITASA', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('138', '862', 'NACIONAL', 'NULL', 'BANCO PLAZA', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('146', '862', 'NACIONAL', 'NULL', 'BANGENTE', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('149', '862', 'NACIONAL', 'NULL', 'BANCO DEL PUEBLO SOBERANO C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('151', '862', 'NACIONAL', 'NULL', 'FONDO COMUN', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('156', '862', 'NACIONAL', 'NULL', '100%BANCO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('157', '862', 'NACIONAL', 'NULL', 'DELSUR BANCO UNIVERSAL', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('163', '862', 'NACIONAL', 'NULL', 'BANCO DEL TESORO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('164', '862', 'NACIONAL', 'NULL', 'BANCO DE DESARROLLO DEL MICROEMPRESARIO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('166', '862', 'NACIONAL', 'NULL', 'BANCO AGRICOLA', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('168', '862', 'NACIONAL', 'NULL', 'BANCRECER S.A. BANCO DE DESARROLLO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('169', '862', 'NACIONAL', 'NULL', 'MIBANCO BANCO DE DESARROLLO C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('171', '862', 'NACIONAL', 'NULL', 'BANCO ACTIVO BANCO COMERCIAL C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('172', '862', 'NACIONAL', 'NULL', 'BANCAMIGA BANCO MICROFINANCIERO C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('173', '862', 'NACIONAL', 'NULL', 'BANCO INTERNACIONAL DE DESARROLLO C.A.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('174', '862', 'NACIONAL', 'NULL', 'BANPLUS BANCO COMERCIAL C.A', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('175', '862', 'NACIONAL', 'NULL', 'BANCO BICENTENARIO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('176', '862', 'NACIONAL', 'NULL', 'BANCO ESPIRITO SANTO S.A', 'INACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('177', '862', 'NACIONAL', 'NULL', 'BANFANB', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('190', '862', 'NACIONAL', 'NULL', 'CITIBANK.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('191', '862', 'NACIONAL', 'NULL', 'BANCO NACIONAL DE CREDITO', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('196', '862', 'NACIONAL', 'NULL', 'ABN AMRO BANK', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('3', '862', 'NACIONAL', 'NULL', 'BANCO INDUSTRIAL DE VENEZUELA.', 'ACTIVO', '', '');
INSERT INTO `cur_banco` (`cod_banco`, `cod_pais`, `cod_swif`, `cod_bic`, `nombre_banco`, `estado`, `sessionflag`, `sessionficha`) VALUES ('601', '862', 'NACIONAL', 'NULL', 'INSTITUTO MUNICIPAL DE CREDITO POPULAR', 'ACTIVO', '', '');



-- -----------------------------------------------------
-- Data for table `cur_pais`
-- -----------------------------------------------------
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('4', 'Afganistán', 'Afganistán', 'AF', 'AFG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('248', 'Åland', 'Åland Islas', 'AX', 'ALA', 'NULL', 'Es una provincia autónoma deFinlandia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('8', 'Albania', 'Albania', 'AL', 'ALB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('276', 'Alemania', 'Alemania', 'DE', 'DEU', 'NULL', 'Códigos obtenidos del idioma nativo alemán):Deutschland Códigos alfa usados porAlemania Occidentalantes de lareunificación alemanaen 1990.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('20', 'Andorra', 'Andorra', 'AD', 'AND', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('24', 'Angola', 'Angola', 'AO', 'AGO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('660', 'Anguila', 'Anguila', 'AI', 'AIA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('10', 'Antártida', 'Antártida', 'AQ', 'ATA', 'NULL', 'Cubre el territorio al sur delparalelo 60º sur.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('28', 'Antigua y Barbuda', 'Antigua y Barbuda', 'AG', 'ATG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('682', 'Arabia Saudita', 'Arabia Saudita', 'SA', 'SAU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('12', 'Argelia', 'Argelia', 'DZ', 'DZA', 'NULL', 'Códigos obtenidos del idioma nativo (cabilio):Dzayer', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('32', 'Argentina', 'Argentina', 'AR', 'ARG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('51', 'Armenia', 'Armenia', 'AM', 'ARM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('533', 'Aruba', 'Aruba', 'AW', 'ABW', 'NULL', 'Forma parte delReino de los Países Bajos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('36', 'Australia', 'Australia', 'AU', 'AUS', 'NULL', 'Incluye lasIslas Ashmore y Cartiery lasIslas del Mar del Coral.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('40', 'Austria', 'Austria', 'AT', 'AUT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('31', 'Azerbaiyán', 'Azerbaiyán', 'AZ', 'AZE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('44', 'Bahamas', 'Bahamas (las)', 'BS', 'BHS', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('50', 'Bangladés', 'Bangladesh', 'BD', 'BGD', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('52', 'Barbados', 'Barbados', 'BB', 'BRB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('48', 'Baréin', 'Bahrein', 'BH', 'BHR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('56', 'Bélgica', 'Bélgica', 'BE', 'BEL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('84', 'Belice', 'Belice', 'BZ', 'BLZ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('204', 'Benín', 'Benín', 'BJ', 'BEN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('60', 'Bermudas', 'Bermudas', 'BM', 'BMU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('112', 'Bielorrusia', 'Belarús', 'BY', 'BLR', 'NULL', 'El nombre oficial del país esBelarús aunque tradicionalmente se le sigue denominandoBielorrusia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('68', 'Bolivia', 'Bolivia (Estado Plurinacional de)', 'BO', 'BOL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('535', 'Bonaire San Eustaquio y Saba', 'Bonaire San Eustaquio y Saba', 'BQ', 'BES', 'NULL', 'Son tres municipios especiales que forman parte de losPaíses Bajos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('70', 'Bosnia y Herzegovina', 'Bosnia y Herzegovina', 'BA', 'BIH', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('72', 'Botsuana', 'Botsuana', 'BW', 'BWA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('76', 'Brasil', 'Brasil', 'BR', 'BRA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('96', 'Brunéi', 'Brunéi Darussalam', 'BN', 'BRN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('100', 'Bulgaria', 'Bulgaria', 'BG', 'BGR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('854', 'Burkina Faso', 'Burkina Faso', 'BF', 'BFA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('108', 'Burundi', 'Burundi', 'BI', 'BDI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('64', 'Bután', 'Bhután', 'BT', 'BTN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('132', 'Cabo Verde', 'Cabo Verde', 'CV', 'CPV', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('116', 'Camboya', 'Camboya', 'KH', 'KHM', 'NULL', 'Códigos obtenidos del anterior nombre:Khmer Republic (República Jemer)', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('120', 'Camerún', 'Camerún', 'CM', 'CMR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('124', 'Canadá', 'Canadá', 'CA', 'CAN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('634', 'Catar', 'Qatar', 'QA', 'QAT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('148', 'Chad', 'Chad', 'TD', 'TCD', 'NULL', 'Códigos obtenidos del nombre enfrancés:Tchad', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('152', 'Chile', 'Chile', 'CL', 'CHL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('156', 'China', 'China', 'CN', 'CHN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('196', 'Chipre', 'Chipre', 'CY', 'CYP', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('170', 'Colombia', 'Colombia', 'CO', 'COL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('174', 'Comoras', 'Comoras (las)', 'KM', 'COM', 'NULL', 'Códigos obtenidos del idioma nativo (comorense):Komori', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('408', 'Corea del Norte', 'Corea (la República Popular Democrática de)', 'KP', 'PRK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('410', 'Corea del Sur', 'Corea (la República de)', 'KR', 'KOR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('384', 'Costa de Marfil', 'Côte d Ivoire', 'CI', 'CIV', 'NULL', 'Nombre oficial en la ISO enfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('188', 'Costa Rica', 'Costa Rica', 'CR', 'CRI', 'NULL', 'Nombre oficial en la ISO enespañol.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('191', 'Croacia', 'Croacia', 'HR', 'HRV', 'NULL', 'Códigos obtenidos del idioma nativo (croata):Hrvatska', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('192', 'Cuba', 'Cuba', 'CU', 'CUB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('531', 'Curazao', 'Curaçao', 'CW', 'CUW', 'NULL', 'Forma parte delReino de los Países Bajos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('208', 'Dinamarca', 'Dinamarca', 'DK', 'DNK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('212', 'Dominica', 'Dominica', 'DM', 'DMA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('218', 'Ecuador', 'Ecuador', 'EC', 'ECU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('818', 'Egipto', 'Egipto', 'EG', 'EGY', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('222', 'El Salvador', 'El Salvador', 'SV', 'SLV', 'NULL', 'Nombre oficial en la ISO enespañol.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('784', 'Emiratos Árabes Unidos', 'Emiratos Árabes Unidos (los)', 'AE', 'ARE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('232', 'Eritrea', 'Eritrea', 'ER', 'ERI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('703', 'Eslovaquia', 'Eslovaquia', 'SK', 'SVK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('705', 'Eslovenia', 'Eslovenia', 'SI', 'SVN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('724', 'España', 'España', 'ES', 'ESP', 'NULL', 'Códigos obtenidos del idioma nativo (español):España', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('840', 'Estados Unidos', 'Estados Unidos de América (los)', 'US', 'USA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('233', 'Estonia', 'Estonia', 'EE', 'EST', 'NULL', 'Códigos obtenidos del idioma nativo (estonio):Eesti', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('231', 'Etiopía', 'Etiopía', 'ET', 'ETH', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('608', 'Filipinas', 'Filipinas (las)', 'PH', 'PHL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('246', 'Finlandia', 'Finlandia', 'FI', 'FIN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('242', 'Fiyi', 'Fiji', 'FJ', 'FJI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('250', 'Francia', 'Francia', 'FR', 'FRA', 'NULL', 'Incluye laIsla Clipperton.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('266', 'Gabón', 'Gabón', 'GA', 'GAB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('270', 'Gambia', 'Gambia (la)', 'GM', 'GMB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('268', 'Georgia', 'Georgia', 'GE', 'GEO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('288', 'Ghana', 'Ghana', 'GH', 'GHA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('292', 'Gibraltar', 'Gibraltar', 'GI', 'GIB', 'NULL', 'Pertenece alReino Unido.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('308', 'Granada', 'Granada', 'GD', 'GRD', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('300', 'Grecia', 'Grecia', 'GR', 'GRC', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('304', 'Groenlandia', 'Groenlandia', 'GL', 'GRL', 'NULL', 'Pertenece alReino de Dinamarca.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('312', 'Guadalupe', 'Guadeloupe', 'GP', 'GLP', 'NULL', 'Departamento de ultramarfrancés. Nombre oficial en la ISO enfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('316', 'Guam', 'Guam', 'GU', 'GUM', 'NULL', 'Territorio no incorporado de los Estados Unidos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('320', 'Guatemala', 'Guatemala', 'GT', 'GTM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('254', 'Guayana Francesa', 'Guayana Francesa', 'GF', 'GUF', 'NULL', 'Departamento de ultramarfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('831', 'Guernsey', 'Guernsey', 'GG', 'GGY', 'NULL', 'Unadependencia de la Corona británica.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('324', 'Guinea', 'Guinea', 'GN', 'GIN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('624', 'Guinea-Bisáu', 'Guinea Bissau', 'GW', 'GNB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('226', 'Guinea Ecuatorial', 'Guinea Ecuatorial', 'GQ', 'GNQ', 'NULL', 'Códigos obtenidos del nombre enfrancés:Guinée équatoriale', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('328', 'Guyana', 'Guyana', 'GY', 'GUY', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('332', 'Haití', 'Haití', 'HT', 'HTI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('340', 'Honduras', 'Honduras', 'HN', 'HND', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('344', 'Hong Kong', 'Hong Kong', 'HK', 'HKG', 'NULL', 'Región administrativa especialdeChina.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('348', 'Hungría', 'Hungría', 'HU', 'HUN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('356', 'India', 'India', 'IN', 'IND', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('360', 'Indonesia', 'Indonesia', 'ID', 'IDN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('368', 'Irak', 'Iraq', 'IQ', 'IRQ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('364', 'Irán', 'Irán (República Islámica de)', 'IR', 'IRN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('372', 'Irlanda', 'Irlanda', 'IE', 'IRL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('74', 'Isla Bouvet', 'Bouvet Isla', 'BV', 'BVT', 'NULL', 'Pertenece aNoruega.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('833', 'Isla de Man', 'Isla de Man', 'IM', 'IMN', 'NULL', 'Unadependencia de la Corona británica.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('162', 'Isla de Navidad', 'Navidad Isla de', 'CX', 'CXR', 'NULL', 'Pertenece aAustralia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('352', 'Islandia', 'Islandia', 'IS', 'ISL', 'NULL', 'Códigos obtenidos del idioma nativo (islandés):Ísland', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('136', 'Islas Caimán', 'Caimán (las) Islas', 'KY', 'CYM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('166', 'Islas Cocos', 'Cocos / Keeling (las) Islas', 'CC', 'CCK', 'NULL', 'Pertenecen aAustralia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('184', 'Islas Cook', 'Cook (las) Islas', 'CK', 'COK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('234', 'Islas Feroe', 'Feroe (las) Islas', 'FO', 'FRO', 'NULL', 'Pertenecen alReino de Dinamarca.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('239', 'Islas Georgias del Sur y Sandwich del Sur', 'Georgia del Sur (la) y las Islas Sandwich del Sur', 'GS', 'SGS', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('334', 'Islas Heard y McDonald', 'Heard (Isla) e Islas McDonald', 'HM', 'HMD', 'NULL', 'Pertenecen aAustralia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('238', 'Islas Malvinas', 'Malvinas [Falkland] (las) Islas', 'FK', 'FLK', 'NULL', 'Códigos obtenidos del nombre en (inglés):Falkland', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('580', 'Islas Marianas del Norte', 'Marianas del Norte (las) Islas', 'MP', 'MNP', 'NULL', 'Territorio no incorporado de los Estados Unidos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('584', 'Islas Marshall', 'Marshall (las) Islas', 'MH', 'MHL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('612', 'Islas Pitcairn', 'Pitcairn', 'PN', 'PCN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('90', 'Islas Salomón', 'Salomón Islas', 'SB', 'SLB', 'NULL', 'Códigos obtenidos de su anterior nombre:British Solomon Islands', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('796', 'Islas Turcas y Caicos', 'Turcas y Caicos (las) Islas', 'TC', 'TCA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('581', 'Islas Ultramarinas Menores de los Estados Unidos', 'Islas Ultramarinas Menores de los Estados Unidos (las)', 'UM', 'UMI', 'NULL', 'Comprende nueve áreas insulares menores de losEstados Unidos:Arrecife KingmanAtolón JohnstonAtolón PalmyraIsla BakerIsla HowlandIsla JarvisIslas MidwayIsla de NavazaeIsla Wake.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('92', 'Islas Vírgenes Británicas', 'Vírgenes británicas Islas', 'VG', 'VGB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('850', 'Islas Vírgenes Americanas', 'Vírgenes de los Estados Unidos Islas', 'VI', 'VIR', 'NULL', 'Territorio no incorporado de los Estados Unidos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('376', 'Israel', 'Israel', 'IL', 'ISR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('380', 'Italia', 'Italia', 'IT', 'ITA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('388', 'Jamaica', 'Jamaica', 'JM', 'JAM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('392', 'Japón', 'Japón', 'JP', 'JPN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('832', 'Jersey', 'Jersey', 'JE', 'JEY', 'NULL', 'Unadependencia de la Corona británica.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('400', 'Jordania', 'Jordania', 'JO', 'JOR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('398', 'Kazajistán', 'Kazajistán', 'KZ', 'KAZ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('404', 'Kenia', 'Kenia', 'KE', 'KEN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('417', 'Kirguistán', 'Kirguistán', 'KG', 'KGZ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('296', 'Kiribati', 'Kiribati', 'KI', 'KIR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('414', 'Kuwait', 'Kuwait', 'KW', 'KWT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('418', 'Laos', 'Lao (la) República Democrática Popular', 'LA', 'LAO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('426', 'Lesoto', 'Lesotho', 'LS', 'LSO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('428', 'Letonia', 'Letonia', 'LV', 'LVA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('422', 'Líbano', 'Líbano', 'LB', 'LBN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('430', 'Liberia', 'Liberia', 'LR', 'LBR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('434', 'Libia', 'Libia', 'LY', 'LBY', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('438', 'Liechtenstein', 'Liechtenstein', 'LI', 'LIE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('440', 'Lituania', 'Lituania', 'LT', 'LTU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('442', 'Luxemburgo', 'Luxemburgo', 'LU', 'LUX', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('446', 'Macao', 'Macao', 'MO', 'MAC', 'NULL', 'Región administrativa especialdeChina.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('807', 'Macedonia del Norte', 'Macedonia del Norte', 'MK', 'MKD', 'NULL', 'Ver:Disputa sobre el nombre de Macedonia', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('450', 'Madagascar', 'Madagascar', 'MG', 'MDG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('458', 'Malasia', 'Malasia', 'MY', 'MYS', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('454', 'Malaui', 'Malawi', 'MW', 'MWI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('462', 'Maldivas', 'Maldivas', 'MV', 'MDV', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('466', 'Malí', 'Malí', 'ML', 'MLI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('470', 'Malta', 'Malta', 'MT', 'MLT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('504', 'Marruecos', 'Marruecos', 'MA', 'MAR', 'NULL', 'Códigos obtenidos del nombre enfrancés:Maroc', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('474', 'Martinica', 'Martinique', 'MQ', 'MTQ', 'NULL', 'Departamento de ultramarfrancés. Nombre oficial en la ISO enfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('480', 'Mauricio', 'Mauricio', 'MU', 'MUS', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('478', 'Mauritania', 'Mauritania', 'MR', 'MRT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('175', 'Mayotte', 'Mayotte', 'YT', 'MYT', 'NULL', 'Departamento de ultramarfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('484', 'México', 'México', 'MX', 'MEX', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('583', 'Micronesia', 'Micronesia (Estados Federados de)', 'FM', 'FSM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('498', 'Moldavia', 'Moldova (la República de)', 'MD', 'MDA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('492', 'Mónaco', 'Mónaco', 'MC', 'MCO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('496', 'Mongolia', 'Mongolia', 'MN', 'MNG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('499', 'Montenegro', 'Montenegro', 'ME', 'MNE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('500', 'Montserrat', 'Montserrat', 'MS', 'MSR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('508', 'Mozambique', 'Mozambique', 'MZ', 'MOZ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('104', 'Birmania', 'Myanmar', 'MM', 'MMR', 'NULL', 'Anteriormente conocida como Birmania.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('516', 'Namibia', 'Namibia', 'NA', 'NAM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('520', 'Nauru', 'Nauru', 'NR', 'NRU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('524', 'Nepal', 'Nepal', 'NP', 'NPL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('558', 'Nicaragua', 'Nicaragua', 'NI', 'NIC', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('562', 'Níger', 'Níger (el)', 'NE', 'NER', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('566', 'Nigeria', 'Nigeria', 'NG', 'NGA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('570', 'Niue', 'Niue', 'NU', 'NIU', 'NULL', 'Asociado aNueva Zelanda.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('574', 'Isla Norfolk', 'Norfolk Isla', 'NF', 'NFK', 'NULL', 'Pertenece aAustralia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('578', 'Noruega', 'Noruega', 'NO', 'NOR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('540', 'Nueva Caledonia', 'Nueva Caledonia', 'NC', 'NCL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('554', 'Nueva Zelanda', 'Nueva Zelandia', 'NZ', 'NZL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('512', 'Omán', 'Omán', 'OM', 'OMN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('528', 'Países Bajos', 'Países Bajos (los)', 'NL', 'NLD', 'NULL', 'Forma parte delReino de los Países Bajos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('586', 'Pakistán', 'Pakistán', 'PK', 'PAK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('585', 'Palaos', 'Palau', 'PW', 'PLW', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('275', 'Palestina', 'Palestina Estado de', 'PS', 'PSE', 'NULL', 'Comprende los territorios deCisjordaniayFranja de Gaza.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('591', 'Panamá', 'Panamá', 'PA', 'PAN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('598', 'Papúa Nueva Guinea', 'Papua Nueva Guinea', 'PG', 'PNG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('600', 'Paraguay', 'Paraguay', 'PY', 'PRY', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('604', 'Perú', 'Perú', 'PE', 'PER', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('258', 'Polinesia Francesa', 'Polinesia Francesa', 'PF', 'PYF', 'NULL', 'Códigos obtenidos del nombre enfrancés:Polynésie française', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('616', 'Polonia', 'Polonia', 'PL', 'POL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('620', 'Portugal', 'Portugal', 'PT', 'PRT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('630', 'Puerto Rico', 'Puerto Rico', 'PR', 'PRI', 'NULL', 'Territorio no incorporado de los Estados Unidos. Nombre oficial en la ISO enespañol.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('826', 'Reino Unido', 'Reino Unido de Gran Bretaña e Irlanda del Norte (el)', 'GB', 'GBR', 'NULL', 'Debido a que para obtener los códigos ISO no se utilizan las palabras comunes deReinoyUnido los códigos se han obtenido a partir del resto del nombre oficial.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('732', 'República Árabe Saharaui Democrática', 'Sahara Occidental', 'EH', 'ESH', 'NULL', 'Nombre provisional. Anterior nombre en la ISO:Sahara español', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('140', 'República Centroafricana', 'República Centroafricana (la)', 'CF', 'CAF', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('203', 'República Checa', 'Chequia', 'CZ', 'CZE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('178', 'República del Congo', 'Congo (el)', 'CG', 'COG', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('180', 'República Democrática del Congo', 'Congo (la República Democrática del)', 'CD', 'COD', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('214', 'República Dominicana', 'Dominicana (la) República', 'DO', 'DOM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('638', 'Reunión', 'Reunión', 'RE', 'REU', 'NULL', 'Departamento de ultramarfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('646', 'Ruanda', 'Ruanda', 'RW', 'RWA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('642', 'Rumania', 'Rumania', 'RO', 'ROU', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('643', 'Rusia', 'Rusia (la) Federación de', 'RU', 'RUS', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('882', 'Samoa', 'Samoa', 'WS', 'WSM', 'NULL', 'Códigos obtenidos del anterior nombre:Western Samoa (Samoa Occidental)', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('16', 'Samoa Americana', 'Samoa Americana', 'AS', 'ASM', 'NULL', 'Territorio no incorporado de los Estados Unidos.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('652', 'San Bartolomé', 'Saint Barthélemy', 'BL', 'BLM', 'NULL', 'Colectividad de ultramarfrancesa. Nombre oficial en la ISO enfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('659', 'San Cristóbal y Nieves', 'San Cristóbal y Nieves', 'KN', 'KNA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('674', 'San Marino', 'San Marino', 'SM', 'SMR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('663', 'San Martín', 'Saint Martin (parte francesa)', 'MF', 'MAF', 'NULL', 'Colectividad de ultramarfrancesa. Nombre oficial en la ISO enfrancés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('666', 'San Pedro y Miquelón', 'San Pedro y Miquelón', 'PM', 'SPM', 'NULL', 'Colectividad de ultramarfrancesa.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('670', 'San Vicente y las Granadinas', 'San Vicente y las Granadinas', 'VC', 'VCT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('654', 'Santa Elena Ascensión y Tristán de Acuña', 'Santa Helena Ascensión y Tristán de Acuña', 'SH', 'SHN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('662', 'Santa Lucía', 'Santa Lucía', 'LC', 'LCA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('678', 'Santo Tomé y Príncipe', 'Santo Tomé y Príncipe', 'ST', 'STP', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('686', 'Senegal', 'Senegal', 'SN', 'SEN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('688', 'Serbia', 'Serbia', 'RS', 'SRB', 'NULL', 'Códigos obtenidos de su nombre oficial:República de Serbia eninglés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('690', 'Seychelles', 'Seychelles', 'SC', 'SYC', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('694', 'Sierra Leona', 'Sierra leona', 'SL', 'SLE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('702', 'Singapur', 'Singapur', 'SG', 'SGP', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('534', 'San Martín', 'Sint Maarten (parte neerlandesa)', 'SX', 'SXM', 'NULL', 'Forma parte delReino de los Países Bajos. Nombre oficial enneerlandés.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('760', 'Siria', 'República Árabe Siria', 'SY', 'SYR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('706', 'Somalia', 'Somalia', 'SO', 'SOM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('144', 'Sri Lanka', 'Sri Lanka', 'LK', 'LKA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('748', 'Suazilandia', 'Suazilandia', 'SZ', 'SWZ', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('710', 'Sudáfrica', 'Sudáfrica', 'ZA', 'ZAF', 'NULL', 'Códigos obtenidos del nombre enneerlandés:Zuid-Afrika', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('729', 'Sudán', 'Sudán (el)', 'SD', 'SDN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('728', 'Sudán del Sur', 'Sudán del Sur', 'SS', 'SSD', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('752', 'Suecia', 'Suecia', 'SE', 'SWE', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('756', 'Suiza', 'Suiza', 'CH', 'CHE', 'NULL', 'Códigos obtenidos del nombre enlatín:Confoederatio Helvetica', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('740', 'Surinam', 'Suriname', 'SR', 'SUR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('744', 'Svalbard y Jan Mayen', 'Svalbard y Jan Mayen', 'SJ', 'SJM', 'NULL', 'Comprende dos territorios árticos deNoruega:SvalbardyJan Mayen.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('764', 'Tailandia', 'Tailandia', 'TH', 'THA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('158', 'Taiwán (República de China)', 'Taiwán (Provincia de China)', 'TW', 'TWN', 'NULL', 'Cubre la jurisdicción actual de laRepública de China (Taiwán) exceptoKinmeneIslas Matsu.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('834', 'Tanzania', 'Tanzania República Unida de', 'TZ', 'TZA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('762', 'Tayikistán', 'Tayikistán', 'TJ', 'TJK', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('86', 'Territorio Británico del Océano Índico', 'Territorio Británico del Océano Índico (el)', 'IO', 'IOT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('260', 'Tierras Australes y Antárticas Francesas', 'Tierras Australes Francesas (las)', 'TF', 'ATF', 'NULL', 'Comprende lastierras australes y antárticas francesasexcepto la parte incluida en laAntártidaconocida comoTierra Adelia.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('626', 'Timor Oriental', 'Timor-Leste', 'TL', 'TLS', 'NULL', 'Nombre oficial en la ISO enportugués.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('768', 'Togo', 'Togo', 'TG', 'TGO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('772', 'Tokelau', 'Tokelau', 'TK', 'TKL', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('776', 'Tonga', 'Tonga', 'TO', 'TON', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('780', 'Trinidad y Tobago', 'Trinidad y Tobago', 'TT', 'TTO', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('788', 'Túnez', 'Túnez', 'TN', 'TUN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('795', 'Turkmenistán', 'Turkmenistán', 'TM', 'TKM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('792', 'Turquía', 'Turquía', 'TR', 'TUR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('798', 'Tuvalu', 'Tuvalu', 'TV', 'TUV', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('804', 'Ucrania', 'Ucrania', 'UA', 'UKR', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('800', 'Uganda', 'Uganda', 'UG', 'UGA', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('858', 'Uruguay', 'Uruguay', 'UY', 'URY', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('860', 'Uzbekistán', 'Uzbekistán', 'UZ', 'UZB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('548', 'Vanuatu', 'Vanuatu', 'VU', 'VUT', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('336', 'Ciudad del Vaticano', 'Santa Sede(la)', 'VA', 'VAT', 'NULL', 'Los códigos ISO se asignan a la Santa Sede como representante de este Estado pero se refieren al territorio del Estado de la Ciudad', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('862', 'Venezuela', 'Venezuela (República Bolivariana de)', 'VE', 'VEN', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('704', 'Vietnam', 'Viet Nam', 'VN', 'VNM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('876', 'Wallis y Futuna', 'Wallis y Futuna', 'WF', 'WLF', 'NULL', 'Colectividad de ultramarfrancesa.', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('887', 'Yemen', 'Yemen', 'YE', 'YEM', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('262', 'Yibuti', 'Yibuti', 'DJ', 'DJI', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('894', 'Zambia', 'Zambia', 'ZM', 'ZMB', 'NULL', '', '', '');
INSERT INTO `cur_pais` (`cod_pais`, `nombre_pais`, `nombre_iso`, `iso3166a2`, `iso3166a3`, `estado`, `notas_pais`, `sessionflag`, `sessionficha`) VALUES ('716', 'Zimbabue', 'Zimbabue', 'ZW', 'ZWE', 'NULL', '', '', '');

