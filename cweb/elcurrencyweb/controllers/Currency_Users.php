<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * currencylib Controller Class de inicio login/logout y info user
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Currency_Users extends CP_Controller {

	/**
	 * name: desconocido
	 * @param
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','html'));
		$this->checksession();
	}

	/**
	 * index just is the entry point of the controller, default to list users
	 * 
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function index()
	{
		$this->listusers();
	}

	/**
	 * listusers show user list, that can get into the currency manager system
	 * 
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function listusers()
	{
		$data = array();
		$data['menu'] = $this->genmenu();
		$data['currency_list_dbarray'] = $this->currentctr;
		$data['currency_list_apiarray'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('menu');
		$this->load->view('empty',$data);
		// $this->load->view('footer',$data);
		$this->load->view('footer_internal',$data);

	}
}

/* End of file Currency_Users.php */
/* Location: ./application/controllers/Currency_Users.php */
