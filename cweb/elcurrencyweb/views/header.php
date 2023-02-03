<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	// initialization of default meta tags
	echo doctype('xhtml1-trans'), PHP_EOL,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL;
	echo '<head>'. PHP_EOL;
	$this->load->helper('header');
	echo header_meta();
	echo link_js("https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js");
		echo link_js('polyfill.js').PHP_EOL;
		echo link_js('currencyweb.js').PHP_EOL;
		echo link_css('alerts.css').PHP_EOL;
		echo link_css('currencyweb.css').PHP_EOL;
		echo link_css('login.css').PHP_EOL;
		echo link_css('table.css').PHP_EOL;
		echo link_css('usersList.css').PHP_EOL;
		echo link_css('home.css').PHP_EOL;// ::TODO USAR COMPILADOR SCSS 



		echo link_css("https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css");

		echo link_css("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");
		echo link_css("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css", 'integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"');
	
		// TODO : here the CSS and JS links use HTTP urls or just the name of the file
	echo '</head>'. PHP_EOL;
	echo '<body>'.PHP_EOL;
