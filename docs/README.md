
Inituial minimal documentation to use and work with currencylib project

## Description

This project provides two things: a **library that integrates 
the exchangerate.io api for codeigniter** and **a currency conversion rate manager**, 
its big difference is that you can change the base currency at any time 
regardless of whether it was already deployed.

#### Artifacs

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
apilayer and wants an internal intranet currency manager. This is also an api itselft.

## Deploy

TODO

## DB

Currency manager is compatible with any database engine, we use workbench 
to produce and desing the schema but the schema is just full compatible 
with any other DB, just remove the `ENGINE` lines and only in sqlite cases 
removes the `COMMENT` part and you will get it.

* `elcurrencydb.png` [elcurrencydb.png](elcurrencydb.png)
* `elcurrencydb.mwb` [elcurrencydb.mwb](elcurrencydb.mwb)
* `elcurrencydb.sql` [elcurrencydb.sql](elcurrencydb.sql)


The SQL script only creates the tables, so means you should create and 
setup the DB schema, by example if yu will use MySQL/Percona/MariaDB you 
sould previoously do `CREATE SCHEMA elcurrencydb DEFAULT CHARACTER SET utf8mb4 ;` 
and mb4 in the MySQL case, cos PostgreSQL already supports multilang charset.
