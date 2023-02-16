<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * THIS CONTROLLER IS INTERFACE TO PROVIDE CURRENCY FUNCTIONALITY TO OHERS SYSTEMS
 * remmembered that each controller is a request calll in the web app
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Currency_Api extends CP_Controller {

	/**
	 * name: default constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','html'));
		$this->output->enable_profiler(ENVIRONMENT !== 'production');
	}


	/**
	 * uri CALL to uptate the amount of a specific rate currency by code using api call
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function updateRateAmount()
	{
		$this->load->model('Currency_m','dbcm');
		$this->load->library('Userlib');
		$this->load->library('form_validation');

		$mon_tasa_moneda = $this->input->post('mon_tasa_moneda', FALSE);
		$cod_tasa = $this->input->post('cod_tasa', FALSE);
		$user_id = $this->input->post('user_id', FALSE);
		$codkey = $this->input->post('codkey', FALSE);

		$validfields = $this->form_validation->required($cod_tasa);
		$validfields = preg_match('/^[0-9]{1,14}+$/i', $cod_tasa);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($cod_tasa, TRUE) . ' why field (numeric/lenght) is : '.var_export($validfields, TRUE));
			$error = 2;
			echo json_encode(array('result' =>'cod_tasa invalid format or no data provided'));
			return $error;
		}

		$validfields = $this->form_validation->required($mon_tasa_moneda);
		$validfields = preg_match('/^[0-9\.]{1,}+$/i', $mon_tasa_moneda);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($mon_tasa_moneda, TRUE) . ' moneda is not numeric/decmal : '.print_r($validfields, TRUE));
			$error = json_encode(array('result' =>'mon_tasa_moneda invalida format or no data provided'));
			echo $error;
			return $error;
		}

		$validfields = $this->form_validation->required($mon_tasa_moneda);
		$validfields = preg_match('/^[0-9\.]{1,}+$/i', $mon_tasa_moneda);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($mon_tasa_moneda, TRUE) . ' moneda is not numeric/decmal : '.print_r($validfields, TRUE));
			$error = json_encode(array('result' =>'mon_tasa_moneda invalida format or no data provided'));
			echo $error;
			return $error;
		}

		$this->userlib->initialize($user_id);
		if($this->userlib->isActive()){
			$result = $this->dbcm->updateCurrencyMount($cod_tasa, $mon_tasa_moneda);
		}

		log_message('info', __METHOD__ .' DB result : ' . print_r($result, TRUE) );
		$result = json_encode(array('result' =>$result));
		echo $result;
		return $result;
		// TODO: use this only with desesperate end of time : $this->listcurrencies();
	}

	/**
	 * uri CALL to invoke the api and store the data into db
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function callApisAndSaveDB($codkey = NULL)
	{

		$this->load->model('Currency_m','dbcm');
		$this->load->library('Userlib');
		$this->load->library('form_validation');

		$user_id = $this->input->post('user_id', FALSE);
		$codkey = $this->input->post('codkey', FALSE);

		$validfields = $this->form_validation->required($user_id);
		$validfields = preg_match('/^[a-zA-Z0-9\.]{1,}+$/i', $user_id);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($user_id, TRUE) . ' user_id is not valid : '.print_r($validfields, TRUE));
			$error = json_encode(array('result' =>'user_id is not valid'));
			echo $error;
			return $error;
		}

		$validfields = $this->form_validation->required($codkey);
		$validfields = preg_match('/^[a-zA-Z0-9\.]{1,}+$/i', $codkey);
		if($validfields == FALSE){
			log_message('error', __METHOD__ .' POST : ' . print_r($codkey, TRUE) . ' codkey is not valid : '.print_r($validfields, TRUE));
			$error = json_encode(array('result' =>'codkey is not valid'));
			echo $error;
			return $error;
		}

		$data = array();
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

		$this->userlib->initialize($user_id);

		log_message('debug', __METHOD__ .' getting the data from internet API for :  '.print_r($currencyDate, TRUE));
		$currency_list_apiarray = array();
		$this->load->library('Currencylib');
		$currencyDate = date('Y-m-d',strtotime($currencyDate));
		$currency_list_apiarray = $this->currencylib->getAllCurrencyByApi($currencyBase,$currencyDest,$currencyDate);

		log_message('debug', __METHOD__ .' API already called, now try to store the result into DB for :  '.print_r($currencyDate, TRUE));
		$this->load->model('Currency_m','dbcm');
		$currencyDate = date('Ymd',strtotime($currencyDate)).date('H');
		$createdbresult = $this->dbcm->createCurrencyFromApi($currency_list_apiarray, $currencyDate, $currencyBase);
		log_message('debug', __METHOD__ .' saved? : ' .print_r($createdbresult,TRUE). ' from parameter: '.print_r($currencyDate, TRUE));
		$result = json_encode(array('result'=>$createdbresult));
		echo $result;
		return $result;
	}

}
