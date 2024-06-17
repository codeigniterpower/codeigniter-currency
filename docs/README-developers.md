# Development notes

For general info check [README.md](README.md), 
remembered our [../CONTRIBUTING.md](../CONTRIBUTING.md) rules.

## Development Environment

* **The library** as in [clib](clib) its just two files, the config 
file `config/currencylib.php` and the class lib `library/Currencylib.php`, 
put those in respective places in your codeigniter project and just start 
to use, it has two methos, `getOneCurrencyByApi(<from>, <to>, <amount>)` and 
the `getAllCurrencyByApi(<from>, <to>, <date>)` the first one just retreive all the 
converted currency froma  base ne, the second just convert from the base to 
the listed comma separated ones but using unit currency at current date.

* **The manager** as in [cweb](cweb) its just a CI manager, just integrate 
the codeigniter framework and configure the database.to start to use the api 
and manage your own databases of currencies. This project also is a example 
of who usefully can be an web interface and also will provide your own apy 
to gest history currency set by you. Usefully if you dont want to pay the 
apilayer and wants an internal intranet currency manager.

### Deploy in localhost

The application does not used rewrite of the URLs, this for better compatibility, 
also easy deploy, security its nto based in such stupid **index.php url hidding**, 
its based in better deploy of the web application, by example a good deploy of 
the api later.

To deploy in localhost you only need a running php environment and a directory 
were the files can be put to be interpreted with the web server.

