<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		$menucss = '
<style type="text/css">
.topnav {
  font-family : font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;  font-weight: normal;  background-color:  #4CAF50;  padding: 0px 12px;  position: fixed;  top: 0;  left: 0;  right: 0;  z-index: 999;
}
.topnavsub {
  font-weight: normal;  background-color:  green;   margin: 1rem;  position: relative;  top: 5px;  z-index: 99;
}
.topnav a {
  font-weight: normal;  text-decoration: none;  float: center;  color: #f2f2f2;  padding: 2px 12px;
}
.topnav a:hover, .topnav a.active {
  font-weight: normal;  background-color: white;  color: #4CAF50;  border-bottom: 3px solid #222222;
}
</style>
';

		$metaline1 = array('name' => 'description', 'content' => 'Codeigniter powered with steroids series 3.X by Mckay Lenz');
		$metaline2 = array('name' => 'keywords', 'content' => 'system, admin, catalogo, sistemas, recibo, pago, saint');
		$metaline3 = array('name' => 'Content-type', 'content' => 'text/html; charset='.config_item('charset'), 'type' => 'equiv');
		if ( strcmp(ENVIRONMENT, 'development') == 0 )
		{
			$metaline4 = array('name' => 'Cache-Control', 'content' => 'no-cache, no-store, must-revalidate, max-age=0, post-check=0, pre-check=0', 'type' => 'equiv');
			$metaline5 = array('name' => 'Last-Modified', 'content' => gmdate("D, d M Y H:i:s") . ' GMT', 'type' => 'equiv');
			$metaline6 = array('name' => 'pragma', 'content' => 'no-cache', 'type' => 'equiv');
			$idcache = '?'.time();
		}
		else
		{
			$metaline6 = $metaline5 = $metaline4 = '';
			$idcache = '';
		}
		$metaline7 = array('name' => 'Content-Security-Policy', 'content' => '');
		$meta = array( $metaline1, $metaline2, $metaline3, $metaline4, $metaline5, $metaline6, $metaline7 );

		$pathcss = base_url() . '/assets/css/'; $typcs='text/css';
		$pathjsc = base_url() . '/assets/js/'; $typjs='text/javascript';

		$linkwebcss = array('type'=>$typcs,'rel'=>'stylesheet','href' => $pathcss.'bootstrap.css'.$idcache); // script de css sin tener que especificar clases en cada tag
		$linkwebcssd = array('type'=>$typcs,'rel'=>'stylesheet','href' => $pathcss.'flatpickr.min.css'.$idcache); // script de css sin tener que especificar clases en cada tag
		$linkwebcssjs = array('type'=>$typjs,'src' => $pathjsc.'bootstrap-native.js'.$idcache); // script de css sin tener que especificar clases en cada tag
		$linkwebcssjsd = array('type'=>$typjs,'src' => $pathjsc.'flatpickr.js'.$idcache); // script de css sin tener que especificar clases en cada tag
		$linkwebcssjsu = array('type'=>$typjs,'src' => $pathjsc.'polyfill.js'.$idcache); // script de css compatibilidad navegadores viejos

    echo doctype('xhtml1-trans'), PHP_EOL,'<html xmlns="http://www.w3.org/1999/xhtml">', PHP_EOL;
	echo '<head>'. PHP_EOL;
		echo meta($meta);
		echo link_tag($linkwebcss);
		echo link_tag($linkwebcssd);
		echo script_tag($linkwebcssjs);
		echo script_tag($linkwebcssjsu);
		echo script_tag($linkwebcssjsd);
		echo $menucss . PHP_EOL;
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
