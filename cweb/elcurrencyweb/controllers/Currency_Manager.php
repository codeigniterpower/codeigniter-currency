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
		$currency_list_dbarraypre = array();
		// $currency_list_apiarray = array();
		$this->load->model('Currency_m','dbcm');
		$currency_list_dbarraypre = $this->dbcm->readCurrenciesTodayStored('VES',NULL,'USD');
		$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored();

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
		$mon_tasa_moneda = $this->input->post('mon_tasa_moneda', FALSE);
		$cod_tasa = $this->input->post('cod_tasa', FALSE);
		$validfields = $this->form_validation->required($cod_tasa);
		log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r($mon_tasa_moneda, TRUE));
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
		if($validfields == FALSE){
			// echo "cod_tasa isn't number";
			$error = 4;
		}
		$result = $this->dbcm->updateCurrencyMount($cod_tasa, $mon_tasa_moneda);
		log_message('error', __METHOD__ .' vfjgvfjh : ' . print_r($result, TRUE) . ' why: '.print_r($mon_tasa_moneda, TRUE));
		
		echo json_encode(array('result' =>$result));
		// TODO: use this only with desesperate end of time : $this->listcurrencies();
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
		$currencyDest = $this->input->get_post('curdest', FALSE);

		$this->load->library('form_validation');
		$missdest = $this->form_validation->required($currencyDest);
		$validcurren = $this->form_validation->min_length($currencyDest,3);
		$missdate = $this->form_validation->required($currencyDate);
		$validfields = $this->form_validation->exact_length($currencyDate,10);
		$missbase = $this->form_validation->required($currencyBase);
		$validfields = $this->form_validation->exact_length($currencyBase,3);

		if($missdate == FALSE)
			$currencyDate = date('Y-m-d');
		if($missbase == FALSE)
			$currencyBase = 'USD';
		if($validfields == FALSE)
			$currencyBase = 'USD';
		if($missdest == FALSE)
			$currencyDest = NULL;
		if($validcurren == FALSE OR $missdest == FALSE)
		{
			echo "invalid input parametest currency dest seems missing";
			if(mb_strlen($currencyDest) > 3)
			{
				if(stripos($currencyDest,',') == FALSE)
				{
					echo "invalid input parametest currency dest";
					$currencyDest = NULL;
				}
			}
		}
		if($codkey == NULL)
		{
			echo "unauthorized access";
			return json_encode(array('result'=>'unauthorized access'));
		}
		$currency_list_apiarray = array();
		$this->load->library('Currencylib');
		$currencyDate = date('Y-m-d',strtotime($currencyDate));
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi($currencyBase,$currencyDest,$currencyDate);
		$this->load->model('Currency_m','dbcm');
		$currencyDate = date('Ymd',strtotime($currencyDate)).date('H');
		$createdbresult = $this->dbcm->createCurrencyFromApi($currency_list_apiarray, $currencyDate, $currencyBase);
		return json_encode(array('result'=>$createdbresult));
	}


}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
