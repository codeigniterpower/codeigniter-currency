# codeigniter-currencylib

Currency converter library and also a manager interface for/using codeigniter and exchangerate.io

> Warning: currently the auth is disabled and you can just put any password

## Description

This project provides two things: a **library that integrates 
the YADIO exchange api for codeigniter** and **a currency conversion rate manager**, 
currencies, its big difference is that you can change the base currency at any time 
regardless of whether it was already deployed.

The system is free view, authentication is only to get write permissions 
and/or overwrited rate currencies. User management initially only indicates 
whether or not you can alter the coin rates. In the future, access permissions 
will be implemented.

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
and manage your own databases of currencies. This project provides an api layer 
with enry points as `callRatesFromDB` and `convertCurrency`. Usefully if you 
dont want to pay the apilayer and wants an internal intranet currency manager.

* **The androitAP** as in [capk](capk) its just a phone minimal inteface to the 
already provided currency web interface, you must provide the url ot the manager, 
of who usefully can be an web interface and also will provide your own apy 
to gest history currency set by you. Usefully if you dont want to pay the 
apilayer and wants an internal intranet currency manager. It acts also 
as frontend to the api.

#### API LAYER

This project retrieve the currencies from https://api.yadio.io/exrates 
using ApiLayer service, that the project also provide a web management interface with option 
to store into database. You must to have a free of charge api key and configure it.

The idea and objective is to provide a multi API layer in a way that acts as a 
man in the middle in the purest proxy style, but keeping it simple. So means that 
more that one API provider will be configured possible in the near future.

#### INSTALLATION

Please check [docs/README-deploy.md#installation-production](docs/README-deploy.md#installation-production) 
for production deploy. For local deploy just read the hole file.

#### DEVELOPMENT

Check [docs/README-developers.md](docs/README-developers.md)

## Authors and acknowledgment

* (c) angel gonzalez @radioactive99
* (c) PICCORO Lenz McKAY @mckaygerhard
* (c) Angel Gonzalez @Angel.Gonzalez.dev.front

## License

For open source projects, say how it is licensed.

Check [LICENSE](LICENSE)

## Project status

Currently just show the rates of all the supported currency.
