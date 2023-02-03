<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * THIS CONTROLLER IS FOR MANAGE THE CURRENCY INTO DB AND MAKE CONVERSTIONS WITH ALREADY LOGGED IN SESSION
 * remmembered that each controller is a request calll in the web app
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Currency_Manager extends CP_Controller {

	/**
	 * name: desconocido
	 */
	function __construct()
	{
		parent::__construct();
	$this->load->helper(array('form', 'url','html'));
	$this->output->enable_profiler(ENVIRONMENT !== 'production');

	}

	/**
	 * index que muestra vista con instrucciones, las instrucciones estan en la vista indexinput
	 * 
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function index()
	{
		$this->listcurrencies();
	}

	/**
	 * this controler is the URI call to set the currency and stored into DB, 
	 * it also has a button or trick to request a call to api and get lasted currency from api
	 * mean can also have a form to request a specific currency conversion
	 *
	 * @access	public
	 */
	public function listcurrencies()
	{
		$data = array();
		$data['menu'] = $this->genmenu();

		$currency_list_dbarray = array();
		$currency_list_apiarray = array();
		$this->load->model('Currency_m','dbcm');
		$currency_list_dbarray = $this->dbcm->getCurrencies(); // TODO : for now the model only brings everything that has the tables, in the following view the filter options are created
		$this->load->library('Currencylib');
		$currency_list_apiarray = $this->currencylib->conCurrency('USD');

		$data['currency_list_dbarray'] = $currency_list_dbarray;
		$data['currency_list_apiarray'] = $currency_list_apiarray;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header.php',$data);
		$this->load->view('menu');
		$this->load->view('currency.php',$data);
	}
}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
