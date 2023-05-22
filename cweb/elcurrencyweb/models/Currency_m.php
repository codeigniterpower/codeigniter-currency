<?php 
/**
 * currrency_m.php
 * 
 * abstraction DB to manage currency and rate convertion
 *
 * cur_moneda
 * * currency(cod iso, 4217-a, 3letters, name)
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

	private $tablect;
	private $tablecp;
	private $tablecb;
	private $tablecm;
	private $CI; // CodeIgniter object

	public function __construct() 
	{
		parent::__construct();
		$this->dbc = $this->load->database('elcurrencydb', TRUE);
		$this->tablect = 'cur_tasas_moneda';
		$this->tablecp = 'cur_pais';
		$this->tablecb = 'cur_banco';
		$this->tablecm = 'cur_moneda';
		$this->CI =& get_instance();
		$this->CI->load->library('form_validation');
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
	public function readCurrenciesTodayStored($curDest = NULL, $fecha = NULL, $curBase = NULL, $howmany = NULL, $iniciar = NULL, $ordercol = NULL, $sorting = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received: cd ' . var_export($curDest, TRUE) . ' cb ' . var_export($curBase, TRUE) . ' date ' . var_export($fecha, TRUE));

		$validcbr = $this->form_validation->required($curBase);
		$validcdr = $this->form_validation->required($curDest);
		$validcfr = $this->form_validation->required($fecha);

		$validcbl = $this->form_validation->exact_length($curBase,3);
		$validcdl = $this->form_validation->min_length($curDest,3);
		$validcfl = $this->form_validation->min_length($fecha,8);

		$validcbs = $this->form_validation->alpha($curBase);
		$validcds = preg_match('/^[a-zA-Z,]{3,}+$/i', $curDest);
		$validcfn = $this->form_validation->numeric($fecha);

		$curDestlen = strlen($curDest);
		$curBaselen = strlen($curBase);
		$fechalen = strlen($fecha);

		$paramfilters = array();
		if( $validcfr AND $validcfl AND $validcfn)
			$paramfilters['fecha'] = $fecha;
		else
			$paramfilters['fecha'] = date('Ymd');
		if( $validcbr AND $validcbl AND $validcbs)
			$paramfilters['curBase'] = $curBase;
		if( $validcdr AND $validcdl AND $validcds)
			$paramfilters['curDest'] = $curDest;

		$limiters['howmany'] = $howmany; // limit
		$limiters['iniciar'] = $iniciar; // offset
		$limiters['ordercol'] = $ordercol; // colum
		$limiters['sorting'] = $sorting; // order
		$arraydata = $this->readTasas($paramfilters, TRUE, $limiters);
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
	public function readCurrenciesHistStored($parameters = NULL, $howmany = NULL, $iniciar = NULL, $ordercol = NULL, $sorting = NULL, $countall = NULL)
	{
		if(!is_array($parameters))
			$parameters = array();
		$limiters['howmany'] = $howmany; // limit
		$limiters['iniciar'] = $iniciar; // offset
		$limiters['ordercol'] = $ordercol; // colum
		$limiters['sorting'] = $sorting; // order
		$limiters['countall'] = $countall; // get total table rows
		$arraydata = $this->readTasas($parameters, FALSE, $limiters);
		log_message('debug', __METHOD__ .' data from DB received for history');
		return $arraydata;
	}

	/**
	 * get all currencies and their conversion, based on a first one, by default USD currency
	 * this is a sepcial CURD read from table cur_tasas_moneda
	 * 
	 * @access	public
	 * @param	array  $paramfilters ('columname'=>'value'[,'columname'=>'value',..])
	 * @return	mixed FALSE on errors
	 */
	public function readTasas($paramfilters = NULL, $limited = FALSE, $limiters = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received:  ' . var_export($paramfilters, TRUE). ' limiters ' . var_export($limiters, TRUE) );

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
					// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
					$validvalue = preg_match('/^[a-zA-Z0-9]{3,}+$/i', $$namecolumn);
					if( $validvalue != FALSE )
						$queryfiltro .= ' AND '.$namecolumn.'="'.$$namecolumn.'"';
					else
						log_message('info', __METHOD__ .' detected invalid input or injection attack: '.var_export($validvalue,TRUE).' for '.$$namecolum);
				}
			}
			if( array_key_exists('fecha', $paramfilters) )
			{
				$fechalen = strlen($paramfilters['fecha']);
				$queryfiltro .= ' AND SUBSTRING(cod_tasa, 1, '.$fechalen.')="'.$paramfilters['fecha'].'"';
			}
			if( array_key_exists( 'curBase', $paramfilters) )
				$queryfiltro .= ' AND moneda_base LIKE "'.$paramfilters['curBase'].'%"';
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
			// curBase, curDest and fecha are already filtered in the parser funtion origin
		}
		if(is_array($limiters) ) // for DBMS security read 
		{
			if( array_key_exists('countall', $limiters) )
			{
				$countall = $limiters['countall'];
				if( is_null($countall) !== TRUE AND empty($countall) !== TRUE ) // no need to spaced, we just detect if present
				$columnssql = 'count(cod_tasa) as cod_tasa ';
			}
			if( array_key_exists('ordercol', $limiters) )
			{
				$ordercol = $limiters['ordercol'];
				$validvalue = preg_match('/^[a-zA-Z0-9]{1,40}+$/i', $ordercol);
				if( $validvalue == FALSE)
					$ordercol = 'cod_tasa';
				// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
				$queryfiltro .= ' ORDER BY '.$ordercol;

				if( array_key_exists('sorting', $limiters) )
				{
					$sorting = $limiters['sorting'];
					$validvalue = preg_match('/^[a-zA-Z0-9]{1,40}+$/i', $sorting);
					if( $validvalue == FALSE)
						$sorting = ' DESC';
					// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
					$queryfiltro .= ' '.$sorting;
				}
				else
					$queryfiltro .= ' DESC';
			}
			else
				$queryfiltro .= ' ORDER BY cod_tasa DESC';
			if( array_key_exists('howmany', $limiters) )
			{
				$howmany = $limiters['howmany'];
				$validvalue = preg_match('/^[0-9]{1,}+$/i', $howmany);
				if( $validvalue )
				{
					if( array_key_exists('iniciar', $limiters) )
					{
						$iniciar = $limiters['iniciar'];
						$validvalue = preg_match('/^[0-9]{1,}+$/i', $howmany);
						if( $validvalue == FALSE )
							$iniciar = 0;
						if($iniciar < $howmany)
							$howmany = 50;
					}
					$queryfiltro .= ' LIMIT '.$howmany;
					$queryfiltro .= ' OFFSET '.$iniciar;
				}
			}
		}

		$querysql = "
			SELECT 
				".$columnssql."
			FROM
				(SELECT 
					t.cod_tasa,
					ROUND(t.mon_tasa_moneda,4) as mon_tasa_moneda,
						(SELECT 
								CONCAT(m1.iso4217a3, \":\", m1.nombre_moneda)
							FROM
								".$this->tablecm." AS m1
							WHERE
								m1.cod_moneda = t.cod_moneda_base
							LIMIT 1 OFFSET 0) 
					AS moneda_base,
						(SELECT 
								CONCAT(m1.iso4217a3, \":\", m1.nombre_moneda)
							FROM
								".$this->tablecm." AS m1
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
					".$this->tablect." AS t)
				AS tablec
			WHERE
				1=1 
		".$queryfiltro;


		log_message('debug', __METHOD__ .' query db: ' . print_r($querysql, TRUE) );
		$querysqlrs = $this->dbc->query($querysql);
		if($querysqlrs === FALSE)
		{
			log_message('error', __METHOD__ . ' error detection: '. print_r($currency_result,TRUE) );
			return FALSE;
		}
		$currency_result = $querysqlrs->result_array();
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
		$columns = 'cod_moneda,iso4217a3,simbolo_unicode,nombre_moneda,estado,notas_pais,sessionflag,sessionficha';
		return $this->crudReadTable($this->tablecm, NULL, $columns);
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
		return $this->crudReadTable($this->tablecb, $paramfilters, $columns);
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
		return $this->crudReadTable($this->tablecp, $paramfilters, $columns);
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
		if($sqlrs == FALSE)
		{
			log_message('error', __METHOD__ .' invalid data or DB error for '. print_r($tablename,TRUE));
			return FALSE;
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
			log_message('debug', __METHOD__ .' no filters provided for '. print_r($tablename,TRUE));
			return $sqldata;
		}
		log_message('debug', __METHOD__ .' double query prepare for filtering on '. print_r($tablename,TRUE));
		$paramnames =  explode(',',$columns);
		$sqlfilter = '  ';
		foreach ($paramnames as $indicecolumnas=>$namecolum)
		{
			if( array_key_exists($namecolum, $paramfilters) )
			{
				$$namecolum = $paramfilters[$namecolum];
				// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
				$validvalue = preg_match('/^[a-zA-Z0-9]{3,}+$/i', $$namecolumn);
				if( $validvalue != FALSE )
					$sqlfilter .= ' AND '.$namecolum.'="'.$$namecolum.'"';
				else
					log_message('info', __METHOD__ .' detected invalid input or injection attack: '.var_export($validvalue,TRUE).' for '.$$namecolum);
			}
		}
		$querysql1 = "SELECT ".$columns." FROM ".$tablename." WHERE 1=1 ".$sqlfilter ;
		$sqlrs = $this->dbp->query($sqlfichadata1);
		if($sqlrs == FALSE)
		{
			log_message('error', __METHOD__ .' invalid filters, column or DB error for '. print_r($tablename,TRUE));
			return FALSE;
		}
		$arreglo_data = $sqlrs->result_array();
		log_message('debug', __METHOD__ .' return '.$tablename.' data '. print_r($arreglo_data,TRUE));
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
	 * @param	string  $fecha YYYYMMDDHH optional if null curren date
	 * @param	string  $curBase XXX optional if null USD
	 * @return	boolean FALSE on errors
	 */
	public function createCurrencyFromApi($curDest = NULL, $curFecha = NULL, $curBase = NULL)
	{
		log_message('debug', __METHOD__ .' try to update DB with new currency for today...');

		if( is_array($curDest) )
		{
			if( count($curDest) > 0) 
				if( array_key_exists('ERR', $curDest[0]) )
				{
					log_message('error', __METHOD__ .' parametros received: ERRROR from api ( 0[ERR,0] ) ' . var_export($curDest, TRUE));
					return FALSE;
				}
			if( count($curDest) < 1) 
			{
				log_message('error', __METHOD__ .' no currencies to update seems array empty ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. ');
				return FALSE;
			}
		}
		if( !is_array($curDest) )
		{
			log_message('error', __METHOD__ .' parametros received: not in array ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. ');
			return FALSE;
		}
		if( mb_strlen($curFecha) < 8 OR mb_strlen($curFecha) > 10 )
		{
			log_message('error', __METHOD__ .' invalid date lenght (YYYYmmdd) ' . var_export($curFecha, TRUE));
			$curFecha = date('YmdH');
		}
		$validvalue = preg_match('/^[0-9]{10}+$/i', $curFecha);
		if( $validvalue == FALSE )
		{
			log_message('error', __METHOD__ .' invalid input cos date seems not valid (YYYYmmddHHmm) ' . var_export($curFecha, TRUE));
			$curFecha = date('YmdH');
		}
		$validvalue = preg_match('/^[a-zA-Z]{3}+$/i', $curBase);
		if( $validvalue == FALSE )
		{
			log_message('error', __METHOD__ .' invalid input or injection attack: not a 3 key code cb (XXX) ' . var_export($curBase, TRUE));
			return FALSE;
		}
		// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229

		$strsqli = array();
		$strsqlc1 = '';
		$id = 1;
		$cod_tasa = $curFecha.'1000'; // YYYYmmddHH+XXXX
		$cod_moneda_base = $curBase;

		$strsqlc1 = "SELECT count(cod_tasa) as cuantos FROM ".$this->tablect." WHERE SUBSTRING(cod_tasa, 1, 10) = '".$curFecha."' and cod_moneda_base = (SELECT cod_moneda FROM ".$this->tablecm." WHERE iso4217a3 = '".$cod_moneda_base."' LIMIT 1 OFFSET 0)";
		$queryrs = $this->dbc->query($strsqlc1);
		$rowcheck = $queryrs->row_array();
		log_message('debug', __METHOD__ .' cod tasa check for ' . print_r($curFecha, TRUE).' of ' . print_r($curBase, TRUE));
		if(is_array($rowcheck))
		{
			$wehave = $rowcheck['cuantos'];
			if( $wehave > 0 )
			{
				log_message('debug', __METHOD__ .' cod tasa skiped, we already have a rate for this hour over ' . print_r($curFecha, TRUE));
				$this->closedb();
				return 1;
			}
		}

		foreach($curDest as $rowc => $keyc )
		{
			$cod_tasa_tipo = 'INTERNA';
			$mon_tasa_moneda = $keyc['mon_tasa_moneda'];
			$cod_moneda_destino = $keyc['moneda'];

			$validvalue = preg_match('/^[a-zA-Z]{3}+$/i', $cod_moneda_destino);
			if( $validvalue == FALSE )
			{
				log_message('error', __METHOD__ .' skiped cos invalid or injection attack: not a 3 key code cod moneda dest (XXX) ' . var_export($cod_moneda_destino, TRUE));
				continue;
			}
			$validvalue = preg_match('/^[0-9\.]{3,}+$/i', $mon_tasa_moneda);
			if( $validvalue == FALSE )
			{
				log_message('error', __METHOD__ .' skiped cos invalid or injection attack: not valid amount (NN.NN) for cod_dest ' . var_export($mon_tasa_moneda, TRUE).':'.$cod_moneda_destino);
				continue;
			}
			// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229

			$strsqlc1 = "SELECT count(cod_tasa) as cuantos FROM ".$this->tablect." WHERE cod_tasa = '".$cod_tasa."'";
			$queryrs = $this->dbc->query($strsqlc1);
			$rowcheck = $queryrs->row_array();
			//log_message('debug', __METHOD__ .' cod tasa check for ' . print_r($cod_moneda_destino, TRUE).' cod_tasa ' . print_r($cod_tasa, TRUE));
			if(is_array($rowcheck))
			{
				$wehave = $rowcheck['cuantos'];
				//log_message('debug', __METHOD__ .' we have ' . print_r($cod_moneda_destino, TRUE).' at least ' . print_r($wehave, TRUE));
				if( $wehave > 0 )
				{
					//log_message('debug', __METHOD__ .' cod tasa skiped, we already have a rate for this hour over ' . print_r($cod_moneda_destino, TRUE));
					continue; // we already have at leas one register with this currency code registered, by pass and skip it
				}
			}
			$strsqlc1 = "SELECT count(cod_moneda) as cuantos FROM ".$this->tablecm." WHERE iso4217a3 = '".$cod_moneda_destino."' LIMIT 1 OFFSET 0 ";
			$queryrs = $this->dbc->query($strsqlc1);
			$rowcheck = $queryrs->row_array();
			//log_message('debug', __METHOD__ .' cod moneda check for ' . print_r($cod_moneda_destino, TRUE));
			if(is_array($rowcheck))
			{
				$wehave = $rowcheck['cuantos'];
				if( $wehave == 0)
				{
					//log_message('debug', __METHOD__ .' cod moneda skiped, we do not have such curency registered : ' . print_r($cod_moneda_destino, TRUE));
					continue; // we do not have a 3 letter code registered of this currency, skip it
				}
			}
			$strsqli[] = "INSERT INTO `elcurrencydb`.`".$this->tablect."` (`cod_tasa`, `cod_tasa_tipo`, `mon_tasa_moneda`, `cod_moneda_base`, `cod_moneda_destino`) VALUES ('".$cod_tasa."', 'INTERNA', ".$mon_tasa_moneda.", (SELECT cod_moneda FROM ".$this->tablecm." WHERE iso4217a3 = '".$cod_moneda_base."' LIMIT 1 OFFSET 0), (SELECT cod_moneda FROM ".$this->tablecm." WHERE iso4217a3 = '".$cod_moneda_destino."' LIMIT 1 OFFSET 0));";
			$id += 1;
			$cod_tasa += 1;
		}

		if( count($strsqli) == 0 )
		{
			log_message('info', __METHOD__ .' DB : ' . print_r($id, TRUE) . ' registers not inserted from API currency ');
			$this->closedb();
			return 0;
		}

		$this->dbc->trans_start();
		foreach ($strsqli as $sqlinserttorun)
		{
			$this->dbc->query($sqlinserttorun);
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

	/**
	 * update only one currency mount from the currency table using the given code
	 *
	 * @access	public
	 * @param	array  $curDest ( 0[YYY,ZZZ] 1[YYY,ZZZ] .. )
	 * @param	string  $fecha YYYYMMDD optional if null curren date
	 * @param	string  $curBase XXX optional if null USD
	 * @return	boolean FALSE on errors
	 */
	public function updateCurrencyMount($cod_tasa = NULL, $mon_tasa_moneda = NULL)
	{
		log_message('debug', __METHOD__ .' parametros received: cd ' . var_export($cod_tasa, TRUE) . ' mount ' . var_export($mon_tasa_moneda, TRUE));

		$validct = $this->form_validation->required($cod_tasa);
		$validmt = $this->form_validation->required($mon_tasa_moneda);
		$validcl = $this->form_validation->exact_length($cod_tasa,14);
		// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
		if( $validcl == FALSE )
		{
			log_message('error', __METHOD__ .' parametros received: ERROR cod_tasa ' . var_export($codcurrencylen, TRUE));
			return FALSE;
		}
		if( !is_numeric(trim($mon_tasa_moneda)) OR $validmt == FALSE )
		{
			log_message('error', __METHOD__ .' parametros received: ERROR not numeric ' . var_export($mon_tasa_moneda, TRUE));
			return FALSE;
		}

		$data = array('mon_tasa_moneda' => $mon_tasa_moneda);
		$where = "cod_tasa = '".$cod_tasa."'";
		$savesql = $this->dbc->update_string($this->tablect, $data, $where); 

		$this->dbc->trans_start();
		$this->dbc->query($savesql);
		$this->dbc->trans_complete();

		if ($this->dbc->trans_status() === FALSE)
		{
			$error = $this->dbc->error();
			$qu = $this->dbc->last_query();
			log_message('error', __METHOD__ .' DB problem : ' . print_r($error, TRUE) . ' why: '.print_r($qu, TRUE));
			return FALSE;
		}

		log_message('info', __METHOD__ .' DB : registers inserted from API currency ');
		$this->closedb();
		return 1;
	}


}
