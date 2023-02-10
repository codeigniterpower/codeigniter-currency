<?php 
/**
 * table adn colums
 * * cur_usuarios(ficha,username,userclave,)
 * 
 * @author  PICCORO Lenz McKAY <mckaygerhard@gmail.com>
 * @copyright Copyright 2017
 * @version ab - 1.0
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License v3 or any other.
 * 
 */
class Usuario_m extends CI_Model 
{

	private $CI; // CodeIgniter object

	public function __construct() 
	{
		parent::__construct();
		$this->CI =& get_instance();
		$this->db1 = $this->load->database('elcurrencydb', TRUE);
		$this->CI->load->library('form_validation');
	}

	/**
	 * check if a user is present at the db table
	 * if a user is listed in the table are able to login in the web, if not just rejected
	 * the credentials are managed by mail api not by database storage.. 
	 * 
	 * @access	public
	 * @param	string  $username
	 * @param	string  $userstatus
	 * @return	boolean ARRAY with user if user are listed
	 */
	public function getusuariodb($username = NULL, $userstatus = NULL)
	{

		log_message('debug', __METHOD__ .' parametros received: u ' . var_export($username, TRUE) . ' c ' . var_export($userstatus, TRUE) );

		$queryfiltro1 = '1=1';

		$validu = $this->form_validation->required($username);
		$validu = $this->form_validation->alpha_dash($username);
		$validu = $this->form_validation->max_length($username,40);
		$valids = $this->form_validation->required($userstatus);
		$valids = $this->form_validation->alpha($userstatus);

		if ( $validu != FALSE)
			$queryfiltro1 .= " AND `user_id`='".$username."' ";

		if ( $valids != FALSE)
			$queryfiltro1 .= " AND `user_status` = '".$userstatus. "'";

		log_message('debug', __METHOD__ .' filter query ' . var_export($queryfiltro1, TRUE) );

		$sqldbusuarios1c = "SELECT * FROM cur_usuarios WHERE ( ".$queryfiltro1." ) AND `user_id` <> ''";

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqldbusuarios1c, TRUE) );
		$querydbusuarios1c = $this->db1->query($sqldbusuarios1c);
		if($querydbusuarios1c == FALSE)
			return $querydbusuarios1c;
		$usuarios_result = $querydbusuarios1c->result_array();
		log_message('debug', __METHOD__ .' query rs: ' . var_export($usuarios_result, TRUE) );
		return $usuarios_result;
	}

	/**
	 * updates removes user from db, 
	 * if a user is listed in the table are able to login in the web, if not just rejected
	 * the credentials are managed by mail api not by database storage.. 
	 *
	 * @access	public
	 * @param	array  datauser campos de la tabla con sus valores
	 * @param	array  filter  campos de parte "where" del query con los filtros
	 * @return	boolean TRUE on sucess, FALSE on any error that will be logged in CI log
	 */
	public function setusuariodb($parametros=NULL, $filter=NULL)
	{

		log_message('debug', __METHOD__ .' parametros received: ' . var_export($parametros, TRUE) );

		$datauser = array();
		$columnas = array('user_id', 'user_status', 'sessionflag', 'sessionficha');

		if($parametros == NULL)
			return FALSE;

		if ( ! is_array($parametros) ) 				// aqui verifica que sea un arreglo
			return FALSE;

		if ( ! array_key_exists('username',$parametros) )	// aqui verifica si esta username
		{
			if ( ! array_key_exists('user_id',$parametros) )
				return FALSE;
		}
		else
		{
			if( empty($parametros['username']) )	// aqui verifica que no este vacio username
				return FALSE;
		}

		if (is_array($parametros) ) 
		{
			foreach($columnas as $namecolum)
			{
				if( array_key_exists($namecolum, $parametros))
				{
					if( isset($parametros[$namecolum]) )
					{
						$validvalue = preg_match('/^[a-zA-Z0-9,.]{3,}+$/i', $parametros[$namecolum]);
						// DB security https://gitlab.com/codeigniterpower/codeigniter-currencylib/-/issues/5#note_1274873229
						if( $validvalue )
							$datauser[$namecolum] = $parametros[$namecolum];
						else
							log_message('info', __METHOD__ .' detected invalid input or injection attack: '.var_export($validvalue,TRUE).' for '.$datauser[$namecolum]);
						
					}
				}
			}
		}

		if( !isset($datauser['user_id']) )
			$datauser['user_id'] = $datauser['username'];

		log_message('debug', __METHOD__ .' datauser to query: ' . var_export($datauser, TRUE) );

		// $parametros es un arreglo con los datos, si solo uno, no tiene sentido, si existe: es update si no: es insert
		$numeroparametros = count($datauser);
		if ( $numeroparametros < 2 )
			return FALSE;

		if( is_array($filter) )
			$sqluser = $this->db1->update_string('cur_usuarios', $datauser, $filter);
		else
			$sqluser = $this->db1->insert_string('cur_usuarios', $datauser);

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqluser, TRUE) );
		$queryrst = $this->db1->query($sqluser);

		log_message('info', __METHOD__ . ' result detection: '. var_export($queryrst, TRUE) ); // mysql oly
		return $queryrst;
	}

	/**
	 * returns all the user data of the DB
	 * 
	 * @access	public
	 * @param	string  $username
	 * @return	boolean ARRAY with user if user are listed
	 */
	public function getUserData($username = NULL)
	{

		log_message('debug', __METHOD__ .' parametros received: u ' . var_export($username, TRUE) );

		$queryfilter = '1=1';

		$validu = $this->form_validation->required($username);
		$validu = $this->form_validation->alpha_dash($username);
		$validu = $this->form_validation->max_length($username,40);
		
		if ( $validu != FALSE)
			$queryfilter .= " AND `user_id`='".$username."' ";

		log_message('debug', __METHOD__ .' filter query ' . var_export($queryfilter, TRUE) );

		$sqldbusuarios1c = "SELECT * FROM cur_usuarios WHERE ( ".$queryfilter." ) AND `user_id` <> ''";

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqldbusuarios1c, TRUE) );
		$querydbusuarios1c = $this->db1->query($sqldbusuarios1c);
		if($querydbusuarios1c == FALSE)
			return $querydbusuarios1c;
		$usuarios_result = $querydbusuarios1c->result_array();
		log_message('debug', __METHOD__ .' query rs: ' . var_export($usuarios_result, TRUE) );
		return $usuarios_result;
	}


	/**
	 * returns all the user data of the session
	 * 
	 * @access	public
	 * @param	string  $username
	 * @param	string  $userstatus
	 * @return	boolean ARRAY with user if user are listed
	 */
	public function getUserSession($username = NULL)
	{

		log_message('debug', __METHOD__ .' parametros received: u ' . var_export($username, TRUE) );

		$queryfilter = '1=1';

		if ( trim($username) != '*' AND trim($username) != '' AND $username != NULL)
			$queryfilter .= " AND `user_id`='".$username."' ";

		log_message('debug', __METHOD__ .' filter query ' . var_export($queryfilter, TRUE) );

		$sqldbusuarios1c = "SELECT * FROM cur_session WHERE ( ".$queryfilter." ) AND `user_id` <> ''";

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqldbusuarios1c, TRUE) );
		$querydbusuarios1c = $this->db1->query($sqldbusuarios1c);
		if($querydbusuarios1c == FALSE)
			return $querydbusuarios1c;
		$usuarios_result = $querydbusuarios1c->result_array();
		log_message('debug', __METHOD__ .' query rs: ' . var_export($usuarios_result, TRUE) );
		return $usuarios_result;
	}

}
