<?php

class Authmodel extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	private function _checkinputsuser($variable)
	{
		return preg_match('/^[0-9A-Za-z\-_]+$/', $variable);
	}

	public function authtable($username, $password)
	{
		log_message('info', __METHOD__ .' begin ');

		$validu = $this->_checkinputsuser($username);
		if($validu == FALSE)
		{
			log_message('info', __METHOD__ .' check input user, invalid user: '. print_r($username,TRUE));
			return FALSE;
		}

		$validu = $this->_checkinputsuser($password);
		if($validu == FALSE)
		{
			log_message('info', __METHOD__ .' check input user, invalid key: '. print_r($password,TRUE));
			return FALSE;
		}

		$this->load->database();
		$query = $this->db->get_where('cur_usuarios', array('user_id'=>$username));
		$array_result = $query->row_array();
		$rs_valid = array();
		foreach($array_result as $rskey => $rsval)
		{
			if($rskey == 'user_id')	$rs_valid['username'] = $rsval;
			$rs_valid[$rskey] = $rsval;
		}

		log_message('info', __METHOD__ .' ended with '.print_r($rs_valid,TRUE));
		return $rs_valid;
	}

	public function authimap($username, $password)
	{
		log_message('info', __METHOD__ .' begin ');

		$validu = $this->_checkinputsuser($username);
		if($validu == FALSE)
		{
			log_message('info', __METHOD__ .' check input user, invalid user: '. print_r($username,TRUE));
			return FALSE;
		}

		$validu = $this->_checkinputsuser($password);
		if($validu == FALSE)
		{
			log_message('info', __METHOD__ .' check input user, invalid key: '. print_r($password,TRUE));
			return FALSE;
		}

		$config = array('plain'=> TRUE, 'username' => $username, 'password' => $password);
		$this->load->library('Imap', $config);
		$rs_valid  = $this->imap->connect($config);

		log_message('info', __METHOD__ .' ended with '.print_r($rs_valid,TRUE));
		return $rs_valid;
	}

}

?>
