# Development notes

For general info check [README.md](README.md)

## Development Environment

TODO

## Development framework notes

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

### views notes

#### those view have a relationship

* Header
* Footer 
* Menu 


The header opens a general div container:

```
 <div class="container-fluid">
        <div class="row flex-nowrap">
```

Those will and must be closed at the footer or/and menu:

```
    </div>
</div>
```

#### If you uses menu view, dont use footer one

In such cases you must close as:

```
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
```

## Database compatibility

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


## Deploy

TODO

