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
		// load user preferences, lib must be init after loading
		$this->load->library('Userlib');
		$this->userlib->initialize('gonzalez_angel');
		$this->userlib->getID();
		$this->load->model('Currency_m','dbcm');
		$user_preferences = $this->userlib->getUser();
		$cur_monedas_base = $this->userlib->getBaseCurrency();
		$cur_monedas_dest = $this->userlib->getDestCurrency();
		// tambien puedes consultart aparte de $this->userlib->isActive(); tambien $this->userlib->getStatus();
		$currency_list_dbarraynow = array();
		$currency_list_dbarraypre = array();
		// ver si id y status es valido ejemplo $this->userlib->isActive(); solo edita si esta activo
		$currency_list_dbarraypre = $this->dbcm->readCurrenciesTodayStored($cur_monedas_base,NULL,$cur_monedas_dest);
		$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored();
		$data['user_preferences'] = $user_preferences;
		$data['currency_list_dbarraynow'] = $currency_list_dbarraynow;
		$data['currency_list_dbarraypre'] = $currency_list_dbarraypre;
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
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r($cod_tasa, TRUE));
			return $error = 0;
		}
		$validfields = $this->form_validation->exact_length($cod_tasa,14);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r("No cumple con la longitud", TRUE));
			return $error = 0;
		}
		$validfields = $this->form_validation->numeric($cod_tasa);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r("No es numerico 1", TRUE));
			echo json_encode(array('result' =>'Debe ser un numero entero o decimal'));
			return $error = 0;
		}
		$validfields = $this->form_validation->required($mon_tasa_moneda);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r($mon_tasa_moneda, TRUE));
			echo json_encode(array('result' =>'Debe ingresar un monto'));
			return $error = 0;
		}
		$validfields = $this->form_validation->numeric($mon_tasa_moneda);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($_POST, TRUE) . ' why: '.print_r("No es numerico", TRUE));
			echo json_encode(array('result' =>'Debe ser de tipo numerico'));
			return $error = 0;
		}


		$result = $this->dbcm->updateCurrencyMount($cod_tasa, $mon_tasa_moneda);
		log_message('error', __METHOD__ .' POST : ' . print_r($result, TRUE) . ' why: '.print_r("Ocurrio un error al guardar", TRUE));
		
		echo json_encode(array('result' =>$result));
		// TODO: use this only with desesperate end of time : $this->listcurrencies();
	}

	/**
	 * uri CALL to invoke the api and store the data into db
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function callapitodb(
		$codkey = NULL
		)
	{
		if($codkey != $this->config->item('codkey') ){
			log_message('error', __METHOD__ .' unauthorized access, missing key api');
		 	return json_encode(array('result'=>'unauthorized access'));
		}
		if($codkey == NULL)
		{
			log_message('error', __METHOD__ .' unauthorized access, missing key api');
		 	return json_encode(array('result'=>'unauthorized access'));
		}
		log_message('error', __METHOD__ .' GET : ' . ' from parameter: '.print_r($codkey, TRUE));
		$this->load->config('currencyweb');
		$codKey = $this->config->item('codkey');
		log_message('error', __METHOD__ .' GET : ' . ' from config: '.print_r($codkey, TRUE));
		if(ENVIRONMENT !== 'production')
		{
			if($codKey == 'sha256-EXAMPLE');
		}
	  	else
	  	{
			//TODO  DEVELOPT A METHOD TO CHECK
	  	}

		$config['language']     = 'spanish';
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
		if($validcurren == FALSE OR $missdest == FALSE)
		{
			log_message('info', __METHOD__ .' missing currency rates to convert, we will use all availables from api results ');
			$currencyDest = NULL;
		}
		if(mb_strlen($currencyDest) > 3)
		{
			if(stripos($currencyDest,',') == FALSE)
			{
				log_message('error', __METHOD__ .' invalid currency set, more than one but missing separator, we will use all');
				$currencyDest = NULL;
			}
		}


		log_message('debug', __METHOD__ .' save?1 :  '.print_r($currencyDate, TRUE));
		$currency_list_apiarray = array();
		$this->load->library('Currencylib');
		log_message('debug', __METHOD__ .' save?2 :  '.print_r($currencyDate, TRUE));
		$currencyDate = date('Y-m-d',strtotime($currencyDate));
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi($currencyBase,$currencyDest,$currencyDate);
		log_message('debug', __METHOD__ .' save?3 :  '.print_r($currencyDate, TRUE));
		$this->load->model('Currency_m','dbcm');
		$currencyDate = date('Ymd',strtotime($currencyDate)).date('H');
		$createdbresult = $this->dbcm->createCurrencyFromApi($currency_list_apiarray, $currencyDate, $currencyBase);
		log_message('debug', __METHOD__ .' save? : ' .print_r($createdbresult,TRUE). ' from parameter: '.print_r($currencyDate, TRUE));
		return json_encode(array('result'=>$createdbresult));
	// }
		

	}


}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
