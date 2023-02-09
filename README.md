# codeigniter-currencylib

Currency converter library and also a manager interface for/using codeigniter and exchangerate.io

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

#### APY LAYER

This project retrieve the currencies from https://apilayer.com/marketplace/exchangerates_data-api 
using ApiLayer service, that provides a free play with 256 request per month that is enought for 
any little service, for that the project also provide a web management inerface with option 
to store into database. You must to have a free of charge api key and configure it.

#### INSTALLATION

TODO

#### DEVELOPMENT

Check [docs/README-developers.md](docs/README-developers.md)

## Authors and acknowledgment

(c) angel gonzalez @radioactive99
(c) PICCORO Lenz McKAY @mckaygerhard
(c) Angel Gonzalez @Angel.Gonzalez.dev.front

## License

For open source projects, say how it is licensed.

Check [LICENSE](LICENSE)

## Project status

Currently just show the rates of all the supported currency.
