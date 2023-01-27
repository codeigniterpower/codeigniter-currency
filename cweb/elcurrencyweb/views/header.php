<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// initialization of default meta tags
	echo doctype('xhtml1-trans'), PHP_EOL,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL;
	echo '<head>'. PHP_EOL;
		$this->load->helper('header');
		echo header_meta();
		echo link_js('polyfill.js');
		echo link_js('currencyweb.js');
		echo link_css('currencyweb.css');
		// TODO : here the CSS and JS links use HTTP urls or just the name of the file
	echo '</head>'. PHP_EOL;
	echo '<body>'.PHP_EOL;
