<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	// initialization of default meta tags
	echo doctype('xhtml1-trans'), PHP_EOL,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL;
	echo '<head>'. PHP_EOL;
	// the header helper is a custom own project helper that already loads all the necesary headers meta tags
		$this->load->helper('header');
		// setup of our meta tags for currency project
		echo header_meta();
		// loading of own styling and script of project
		echo link_css('alerts.css').PHP_EOL;
		echo link_css('currencyweb.css').PHP_EOL;
		echo link_css('login.css').PHP_EOL;
		echo link_css('table.css').PHP_EOL;
		echo link_css('usersList.css').PHP_EOL;
		echo link_css('converter.css').PHP_EOL;
		echo link_css('home.css').PHP_EOL;// ::TODO USAR COMPILADOR SCSS 
		echo link_js('currencyweb.js').PHP_EOL;
		// compatibility of older browsers TODO: implement of the 
		echo link_js('polyfill.js').PHP_EOL;
		// loading of datatables for table presentation
		echo link_js("https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js");
		echo link_css("https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css");
		// loading of jquery need
		echo link_scrip('https://code.jquery.com/jquery-3.6.3.js','crossorigin="anonymous"');
		// loadinig of bootstratps style and icons
		echo link_css("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css", 'integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"');
		echo link_css("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css");
	echo '</head>'. PHP_EOL;
	echo '<body>'.PHP_EOL;
echo '<!-- START MAIN CONTAINER AND MENU TAG CNTAINER , it ends in the footer view -->';
echo '<div class="container-fluid">'.PHP_EOL;
echo '<div class="row flex-nowrap">'.PHP_EOL;
