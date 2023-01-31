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

	protected $db1;

	public function __construct() 
	{
		parent::__construct();
		$this->db1 = $this->load->database('elcurrencydb', TRUE);
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

		$clavelen = strlen($userstatus);
		$queryfiltro1 = '1=1';

		// determino que es lo que se pide un usuario en todo perfil o todos los usuarios
		if ( trim($username) != '*' AND trim($username) != '' AND $username != NULL)
			$queryfiltro1 .= " AND `user_id`='".$username."' ";

		if ( trim($userstatus) != '*' AND trim($userstatus) != '' AND $userstatus != NULL)
			$queryfiltro1 .= " AND `user_status` = '".$userstatus. "'";

		log_message('debug', __METHOD__ .' filter query ' . var_export($queryfiltro1, TRUE) );

		$cuantos = 0;
		// primero cuento cuantos hay en la misma entidad // TODO hacer join con las entidades asociadas
		$sqldbusuarios1c = "
			SELECT count(*) as cuantos 
			FROM `cur_usuarios` 
			WHERE ( ".$queryfiltro1." ) AND `user_id` <> '' LIMIT 1 OFFSET 0";

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqldbusuarios1c, TRUE) );
		$querydbusuarios1c = $this->db1->query($sqldbusuarios1c);
		$usuarios_result = $querydbusuarios1c->result_array();

		log_message('info', __METHOD__ . ' error detection: '. $this->db1->_error_message()); // mysql oly
		return $usuarios_result;	// devuelve un arreglo y el primer elemento del elemento '0' es 'cuantos'
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
			return FALSE;

		if( empty($parametros['username']) )	// aqui verifica que no este vacio username
			return FALSE;

		if (is_array($parametros) ) 
		{
			foreach($columnas as $namecolum)
			{
				if( array_key_exists($namecolum, $parametros))
				{
					if( isset($parametros[$namecolum]) )
					{
						$datauser[$namecolum] = $parametros[$namecolum];
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
			$sqluser = $this->db1->update_string('usuario', $datauser, $filter);
		else
			$sqluser = $this->db1->insert_string('usuario', $datauser);

		log_message('debug', __METHOD__ .' query db: ' . var_export($sqluser, TRUE) );
		$queryrst = $this->db1->query($sqluser);

		log_message('info', __METHOD__ . ' result detection: '. var_export($queryrst, TRUE) ); // mysql oly
		return $queryrst;
	}

}
