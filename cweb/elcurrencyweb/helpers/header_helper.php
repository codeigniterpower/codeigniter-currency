<?php
/**
 * CodeIgniterpower header
 *
 * @package	CodeIgniterpower
 * @author	PICCORO Lenz McKAY
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniterpower
 * @link	https://gitlab.com/codeigniterpower
 * @since	Version 0.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniterpowered HTML Helpers
 *
 * @package		CodeIgniterpower
 * @subpackage	Helpers
 * @category	html helper
 * @author	PICCORO Lenz McKAY
 */
 
// ------------------------------------------------------------------------


if (! function_exists('header_meta')) {
	/**
	 * Script
	 *
	 * Generates the header meta tag for our project with all the necesary headers tags of meta
	 *
	 */
	function header_meta($link = '')
	{
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

		$metaline1 = array('name' => 'description', 'content' => 'codeigniter-currency powered with steroids series');
		$metaline2 = array('name' => 'keywords', 'content' => 'system, admin, catalogo, sistemas, currency, rates, monedas');
		$metaline3 = array('name' => 'Content-type', 'content' => 'text/html; charset='.config_item('charset'), 'type' => 'equiv');
		$metaline7 = array('name' => 'Content-Security-Policy', 'content' => '');
		$metaline8 = array('name' => "viewport", "content" => "width=device-width, initial-scale=1.0" );
	// set the meta header tags in an usable array and configure the header metadata
		$meta = array( $metaline1, $metaline2, $metaline3, $metaline4, $metaline5, $metaline6, $metaline7, $metaline8 );
		$headermetatag = meta($meta);

		return $headermetatag;
	}
}

// ------------------------------------------------------------------------


if (! function_exists('link_css')) {
	/**
	 * Script
	 *
	 * Generates link header tags of stylesheet sources
	 *
	 * @param array|string $link       Script source or an array of scrits sources
	 */
	function link_css($link = '', $params = '')
	{
		$linkssrc = array();
		//<link href="main.css" rel="stylesheet" />
		if ( ! is_array($link)) {
			if ( strripos($link, 'http') !== FALSE)
				$linkssrc['src'] = $link;
			else
				$linkssrc['src'] = base_url().'elcurrencyfiles/css/'.$link;
		}

		$script = '';
		$openscrjs = '<script type="text/css" rel="stylesheet" ';
		foreach ($linkssrc as $k => $v) {
			$script .= $openscrjs . ' src="'.$v.'" media="all" '.$params.' ></script>';
		}

		return $script;
	}
}

// ------------------------------------------------------------------------


if (! function_exists('link_js')) {
	/**
	 * Script
	 *
	 * Generates link header tags of javascript sources
	 *
	 * @param array|string $link       Script source or an array of scrits sources
	 */
	function link_js($link = '')
	{
		$linkssrc = array();
		//<script src="/assets/webpack/runtime.a33f0906.bundle.js" defer="defer" nonce=""></script>
		if ( ! is_array($link)) {
			if ( strripos($link, 'http') !== FALSE)
				$linkssrc['src'] = $link;
			else
				$linkssrc['src'] = base_url().'elcurrencyfiles/js/'.$link;
		}

		$script = '';
		$openscrjs = '<script type="text/javascript" ';
		foreach ($linkssrc as $k => $v) {
			$script .= $openscrjs . ' src="'.$v.'" defer="defer" nonce=""></script>';
		}

		return $script;
	}
}

// ------------------------------------------------------------------------


if (! function_exists('script_js')) {
	/**
	 * Script
	 *
	 * Generates tags of javascript embebed codes
	 *
	 * @param array|string $src       Script source or an array of scrits sources
	 * @param array|string $attributes    Sabtibutes or array of atributes taht will be put in all the tags
	 * @param bool $xhtml  will be XHTML or just simple HTML one to put CDATA inside
	 */
	function script_js($src = '', $attributes = '', $xhtml = FALSE)
	{
		$script   = '';
		$satribs  = '';
		$isjs = FALSE;
		$open_only = FALSE;

		if ( ! is_array($src)) {
			if ( trim($src) == '' OR $src == NULL ) {
				$open_only = TRUE;
			}
			$attributes['src'] = $src;
		}

		if ( ! is_array($src) AND ! is_array($attributes)) {
			$isjs = strripos($attributes,'type');
			$attributes['attributes'] = $attributes;
		}
		else {
			if ( is_array($src) AND ! is_array($attributes)) {
				foreach ($src as $k => $v) {
					if ( strripos($k,'type') === TRUE AND strripos($v,'javascript') === TRUE ) {
						$isjs = TRUE;
					}
					$satribs .= $k . (null === $v ? ' ' : '="' . $v . '" ');
				}
			}
			else {
				foreach ($attributes as $k => $v) {
					if ( strripos($k,'type') === TRUE AND strripos($v,'javascript') === TRUE ) {
						$isjs = TRUE;
					}
					$satribs .= $k . (null === $v ? ' ' : '="' . $v . '" ');
				}
			}
		}

		if ( $isjs === FALSE ) {
			$satribs .= ' type="text/javascript"';
		}

		foreach ($src as $k => $v) {
			$script .= '<script ' . $satribs . '>' . PHP_EOL;
			if ( $xhtml ) $script .= '//<![CDATA[' . PHP_EOL;
			$script .= $v . PHP_EOL;
			if ( $xhtml ) $script .= '//]]>' . PHP_EOL;
			if ( $open_only ) $script .= '</script>' . PHP_EOL;
		}

		return $script;
	}
}