For further information about how to deploy read [README.md#deploy](README.md#deploy)

### Development framework choice

We choose php and CI2/CI3 due several reasons but two are the most important:

* Understanding of CI2/CI3 does not need OOP knowledge, so many people 
just can read and understand the code more faster that using other frameworks.
* Others frameworks only provide open source DBMS connection and 
inclusively has limited support for PostgreSQL and SQlite, just the Mysql
* Check [Database compatibility](#database-compatibility) for DBMS related 
issues about such reasons

Lavarel is not difficult but it requires that the hired employee knows OOP, 
which translates into a very xpensives salary and money, while CI2/CI3 only 
requires that you know how to loop and minimal knowledge of conditionals, 
simple and easy to assimilate.. important key when we talk about money.

## Development notes

### DB models

**Usuario_m**

This model just retrieve the data of a user, the user credentials are not 
stored, login are managed agains IMAP or external source.. 

The table stored the session and will check if are still valid, when time out, 
will retry the login and refrsh the session into the table.

The permission are simple: if are enabled, can make modifications, either 
then just can read the currency rates.

**Currency_m**

The first used method is the `readCurrenciesTodayStored` that permits to get 
a list of current currencies with minimal filters, with support for server side:

```
 // get VES bolivares currencies on assumed date today but using base USD dollar
$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored('VES', NULL, 'USD');

 // get VES bolivares currencies from the given date string, YYYYMMDD[HH] you can get specific hour optional
$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored('VES','20230201');

 // get all the currencies from the given date string, YYYYMMDD[HH] you can get specific hour optional
$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored(NULL,'20230201');

 // send a filter directly over the currency table, filtering by the cod_tasa column value
$currency_list_dbarray = $this->dbcm->getTasas(array('cod_tasa'=>'2023020110'));
```

The second method is the `readCurrenciesHistStored`, with support for server side:


```
		$currency_list_dbarrayhis = array();
		$currency_list_dbarraycou = array();
		$this->load->model('Currency_m','dbcm');
		$parameters = array();
		// case 1 only count all the history for a specific date, first 100 rows, ordering by cod_tasa ascending
		$parameters['fecha'] = '20230207'
		$howmany = 100;
		$iniciar = 0;
		$ordercol = 'cod_tasa';
		$sorting = 'ASC';
		$countall = TRUE;
		$currency_list_dbarraycou = $this->dbcm->readCurrenciesHistStored($parameters,$howmany,$iniciar,$ordercol,$sorting,$countall);
		// case 2 get all the history for a specific date, first 100 rows, ordering by cod_tasa ascending
		$parameters['fecha'] = '20230207'
		$howmany = 100;
		$iniciar = 0;
		$ordercol = 'cod_tasa';
		$sorting = 'ASC';
		$countall = NULL;
		$currency_list_dbarrayhis = $this->dbcm->readCurrenciesHistStored($parameters,$howmany,$iniciar,$ordercol,$sorting,$countall);

		$totalcount = 0;
		if(is_array($currency_list_dbarrayhis))
		{
			$totalcount = count($currency_list_dbarrayhis);
		}
		if(is_array($currency_list_dbarraycou))
		{
			if(count($currency_list_dbarraycou))
				$totalcount = $currency_list_dbarraycou[]['cod_tasa'];
		}
```

### views notes

#### those view have a relationship

* Header
* Footer 
* Menu 

A mayor detail .. first releases will need that 
the header opens a general div container:

```
 <div class="container-fluid">
        <div class="row flex-nowrap">
```

Those will and must be closed at the footer or/and menu:

```
    </div>
</div>
```

This will be not necesary in future development of views.

#### If you uses menu view, dont use footer one

In such cases you must close as:

```
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
```

## Database dictionary

**Currency manager is compatible with any database engine**, that's 
another reason we choose Codeigniter 3 / Codeigniter 2 as framework 
for backend, those are the only framework that provides minimal ODBC 
compatibilty, and permits to customize manual SQL querys.

Others frameworks does not have any compatibilty with mayor 
database providers, neither have good ODBC compatibilty layer, by 
example broken aliasing for columns in Sybase ASE.

### SQL script DB

The SQL script only creates the tables, so means you should create and 
setup the DB schema, by example if you will use MySQL/Percona/MariaDB you 
sould previoously do `CREATE SCHEMA elcurrencydb DEFAULT CHARACTER SET utf8mb4 ;` 
in the MySQL case, cos PostgreSQL already supports multilang charset.

### Database schema desing

we use workbench to produce and desing the schema but the schema 
is just **full compatible with any other DB**, if error try to just 
remove the `ENGINE` lines (and only in sqlite cases removes 
the `COMMENT` part and you will get it).

* `elcurrencydb.png` [elcurrencydb.png](elcurrencydb.png)
* `elcurrencydb.mwb` [elcurrencydb.mwb](elcurrencydb.mwb)
* `elcurrencydb.sql` [elcurrencydb.sql](elcurrencydb.sql)

### Tables in general

#### cur_banco

Column name  | Type        | Comment                                                | Null | AI
-------------|-------------|--------------------------------------------------------|------|---
cod_banco    | varchar(40) | tres primeros numeros o identificador de sus cuentas   | No   | No
cod_pais     | varchar(40) | pais codigo iso 3166 numerico de donde reside el banco | Yes  | No
cod_swif     | varchar(40) | codigo SWIFT internacional                             | Yes  | No
cod_bic      | varchar(45) |                                                        | Yes  | No
nombre_banco | varchar(40) | nombre natural del banco por el que se le conoce       | Yes  | No
estado       | varchar(40) | ACTIVO|INACTIVO                                        | No   | No
sessionflag  | varchar(40) | quien modifico YYYYMMDDhhmmss + codger + . + ficha     | Yes  | No
sessionficha | varchar(40) | codigo BIC internacional                               | Yes  | No

#### cur_moneda

Column name     | Type          | Comment                                            | Null | AI
----------------|---------------|----------------------------------------------------|------|---
cod_moneda      | varchar(40)   | moneda codigo interno                              | No   | No
iso4217a3       | varchar(40)   | codigo iso 4217-1 de 3 letras                      | No   | No
simbolo_unicode | varchar(40)   | simbolo unicode de moneda                          | No   | No
nombre_moneda   | varchar(40)   | nombre moneda comun oficial                        | Yes  | No
estado          | varchar(40)   | ACTIVO|INACTIVO                                    | No   | No
notas_pais      | varchar(2000) | observaciones                                      | Yes  | No
sessionflag     | varchar(40)   | quien modifico YYYYMMDDhhmmss + codger + . + ficha | Yes  | No
sessionficha    | varchar(40)   | quien lo creo YYYYMMDDhhmmss + codger + . + ficha  | Yes  | No

cod_moneda | iso4217a3 | simbolo_unicode | nombre_moneda          | estado | notas_pais                                      | sessionflag | sessionficha
-----------|-----------|-----------------|------------------------|--------|-------------------------------------------------|-------------|-------------
008        | ALL       | L               | Lek                    | ACTIVO | Albania                                         |             |             
012        | DZD       | د.ج             | Algerian Dinar         | ACTIVO | Algeria                                         |             |             
032        | ARS       | $               | Argentine Peso         | ACTIVO | Argentina                                       |             |             
332        | HTG       | G               | Gourde                 | ACTIVO | Haiti                                           |             |             
886        | YER       | ﷼               | Yemeni Rial            | ACTIVO | Yemen                                           |             |             
928        | VES       | Bs              | Bolivar Soberano       | ACTIVO | Venezuela                                       | NULL        | NULL        
937        | VEF       | Bs F            | Bolivar Fuerte         | INACTI | Venezuela                                       |             |             
978        | EUR       | €               | Euro                   | ACTIVO | Akrotiri and Dhekelia  Andorra Austria Belgium  |             |             

#### cur_pais

Column name  | Type          | Comment                                            | Null | AI
-------------|---------------|----------------------------------------------------|------|---
cod_pais     | varchar(40)   | pais codigo iso 3166 numerico                      | No   | No
nombre_pais  | varchar(400)  | nombre comun conocido                              | No   | No
nombre_iso   | varchar(400)  | nombre iso 3166-1                                  | No   | No
iso3166a2    | varchar(40)   | codigo iso 3166 alfa 2 letras                      | No   | No
iso3166a3    | varchar(40)   | codigo iso 3166 alfa 3 letras                      | No   | No
estado       | varchar(40)   | ACTIVO|INACTIVO                                    | Yes  | No
notas_pais   | varchar(2000) | observaciones                                      | Yes  | No
sessionflag  | varchar(40)   | quien modifico YYYYMMDDhhmmss + codger + . + ficha | Yes  | No
sessionficha | varchar(40)   | quien lo creo YYYYMMDDhhmmss + codger + . + ficha  | Yes  | No


cod_pais | nombre_pais                               | nombre_iso                                        | iso3166a2 | iso3166a3 | estado | notas_pais                                                                                                                                 | sessionflag | sessionficha
---------|-------------------------------------------|---------------------------------------------------|-----------|-----------|--------|--------------------------------------------------------------------------------------------------------------------------------------------|-------------|-------------
10       | Antártida                                 | Antártida                                         | AQ        | ATA       | NULL   | Cubre el territorio al sur delparalelo 60º sur.                                                                                            |             |             
192      | Cuba                                      | Cuba                                              | CU        | CUB       | NULL   |                                                                                                                                            |             |             
8        | Albania                                   | Albania                                           | AL        | ALB       | NULL   |                                                                                                                                            |             |             
862      | Venezuela                                 | Venezuela (República Bolivariana de)              | VE        | VEN       | NULL   |                                                                                                                                            |             |             

#### cur_session

Column name | Type        | Comment                        | Null | AI
------------|-------------|--------------------------------|------|---
user_id     | varchar(40) | username or user mail          | No   | No
user_extra  | varchar(45) | reserved column for extra data | Yes  | No
sessionuser | varchar(40) | YYYYMMDDHHmmss.ip.XXXXXXXX     | No   | No

#### cur_tasas_moneda


Column name        | Type           | Comment                                                                                  | Null | AI
-------------------|----------------|------------------------------------------------------------------------------------------|------|---
cod_tasa           | varchar(40)    | YYYYMMDDhhmmss                                                                           | No   | No
cod_moneda_base    | varchar(40)    | cos_iso - moneda en el cual se basa la tasa, base                                        | No   | No
mon_tasa_moneda    | decimal(40,20) | monto: cuanto moneda -destino- vale moneda -base- cada una tiene una x/1 para la inversa | No   | No
cod_moneda_destino | varchar(40)    | cos_iso - moneda el cual esta elmonto equiparado                                         | No   | No
cod_tasa_tipo      | varchar(40)    | OFICIAL|INTERNA                                                                          | No   | No
sessionflag        | varchar(40)    | quien modifico YYYYMMDDhhmmss + codger + . + ficha                                       | Yes  | No
sessionficha       | varchar(40)    | quien lo creo YYYYMMDDhhmmss + codger + . + ficha                                        | Yes  | No

cod_tasa       | cod_moneda_base | mon_tasa_moneda              | cod_moneda_destino | cod_tasa_tipo | sessionflag | sessionficha
---------------|-----------------|------------------------------|--------------------|---------------|-------------|-------------
20201211080000 | 928             | 0.00000092576231029539       | 840                | INTERNA       | NULL        | NULL        
20201211080001 | 840             | 1080190.87500000000000000000 | 928                | INTERNA       | NULL        | NULL        

#### cur_usuarios

Column name      | Type        | Comment                                            | Null | AI
-----------------|-------------|----------------------------------------------------|------|---
user_id          | varchar(40) | intranet o correo del usuario                      | No   | No
user_status      | varchar(40) | PASIVO|ACTIVO                                      | Yes  | No
cur_monedas_base | varchar(40) | lista separada por comas de monedas preferida base | Yes  | No
cur_monedas_dest | varchar(40) | lista separada monedas get rates                   | Yes  | No
sessionflag      | varchar(40) | quien modifico YYYYMMDDhhmmss + codger + . + ficha | Yes  | No
sessionficha     | varchar(40) | quien lo creo YYYYMMDDhhmmss + codger + . + ficha  | Yes  | No

user_id          | user_status | cur_monedas_base | cur_monedas_dest | sessionflag | sessionficha
-----------------|-------------|------------------|------------------|-------------|-------------
user_new         | ACTIVO      | 840              | 928              |             |             


## Deploy

TODO

