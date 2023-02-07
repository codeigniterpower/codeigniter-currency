
Inituial minimal documentation to use and work with currencylib project

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
