<?php 
/**
 * currrency_m.php
 * 
 * abstraction to manage currency and rate convertion
 *
 * cur_moneda
 * * currency(cod iso 3166-1 numeric, cod iso 4217-a, cod iso 3166-1 3letters, name)
 * 
 * cur_tasas_moneda
 * * currency(cod rate, amount converted from 1 base unit, iso 3166-1 numeric base, cod iso 3166-1 converted)
 * 
 * @author  PICCORO Lenz McKAY <mckaygerhard@gmail.com>
 * @copyright Copyright 2017
 * @version ab - 1.0
 * 
 * This program is free software; BUT you can redistribute it and/or modify
 * it under the terms of the CC-BY-NC-SA License
 * 
 */
class curency_m extends CI_Model 
{

	protected $dbc;

	public function __construct() 
	{
		parent::__construct();
		$this->dbc = $this->load->database('elcurrencydb', TRUE);
	}

	/**
	 * verifica si el usuario es valido con la clave provista en md5
	 *
	 * @access	public
	 * @param	string  $curDest XXX[,YYY,ZZZ] optional and can be various
	 * @param	string  $fecha YYYYMMDD optional
	 * @param	string  $curBase XXX optional
	 * @return	boolean FALSE on errors
	 */
	public function getCurrencies($curDest = NULL, $fecha = NULL, $curBase = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received: cd ' . var_export($curDest, TRUE) . ' cb ' . var_export($curBase, TRUE) . ' date ' . var_export($curBase, TRUE));

		$curDestlen = strlen($curDest);
		$queryfiltro1 = '1=1';

		$querysql = "
		SELECT 
			t.cod_tasa,
			t.mon_tasa_moneda,
			(SELECT 
					CONCAT(m1.iso4217a3, ':', m1.nombre_moneda)
				FROM
					cur_moneda AS m1
				WHERE
					m1.cod_moneda = t.cod_moneda_base
				LIMIT 1 OFFSET 0) AS base,
			(SELECT 
					CONCAT(m1.iso4217a3, ':', m1.nombre_moneda)
				FROM
					cur_moneda AS m1
				WHERE
					m1.cod_moneda = t.cod_moneda_destino
				LIMIT 1 OFFSET 0) AS moneda
		FROM
			cur_tasas_moneda AS t
		";

		log_message('debug', __METHOD__ .' query db: ' . var_export($querysql, TRUE) );
		$querysqlrs = $this->dbc->query($querysql);
		$currency_result = $querysqlrs->result_array();

		log_message('info', __METHOD__ . ' error detection: '. $currency_result ); // mysql oly
		return $currency_result;

	}

}