// ------------------------------------------------------------------------

if (! function_exists('script_tag')) {
	/**
	 * Script
	 *
	 * Generates link to a JS file
	 *
	 * @param array|string $src       Script source or an array of attributes
	 * @param bool         $indexPage Should indexPage be added to the JS path
	 */
	function script_tag($src = NULL, $indexPage = false)
	{
		if( $src === NULL ) $src = '';
		
		$open_only = FALSE;
		$contenido = '';

		$script   = '<script ';
		if (! is_array($src)) {
			if ($indexPage == TRUE AND trim($src) != '') {
				$src = site_url();
			}
			if ( trim($src) == '' OR $content == NULL) {
				$open_only = TRUE;
			}
			if ( strpos($src, 'src') !== FALSE ) {
				$src = array('src' => $src);
			}
		}
		foreach ($src as $k => $v) {
			if ($k === 'src' AND $indexPage === true) {
				$src[$k] = site_url($v);
			}
			if ( ! array_key_exists('type', $src) ) {
				$src['type'] = 'text/javascript';
			}
			if ( $k === 'content' ) {
				$contenido = $v;
				continue;
			}
			$script .= $k . (null === $v ? ' ' : '="' . $v . '" ');
		}

		$script .= '>';

 		if ( $open_only !== TRUE ) {
			$script .= $contenido;
			$script .= '</script>';
		}
		
		return $script;
   }
}

// ---------------------------------------------------------------------

if ( ! function_exists('script_close'))
{
	/*
	 * script tag helper for close tag
	 * @name: script_close
	 * @return String
	 */
	function script_close()
	{
		return '</script>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('link_tag'))
{
	/**
	 * Link
	 *
	 * Generates link to a CSS file
	 *
	 * @param	mixed	stylesheet hrefs or an array
	 * @param	string	rel
	 * @param	string	type
	 * @param	string	title
	 * @param	string	media
	 * @param	bool	should index_page be added to the css path
	 * @return	string
	 */
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();
		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k => $v)
			{
				if ($k === 'href' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->base_url($v).'" ';
					}
				}
				else
				{
					$link .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $href))
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->base_url($href).'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media !== '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title !== '')
			{
				$link .= 'title="'.$title.'" ';
			}
		}

		return $link."/>\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('div_tag'))
{
	/*
	 * div tag helper
	 * @name: div
	 * @param: String $content
	 * @param: String $attributes like class
	 * @return String
	 */
	function div_tag($content = '', $attributes = '')
	{
		$srcs = array();
		$script = '';
		$open_only = FALSE;

		if ( ! is_array($content) ) {
			if ( trim($content) == '' OR $content == NULL) {
				$open_only = TRUE;
			}
			$srcs['content'] = $content;
		}

		if ( trim($srcs['content']) == '') {
			$open_only = TRUE;
		}

		if ( ! is_array($attributes)) {
			$srcs['attributes'] = $attributes;
		}
		else {
			foreach ($atributes as $k => $v) {
			// for attributes without values, like async or defer, use NULL.
				$satribs .= $k . (null === $v ? ' ' : '="' . $v . '" ');
			}
			$srcs['attributes'] = $satribs;
		}

		$script .= '<div '.$srcs['attributes'].'>';
		if ( $open_only !== TRUE ) {
			$script .= $srcs['content'];
			$script .= '</div>';
		}

		return $script;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('div_close'))
{
	/*
	 * div tag helper for close tag
	 * @name: div_close
	 * @return String
	 */
	function div_close()
	{
		return '</div>';
	}
}

if ( ! function_exists('div_open'))
{
	/*
	 * div tag helper for close tag
	 * @name: div_open
	 * @param: String $attributes like class
	 * @return String
	 */
	function div_open($attributes = '')
	{
		return div_tag('', $attributes);
	}

}
