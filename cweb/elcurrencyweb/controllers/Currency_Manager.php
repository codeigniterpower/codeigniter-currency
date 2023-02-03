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

		$currency_list_dbarraynow = array();
		$currency_list_apiarray = array();
		$this->load->model('Currency_m','dbcm');
		$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored();
		$this->load->library('Currencylib');
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi('USD');

		$data['currency_list_dbarraynow'] = $currency_list_dbarraynow;
		$data['currency_list_apiarray'] = $currency_list_apiarray;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header.php',$data);
		$this->load->view('menu');
		$this->load->view('currency.php',$data);
	}

	/**
	 * TODO document this: call this from the vie to store the mount of a currency code, returns the code if success
	 */
	public function savecurrency()
	{
		// example:
		$cod_currency = $this->input->post('inputfield_name', FALSE);
		$this->load->model('Currency_m','dbcm');
		$result = $this->dbcm->updateCurrencyMount($cod_currency, $new_mount);
		
	}

	/**
	 * uri CALL to invoke the api and store the data into db
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function callapitodb($codkey = NULL)
	{
		$data = array();
		$data['menu'] = $this->genmenu();
		// example invokation http://localhost/~general/codeigniter-currencylib/cweb/index.php/Currency_Manager/callapitodb/SHAR265ql-23krjhnou2q34rhi2?dateapi=2023-02-03&curbase=USD
		// example shot base "index.php/Currency_Manager/callapitodb/SHAR265ql-23krjhnou2q34rhi2?dateapi=2023-02-03&curbase=USD"
		$dateapi = $this->input->get_post('dateapi', FALSE);
		$currencyBase = $this->input->get_post('curbase', FALSE);
		if($codkey == NULL)
		{
			echo "unauthorized access";
			return;
		}
		if($dateapi == NULL)
		{
			echo "no date given";
			return;
		}
		if(strlen($dateapi) < 10 OR strlen($dateapi) > 10 )
		{
			echo "no valid date";
			return;
		}
		if(strlen($currencyBase) < 3 OR strlen($currencyBase) > 3 )
		{
			echo "no valid currency base money";
			return;
		}
		$currency_list_apiarray = array();
		$this->load->library('Currencylib');
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi($currencyBase);
		$this->load->model('Currency_m','dbcm');
		$createdbresult = $this->dbcm->createCurrencyFromApi($currency_list_apiarray, $dateapi, $currencyBase);
		
		if( $createdbresult == 1)
			echo "salvado";
		echo "error";
	}


}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
