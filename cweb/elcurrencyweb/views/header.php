<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// initialization of default meta tags
		if ( strcmp(ENVIRONMENT, 'development') == 0 )
		{
			$metaline4 = array('name' => 'Cache-Control', 'content' => 'no-cache, no-store, must-revalidate, max-age=0, post-check=0, pre-check=0', 'type' => 'equiv');
			$metaline5 = array('name' => 'Last-Modified', 'content' => gmdate("D, d M Y H:i:s") . ' GMT', 'type' => 'equiv');
			$metaline6 = array('name' => 'pragma', 'content' => 'no-cache', 'type' => 'equiv');
			$idcache = '?'.time();
		}
		else
		{
			$metaline4 = $metaline5 = $metaline6 = '';
			$idcache = '';
		}

		$metaline1 = array('name' => 'description', 'content' => 'Codeigniter powered with steroids series 3.X by Mckay Lenz');
		$metaline2 = array('name' => 'keywords', 'content' => 'system, admin, catalogo, sistemas, currency, rates, monedas');
		$metaline3 = array('name' => 'Content-type', 'content' => 'text/html; charset='.config_item('charset'), 'type' => 'equiv');
		$metaline7 = array('name' => 'Content-Security-Policy', 'content' => '');

	// set the meta header tags in an usable array and configure the header metadata
		$meta = array( $metaline1, $metaline2, $metaline3, $metaline4, $metaline5, $metaline6, $metaline7 );
		$headermetatag = meta($meta);

		// inicializacion de variables de rutas a los css
		$pathcss = base_url() . '/assets/css/'; $typcs='text/css';
		$pathjsc = base_url() . '/assets/js/'; $typjs='text/javascript';

		$linkwebcss = array('type'=>$typcs,'rel'=>'stylesheet','href' => $pathcss.'bootstrap.css'.$idcache); // script de css sin tener que especificar clases en cada tag
		$linkwebcssd = array('type'=>$typcs,'rel'=>'stylesheet','href' => $pathcss.'flatpickr.min.css'.$idcache); // script de css sin tener que especificar clases en cada tag

    echo doctype('xhtml1-trans'), PHP_EOL,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL;
	echo '<head>'. PHP_EOL;
		$this->load->helper('header');
		echo meta($meta);
		echo link_tag($linkwebcss);
		echo link_tag($linkwebcssd);
		echo link_js('polyfill.js');
	echo '</head>'. PHP_EOL;
	echo '<body>'.PHP_EOL;

		if( isset($menu))
		{
			div_open('id="menu"').PHP_EOL;
			echo $menu;
			div_close().PHP_EOL;
			echo '<center>'.PHP_EOL;
			if( isset($menusub))
			{
				div_open('id="menusub"').PHP_EOL;
				echo $menusub;
				div_close().PHP_EOL;
			}
			echo '</center>'.PHP_EOL;
		}
