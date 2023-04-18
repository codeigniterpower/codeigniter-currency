<?php

class Authmodel extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function authtable($username, $password)
	{
		log_message('info', __METHOD__ .' begin ');

		$validu = $this->form_validation->required($username);
		$validu = $this->form_validation->alpha_dash($username);
		$validu = $this->form_validation->max_length($username,40);
		$valids = $this->form_validation->required($password);
		$valids = $this->form_validation->alpha($password);

		if($validu == FALSE OR $valids == FALSE) return FALSE;

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

		$validu = $this->form_validation->required($username);
		$validu = $this->form_validation->alpha_dash($username);
		$validu = $this->form_validation->max_length($username,40);
		$valids = $this->form_validation->required($password);
		$valids = $this->form_validation->alpha($password);

		if($validu == FALSE OR $valids == FALSE) return FALSE;

		$config = array('plain'=> TRUE, 'username' => $username, 'password' => $password);
		$this->load->library('Imap', $config);
		$rs_valid  = $this->imap->connect($config);

		log_message('info', __METHOD__ .' ended with '.print_r($rs_valid,TRUE));
		return $rs_valid;
	}

}

?>
