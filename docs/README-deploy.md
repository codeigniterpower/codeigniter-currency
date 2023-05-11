# INSTALLATION

This project provides two things: a **library that integrates 
the exchangerate.io api for codeigniter** and **a currency conversion rate manager** 
in two flavours: for pc (Web interface) and for devices (androit phones or tables).

It is a client-service philosophy, the server side customer side is 
consumed by the device (phones, tablets) or by the interface (web on pc) as client side.

## Requirements

Note you can just install in same machine both sides of the sistem.

### Hardware requirements

* Server computer:
    * Any computer device capable of any Unix based OS no matter if 32 or 64 bit
    * Internet connection
    * RAM: depends of load, 1G for mostly local intranet with 500 users
* Client device
    * PC (any that supports browsing) or Phone (androit for apk app, Iphone must use browser)
    * Internet connection

### Software requirements

* Server computer:
    * OS: 
        * Debian: 6.0+ with venenux repos enabled
        * Alpine: 3.10+
        * VenenuX: 0.9 or 9.0+ (Debian based)
        * Devuan: 1.0+
    * DBMS:
        * Sqlite 3.0+
        * PercodaDB (mariadb or mysql should work but yo will be by your own)
        * PostsgreSQL 8.0+
        * ODBC (any odbc valid that supports aliasing in queries and transactions)
    * PHP: 5.6+
        * cURL
        * JSON
        * sqlite/mysql/odbc/psql (based on the selected DBMS)
    * WEBSERVER
        * lighttpd 1.4.32+
        * for any other you are on your own but will just work
    * wget
    * gzip
    * coreutils or busybox

## Instalacion deploy

**We will use Debian 9 as example, but will just work for older or newer** if 
you added VenenuX repositories

First of all you need a valid OS as described before, later must setup common 
programs, later setup the database and finally tune up the webserver for instance.

#### Use case install with debian 9 and mysql

**1 - Instalation of software**

```
apt-get install git lighttpd mysql-server php7.3-cgi php7.3-gd php7.3-mysql php7.3-mcryp php7.3-curl php7.3-odbc lighttpd lighttpd-mod-openssl
```

**2 - preparation of the place**

```
mkdir -p /home/intranet/apps/elcurrency

wget -t0 -O elcurrency.tar.gz https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/archive/main/codeigniter-currencylib-main.tar.gz

mysql -u root -p -e "CREATE USER 'sysdbuser'@'localhost' IDENTIFIED BY  'sysdbuser.1';"

nano  /home/intranet/apps/elcurrency/elcurrencyweb/config/database.php

mysql -u root -p -D elcurrencydb -e "CREATE DATABASE elcurrencydb;"

mysql -u root -p -D elcurrencydb -e "GRANT ALL PRIVILEGES ON elcurrency% . * TO 'sysdbuser'@'localhost';"

mysql -u sysdbuser -p -D elcurrencydb < /home/intranet/apps/elcurrency/elcurrencydb/elcurrencydb.sql

ln -s  /home/intranet/apps/elcurrency/elcurrencyfiles/99-elcurrency.conf /etc/lighttpd/conf-available/99-elcurrency.conf

lighty-enable-mod alias elcurrency;/etc/init.d/lighttpd restart
```

Next use http://localhost/elcurrency  to check

## Develoment deploy

We only used Debian as main OS for development and Geany as oficial editor.

### 1 requirements

For hardware we recommended as minimal:

* CPU: any x86 based no matter if 32bit or 64bit
* RAM: 4G+

For software we need apart of Debian based system:

* Debian (minimal as Debian 7 based but not Debian 10 or testing)
* git (manejador de repositorio y proyecto) `apt-get install git git-core giggle`
* mysql (manejador y servidor DB que hara de pivote) `apt-get install mysql-client mysql-server`
* odbc, myodbc, freetds (coneccion DB mysql, ODBC para sybase y mssql) `apt-get install libmyodbc tdsodbc`
* geany (editor para manejo php asi como ver el preview) `apt-get install geany geany-plugin-webhelper`
* lighttpd/apache2 (webserver localmente para trabajar el webview) `apt-get install lighttpd`
* php (interprete) en debians o devuans `apt-get install php-cgi php-mysql php-odbc php-sqlite php-gd php-mcrypt php-curl`
* curl (invocar urls) `apt-get install curl`

Database management are made by usage or MysqlWorkbench, so you must use `apt-get install mysql-workbench` 
that will be only valid for Debian 6, Debian 7, Debian 8, Debian 9 and Debian 12, or any Debian based on those.

### 2 Configure environment


``` bash
git config --global status.submoduleSummary true
git config --global diff.submodule log
git config --global fetch.recurseSubmodules on-demand
git config --global user.email apellido_nombre@intranet1.net.ve
git config --global http.postBuffer 524288000

ln -s  ~/Devel ~/public_html

chown -R general:www-data /home/general/Devel
find /home/general/Devel/ -type f -exec chmod 664 {} ";"
find /home/general/Devel/ -type d -exec chmod 775 {} ";"

apt-get install mariadb-server mariadb-client mysqlworkbench lighttpd \
 php-fpm php-cgi php-gd php-mysql apt-get install geany geany-addons

lighty-enable-mod accesslog cgi dir-listing fastcgi proxy status userdir usertrack php-fastcgi

/usr/sbin/service lighttpd restart

ln -s /home/general/Devel /var/www/Devel
ln -s /home/general/Devel /var/www/html/Devel

exit
```

### 3 clone the sources


``` bash
mkdir -p ~/Devel
cd Devel
git clone --recursive http://tijerazo.net/elgit/tijerazo/elcurrency.git
cd elcurrency
git pull
git submodule init
git submodule update --rebase
git submodule foreach git checkout master
git submodule foreach git pull
```

### 5 Inicialize DBMS


``` bash
mysql -u root -p -e 'CREATE SCHEMA elcurrencydb'`
mysql -u root -p elcurrencydb < elcurrencydb/elcurrencydb.sql
```

Example usage


``` php
	$dbmy = $this->load->database('elcurrencydb', TRUE);
	$driverconected = $dbmy->initialize();
	if($driverconected != TRUE)
		return FALSE;
	$queryprovprod = $dbmy->query("SELECT * FROM tabla");
	$arreglo_reporte = $queryprovprod->result_array();
```

