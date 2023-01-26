# codeigniter-currencylib

Currency converter library and also a manager interface for/using codeigniter and exchangerate.io

## Description

This project provides two things: a **library that integrates 
the exchangerate.io api for codeigniter** and **a currency conversion rate manager**, 
its big difference is that you can change the base currency at any time 
regardless of whether it was already deployed.


* **The library** its just two files, the config file `config/currencylib.php` and the class lib `library/Currencylib.php`
* **The manager** its the rest of the files, just add or integrate the codeigniter framework and configure the database.

#### APY LAYER

This project retrieve the currencies from https://apilayer.com/marketplace/exchangerates_data-api 
using ApiLayer service, that provides a free play with 256 request per month that is enought for 
any little service, for that the project also provide a web management inerface with option 
to store into database. You must to have a free of charge api key and configure it.

#### INSTALLATION

TODO

#### DEVELOPMENT

TODO

## Authors and acknowledgment

(c) angel gonzalez @radioactive99
(c) PICCORO Lenz McKAY @mckaygerhard
(c) Angel Gonzalez @Angel.Gonzalez.dev.front

## License

For open source projects, say how it is licensed.

Check [LICENSE](LICENSE)

## Project status

Currently just show the rates of all the supported currency.
