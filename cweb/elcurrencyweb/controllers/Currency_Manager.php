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
		// $data = array();
		// $data['menu'] = $this->genmenu();

		$currency_list_dbarraynow = array();
		// $currency_list_apiarray = array();
		$this->load->model('Currency_m','dbcm');
		$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored();
		// $this->load->library('Currencylib');
		// $currency_list_apiarray = $this->currencylib->getAllCurrencyByApi('USD');

		$data['currency_list_dbarraynow'] = $currency_list_dbarraynow;
		// $data['currency_list_apiarray'] = $currency_list_apiarray;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header.php',$data);
		$this->load->view('menu');
		$this->load->view('currency.php',$data);
	}

	public function updatecurrency(){
		$this->load->model('Currency_m','dbcm');
		$this->load->library('form_validation');
		$mon_tasa_moneda = $this->input->get_post('mon_tasa_moneda', FALSE);
		$cod_tasa = $this->input->get_post('cod_tasa', FALSE);
		$validfields = $this->form_validation->required($cod_tasa);
		if($validfields == FALSE){
			$error = 1;
		}
		$validfields = $this->form_validation->decimal($mon_tasa_moneda);
		if($validfields == FALSE){
			$error = 2;
		}
		$validfields = $this->form_validation->exact_length($cod_tasa,12);
		if($validfields == FALSE){
			$error = 3;
		}

		$validfields = $this->form_validation->numeric($cod_tasa);
		if($validfields){
			// echo "cod_tasa isn't number";
			$error = 4;
		}
		$result = $this->dbcm->updateCurrencyMount($cod_tasa, $mon_tasa_moneda);
		echo json_encode(array('RESUK'=>$result));


		
		// if(is_numeric($mon_tasa_moneda))
		// {	// readCurrenciesTodayStored($curDest = NULL, $fecha = NULL, $curBase = NULL)

			// $editCurrency = $this->dbcm->readCurrenciesTodayStored(NULL, $cod_tasa ,$mon_tasa_moneda);
			
		// }

		// $this->load->helper(array('form', 'url'));
		
		// $validfields = $this->form_validation->exact_length('inputfield_name',10);
		// $validfields = $this->form_validation->required('curbase');
		// $validfields = $this->form_validation->exact_length('curbase',3);
		// $cod_currency = $this->input->post('inputfield_name', FALSE);
		// $this->load->model('Currency_m','dbcm');
		// $result = $this->dbcm->updateCurrencyMount($cod_currency, $new_mount);
		
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
		$currencyDate = $this->input->get_post('dateapi', FALSE);
		$currencyBase = $this->input->get_post('curbase', FALSE);

		$this->load->library('form_validation');
		$validfields = $this->form_validation->required('dateapi');
		//$validfields = $this->form_validation->exact_length('dateapi',10);
		$validfields = $this->form_validation->required('curbase');
		//$validfields = $this->form_validation->exact_length('curbase',3);

		if($validfields == FALSE)
		{
			echo "empty input parametest dateapi or curbase";
			return;
		}
		if($codkey == NULL)
		{
			echo "unauthorized access";
			return;
		}
		if($currencyDate == NULL)
		{
			echo "no date given";
			return;
		}
		$currency_list_apiarray = array();
		$this->load->library('Currencylib');
		$currencyDate = date('Y-m-d',strtotime($currencyDate));
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi($currencyBase,NULL,$currencyDate);
		$this->load->model('Currency_m','dbcm');
		$currencyDate = date('Ymd',strtotime($currencyDate));
		$createdbresult = $this->dbcm->createCurrencyFromApi($currency_list_apiarray, $currencyDate, $currencyBase);
		
		if( $createdbresult == 1)
		{
			echo "salvado";
		}
		echo "error";
	}


}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
