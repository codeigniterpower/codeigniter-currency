<?php 
/**
 * currrency_m.php
 * 
 * abstraction DB to manage currency and rate convertion
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
class Currency_m extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->dbc = $this->load->database('elcurrencydb', TRUE);
	}

	/** auto close db on production */
	private function closedb()
	{
		if( stripos(ENVIRONMENT,'production') > 0 )
		{
			$this->dbc->close();
			$this->dbc = NULL;
		}
	}

	/**
	 * get all currencies and their conversion, stored in DB **at current time**
	 * based on a first one, by default USD currency
	 *
	 * @access	public
	 * @param	string  $curDest XXX[,YYY,ZZZ] optional and can be various
	 * @param	string  $fecha YYYYMMDD optional
	 * @param	string  $curBase XXX optional
	 * @param	array  $paramnames ('columname'=>'value'[,'columname'=>'value',..])
	 * @return	mixed FALSE on errors
	 */
	public function readCurrenciesTodayStored($curDest = NULL, $fecha = NULL, $curBase = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received: cd ' . var_export($curDest, TRUE) . ' cb ' . var_export($curBase, TRUE) . ' date ' . var_export($curBase, TRUE));
		$curDestlen = strlen($curDest);
		$curBaselen = strlen($curBase);
		$fechalen = strlen($fecha);
		$paramfilters = array();
		if( $curBaselen == 3 )
			$paramfilters['curBase'] = $curBase;
		if( $fechalen >= 8 )
			$paramfilters['fecha'] = $fecha;
		if( $fecha == NULL )
			$paramfilters['fecha'] = date('Ymd');
		if( $curDestlen >= 3 )
			$paramfilters['curDest'] = $curDest;
		$arraydata = $this->readTasas($paramfilters, TRUE);
		return $arraydata;
	}

	/**
	 * get all currencies and their conversion, stored in DB **at current time**
	 * based on a first one, by default USD currency
	 *
	 * @access	public
	 * @param	string  $curDest XXX[,YYY,ZZZ] optional and can be various
	 * @param	string  $fecha YYYYMMDD optional
	 * @param	string  $curBase XXX optional
	 * @param	array  $paramnames ('columname'=>'value'[,'columname'=>'value',..])
	 * @return	mixed FALSE on errors
	 */
	public function readCurrenciesHistStored()
	{
		$arraydata = $this->readTasas(NULL, TRUE);
		log_message('debug', __METHOD__ .' data from DB received for history');
		return $arraydata;
	}

	/**
	 * get all currencies and their conversion, based on a first one, by default USD currency
	 * this is a sepcial CURD read from table cur_tasas_moneda
	 * 
	 * @access	public
	 * @param	array  $paramnames ('columname'=>'value'[,'columname'=>'value',..])
	 * @return	mixed FALSE on errors
	 */
	public function readTasas($paramfilters = NULL, $limited = FALSE)
	{
		log_message('debug', __METHOD__ .' parametros received:  ' . var_export($paramfilters, TRUE) );

		
		$columnssql = 'cod_tasa,moneda_base,mon_tasa_moneda,moneda_destino,cod_tasa_tipo,cod_moneda_base,cod_moneda_destino,sessionflag,sessionficha';
		$paramnames =  explode(',',$columnssql);
		$queryfiltro = '  ';
		if( $limited !== FALSE )
		{
			$columnssql = 'cod_tasa,moneda_base,mon_tasa_moneda,moneda_destino';
			log_message('debug', __METHOD__ .' retrieve history from DB !' );
		}
		if(is_array($paramfilters) )
		{
			foreach($paramnames as $key=>$namecolumn )
			{
				if( array_key_exists($namecolumn, $paramfilters) )
				{
					$$namecolumn = $paramfilters[$namecolumn];
					$queryfiltro .= ' AND '.$namecolumn.'="'.$$namecolumn.'"';
				}
			}
			if( array_key_exists('fecha', $paramfilters) )
			{
				$fechalen = strlen($paramfilters['fecha']);
				$queryfiltro .= ' AND SUBSTRING(cod_tasa, 1, '.$fechalen.')="'.$paramfilters['fecha'].'"';
			}
			if( array_key_exists( 'curBase', $paramfilters) )
				$queryfiltro .= ' AND moneda_base="'.$paramfilters['curBase'].'"';
			if( array_key_exists('curDest', $paramfilters) )
			{
				$curDest = $paramfilters['curDest'];
				$curDestlen = strlen($curDest);
				if( $curDestlen = 3 )
					$queryfiltro .= ' AND moneda_destino LIKE "'.$curDest.'%"';
				if( $curDestlen > 3 )
				{
					$queryfiltro .= ' AND ( 1=1 ';
					$monedadestarray = explode(',',$curDest);
					foreach ($monedadestarray as $monedas => $curdesval)
					{
						$queryfiltro .= ' OR moneda_destino="'.$curdesval.'"';
					}
					$queryfiltro .= ' )';
				}
			}
		}

		$querysql = "
			SELECT 
				".$columnssql."
			FROM
				(SELECT 
					t.cod_tasa,
					t.mon_tasa_moneda,
						(SELECT 
								CONCAT(m1.iso4217a3, \":\", m1.nombre_moneda)
							FROM
								cur_moneda AS m1
							WHERE
								m1.cod_moneda = t.cod_moneda_base
							LIMIT 1 OFFSET 0) 
					AS moneda_base,
						(SELECT 
								CONCAT(m1.iso4217a3, \":\", m1.nombre_moneda)
							FROM
								cur_moneda AS m1
							WHERE
								m1.cod_moneda = t.cod_moneda_destino
							LIMIT 1 OFFSET 0) 
					AS moneda_destino,
					t.cod_tasa_tipo,
					t.cod_moneda_base,
					t.cod_moneda_destino,
					t.sessionflag,
					t.sessionficha
				FROM
					cur_tasas_moneda AS t)
				AS tablec
			WHERE
				1=1 
		".$queryfiltro;


		log_message('debug', __METHOD__ .' query db: ' . print_r($querysql, TRUE) );
		$querysqlrs = $this->dbc->query($querysql);
		$currency_result = $querysqlrs->result_array();

		log_message('info', __METHOD__ . ' error detection: '. print_r($currency_result,TRUE) ); // mysql oly
		$this->closedb();
		return $currency_result;
	}

	/**
	 * get the many names and their codes from cur_money, this data 
	 * means whic money is valid or not for system currency manager
	 *
	 * @access	public
	 * @param	array  $filters (0[col1, value], 1[col2, value]), valid cols: check table reference `cur_moneda`
	 * @return	boolean FALSE on errors
	 */
	public function readCurrencyNames($paramfilters = NULL)
	{
		$columns = 'cod_moneda,iso4217a3,iso3166a1,simbolo_unicode,nombre_moneda,estado,notas_pais,sessionflag,sessionficha';
		return $this->crudReadTable('cur_moneda', NULL, $columns);
	}

	/**
	 * get the many names and their codes from cur_banco, this data 
	 * means whic bank is valid or not for system currency manager
	 *
	 * @access	public
	 * @param	array  $paramfilters (0[col1, value], 1[col2, value]), valid cols: check table reference `cur_moneda`
	 * @return	boolean FALSE on errors
	 */
	public function readCurrencyBancos($paramfilters = NULL)
	{
		$columns = 'cod_banco,cod_pais,cod_swif,cod_bic,nombre_banco,estado,sessionflag,sessionficha';
		return $this->crudReadTable('cur_banco', $paramfilters, $columns);
	}

	/**
	 * get the many names and their codes from cur_pais, this data 
	 * means whic country is valid or not for system currency manager
	 *
	 * @access	public
	 * @param	array  $paramfilters (0[col1, value], 1[col2, value]), valid cols: check table reference `cur_moneda`
	 * @return	boolean FALSE on errors
	 */
	public function readCurrencyCountry($paramfilters = NULL)
	{
		$columns = 'cod_pais,nombre_pais,nombre_iso,iso3166a2,iso3166a3,estado,notas_pais,sessionflag,sessionficha';
		return $this->crudReadTable('cur_pais', $paramfilters, $columns);
	}

	/**
	 * a READ par of a crud, oriented to our database el currency
	 * 
	 * @access	public
	 * @param	string  $tablename
	 * @param	array  $paramfilters (0[col1, value], 1[col2, value]), valid cols: check table reference `cur_moneda`
	 * @param	string  $columns
	 * @return	boolean FALSE on errors
	 */
	public function crudReadTable($tablename, $paramfilters = NULL, $columns = NULL)
	{
		log_message('debug', __METHOD__ .' parameters  t:'.print_r($tablename,TRUE).' f:' . var_export($paramfilters, TRUE) );
		$querysql1 = "SELECT * FROM ".$tablename;
		$sqlrs = $this->dbc->query($querysql1);
		if($sqlrs == FALSE AND $paramfilters == NULL)
		{
			log_message('debug', __METHOD__ .' invalid data or DB error for '. print_r($tablename,TRUE));
			return $sqldata;
		}
		$sqldata = $sqlrs->result_array();
		if( $columns == NULL)
		{
			log_message('debug', __METHOD__ .' fetch data, no columns selection from '. print_r($tablename,TRUE));
			if(count($sqldata) < 1)
			{
				log_message('debug', __METHOD__ .' no data in table '. print_r($tablename,TRUE));
				return $sqldata;
			}
			$coluymnsarray = array_keys($sqldata[0]);
			$columns = implode(',',$coluymnsarray);
		}
		if(!is_array($paramfilters) OR $paramfilters == NULL)
		{
			log_message('debug', __METHOD__ .' invalid or no filters on '. print_r($tablename,TRUE).' paramfilter'. print_r($sqldata,TRUE));
			return $sqldata;
		}
		log_message('debug', __METHOD__ .' double query prepare for filtering on '. print_r($tablename,TRUE));
		$paramnames =  explode(',',$columns);
		$sqlfilter = '  ';
		foreach ($paramnames as $indicecolumnas=>$nombre)
		{
			if( array_key_exists($nombre, $paramfilters) )
			{
				$$nombre = $paramfilters[$nombre];
				$sqlfilter .= ' AND '.$nombre.'="'.$$nombre.'"';
			}
		}
		$querysql1 = "SELECT ".$columns." FROM cur_moneda WHERE 1=1 ".$sqlfilter ;
		$sqlrs = $this->dbp->query($sqlfichadata1);
		$arreglo_data = $sqlrs->result_array();
		log_message('debug', __METHOD__ .' return cur_moneda data '. print_r($arreglo_data,TRUE));
		$this->closedb();
		return $arreglo_data;
	}

	/**
	 * store all the currencies retrieve from the json array convertes in format ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. )
	 * the process is made into transaction and provided as bulk insert, if someting is present will be skiped
	 * but if something is wrong will be rollback all the process.. all the currencies will be stored inclusively 
	 * those that are deprecated or not active..
	 *
	 * @access	public
	 * @param	array  $curDest ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. )
	 * @param	string  $fecha YYYYMMDD optional if null curren date
	 * @param	string  $curBase XXX optional if null USD
	 * @return	boolean FALSE on errors
	 */
	public function createCurrencyFromApi($curDest = NULL, $curFecha = NULL, $curBase = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received: cd ' . var_export($curDest, TRUE) . ' cb ' . var_export($curBase, TRUE) . ' date ' . var_export($curFecha, TRUE));

		if( is_array($curDest) and array_key_exists('ERR', $curDest[0]) )
		{
			log_message('debug', __METHOD__ .' parametros received: ERRROR from api ( 0[ERR,0] ) ' . var_export($curDest, TRUE));
			return FALSE;
		}
		if( !is_array($curDest) )
		{
			log_message('debug', __METHOD__ .' parametros received: not in array ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. ) ' . var_export($curDest, TRUE));
			return FALSE;
		}
		if( strlen($curBase) < 3 )
		{
			log_message('debug', __METHOD__ .' parametros received: not a 3 key code cb (XXX) ' . var_export($curBase, TRUE) . ' date ' . var_export($curBase, TRUE));
			return FALSE;
		}
		if( strlen($curFecha) < 10 AND strlen($curFecha) > 10 )
		{
			log_message('debug', __METHOD__ .' parametros received: date has no hour cb (XXX) ' . var_export($curBase, TRUE) . ' date (YYYYMMDDHH) ' . var_export($curBase, TRUE));
			$curFecha = date('YmdH');
		}

		$strsqli = array();
		$strsqlc1 = '';
		$id = 1000;
		$curFechaTasa = $curFecha.$id;

		foreach($curDest as $rowc => $keyc )
		{
			$cod_tasa = $curFecha;
			$cod_tasa_tipo = 'INTERNA';
			$mon_tasa_moneda = $keyc['mon_tasa_moneda'];
			$cod_moneda_destino = $keyc['moneda'];
			$cod_moneda_base = $curBase;
			$fecha_tasa = $curFecha.$id;

			$strsqlc1 = "SELECT count(cod_tasa) as cuantos FROM cur_tasas_moneda WHERE SUBSTRING(fecha_tasa, 1, 10) = '".$curFecha."' and cod_moneda_destino = (SELECT cod_moneda FROM cur_moneda WHERE iso4217a3 = '".$cod_moneda_destino."' LIMIT 1 OFFSET 0)";
			$queryrs = $this->dbc->query($strsqlc1);
			$rowcheck = $queryrs->row_array();
			log_message('debug', __METHOD__ .' cod tasa check for ' . print_r($cod_moneda_destino, TRUE));
			if(is_array($rowcheck))
			{
				$wehave = $rowcheck['cuantos'];
				if( $wehave > 0 )
				{
					log_message('debug', __METHOD__ .' cod tasa skiped, we already have a rate for this hour over ' . print_r($cod_moneda_destino, TRUE));
					continue; // we already have at leas one register with this currency code registered, by pass and skip it
				}
			}
			$strsqlc1 = "SELECT count(cod_moneda) as cuantos FROM cur_moneda WHERE iso4217a3 = '".$cod_moneda_destino."' LIMIT 1 OFFSET 0 ";
			$queryrs = $this->dbc->query($strsqlc1);
			$rowcheck = $queryrs->row_array();
			log_message('debug', __METHOD__ .' cod moneda check for ' . print_r($cod_moneda_destino, TRUE));
			if(is_array($rowcheck))
			{
				$wehave = $rowcheck['cuantos'];
				if( $wehave == 0)
				{
					log_message('debug', __METHOD__ .' cod moneda skiped, we do not have such curency registered : ' . print_r($cod_moneda_destino, TRUE));
					continue; // we do not have a 3 letter code registered of this currency, skip it
				}
			}
			$strsqli[] = "INSERT INTO `elcurrencydb`.`cur_tasas_moneda` (`cod_tasa`, `cod_tasa_tipo`, `mon_tasa_moneda`, `cod_moneda_base`, `cod_moneda_destino`, `fecha_tasa`) VALUES ('".$cod_tasa."', 'INTERNA', ".$mon_tasa_moneda.", (SELECT cod_moneda FROM cur_moneda WHERE iso4217a3 = '".$cod_moneda_base."' LIMIT 1 OFFSET 0), (SELECT cod_moneda FROM cur_moneda WHERE iso4217a3 = '".$cod_moneda_destino."' LIMIT 1 OFFSET 0), '".$fecha_tasa."');";
			$id += 1;
		}
		log_message('debug', __METHOD__ .' SQL: ' . print_r($strsqli, TRUE));

		if( count($strsqli) == 0 )
			return 0;

		$this->dbc->trans_start();
		foreach ($strsqli as $value)
		{
			$this->dbc->query($value);
		}
		$this->dbc->trans_complete();

		if ($this->dbc->trans_status() === FALSE)
		{
			$error = $this->dbc->error();
			$qu = $this->dbc->last_query();
			log_message('error', __METHOD__ .' DB problem : ' . print_r($error, TRUE) . ' why: '.print_r($qu, TRUE));
		}

		log_message('info', __METHOD__ .' DB : ' . print_r($id, TRUE) . ' registers inserted from API currency ');
		$this->closedb();
		return 1;
	}

	

}
