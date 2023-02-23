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
	 * it will receive the user_id, cod_base, mon_rate currency and codkey as post parameters, 
	 * and later will return 1 when sucess and any other string when fails
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
	 * uri CALL to invoke the api and store the data into db, 
	 * it will receive the user_id and codkey as post parameters, 
	 * and later will return 1 when sucess and any other string when fails
	 *
	 * @access	public
	 * @param   $extradata mixed and authentication string key to check api
	 */
	public function callApisAndSaveDB($extradata = NULL)
	{

		$this->load->model('Currency_m','dbcm');
		$this->load->library('Userlib');
		$this->load->library('form_validation');

		$user_id = $this->input->post('user_id', FALSE);
		$codkey = $this->input->post('codkey', FALSE);

		$validfields = $this->form_validation->required($user_id);
		$validfields = preg_match('/^[a-zA-Z0-9_\.]{1,}+$/i', $user_id);
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
		$result = $createdbresult;

		$data = array();
		$data['result'] = $createdbresult;
		$data['currency_list_apiarray'] = $currency_list_apiarray;
		$data['currenturl'] = $this->currenturl;
		log_message('debug', __METHOD__ .' saved? : ' .print_r($data,TRUE). ' from parameter: '.print_r($currencyDate, TRUE));
		$result = json_encode($data);
		echo $result;
		return $result;
	}

	/**
	 * uri CALL to read rates from db event call from an external api (if there is such rates already saved)
	 * it will receive the user_id, currency base, mount currency and codkey as post parameters, 
	 * and later will return 1 when sucess and any other string when fails
	 * the data when success will be in second string after the result
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function callRatesFromDB($extradata = NULL)
	{

		$this->load->model('Currency_m','dbcm');
		$this->load->library('Userlib');
		$this->load->library('form_validation');

		$user_id = $this->input->get_post('user_id', FALSE);
		$codkey = $this->input->get_post('codkey', FALSE);
		$currencyBase = $this->input->get_post('curbase', FALSE);
		$currencyDest = $this->input->get_post('curdest', FALSE);
		$currencyDate = $this->input->get_post('dateapi', FALSE);

		$validfields = $this->form_validation->required($user_id);
		$validfields = preg_match('/^[a-zA-Z0-9_\.]{1,}+$/i', $user_id);
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

		$missdest = $this->form_validation->required($currencyDest);
		$validcurren = $this->form_validation->exact_length($currencyDest,3);
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

		$this->userlib->initialize($user_id);
		$this->userlib->getID();

		log_message('debug', __METHOD__ .' API already called, now try to retrieve the result from DB for :  '.print_r($currencyDate, TRUE));
		$user_preferences = $this->userlib->getUser();
		$cur_monedas_base = $this->userlib->getBaseCurrency();
		$cur_monedas_dest = $this->userlib->getDestCurrency();
		$currency_list_dbarraynow = array();
		$currency_list_dbarraypre = array();
		// ver si id y status es valido ejemplo $this->userlib->isActive(); solo edita si esta activo
		$active = $this->userlib->isActive();
		if($active)
		{
			$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored($currencyDest,$currencyDate,$currencyBase);
			$currency_list_dbarraypre = $this->dbcm->readCurrenciesTodayStored($cur_monedas_dest,NULL,$cur_monedas_base);
		}
		$result = 0;
		if(is_array($currency_list_dbarraypre))
		{
			if(count($currency_list_dbarraypre) > 0 );
				$result = 1;
		}
		if(is_array($currency_list_dbarraynow))
		{
			if(count($currency_list_dbarraynow) > 0 );
				$result = 1;
		}
		$data = array();
		$data['result'] = $result;
		$data['currency_list_dbarraynow'] = $currency_list_dbarraynow;
		$data['currency_list_dbarraypre'] = $currency_list_dbarraypre;
		$data['currenturl'] = $this->currenturl;
		log_message('debug', __METHOD__ .' saved? : ' .print_r($data,TRUE). ' from parameter: '.print_r($currencyDate, TRUE));
		$result = json_encode($data);
		echo $result;
		return $result;
	}

	/**
	 * uri CALL to convert one currency to another currency TODO
	 * it will receive the user_id, currency base/dest, mount currency and codkey as post parameters, 
	 * and later will return 1 when sucess and any other string when fails
	 * the data when success will be in second string after the result
	 *
	 * @access	public
	 * @param   $codkey mixed and authentication string key to check api
	 */
	public function convertCurrency($extradata = NULL)
	{

		$this->load->model('Currency_m','dbcm');
		$this->load->library('Userlib');
		$this->load->library('form_validation');

		$user_id = $this->input->get_post('user_id', FALSE);
		$codkey = $this->input->get_post('codkey', FALSE);
		$currencyBase = $this->input->get_post('curbase', FALSE);
		$currencyDest = $this->input->get_post('curdest', FALSE);
		$currencyDate = $this->input->get_post('dateapi', FALSE);
		$currencyMont = $this->input->get_post('curmont', FALSE);

		$validfields = $this->form_validation->required($user_id);
		$validfields = preg_match('/^[a-zA-Z0-9_\.]{1,}+$/i', $user_id);
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

		$missdest = $this->form_validation->required($currencyDest);
		$validcurren = $this->form_validation->exact_length($currencyDest,3);
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

		$this->userlib->initialize($user_id);
		$this->userlib->getID();

		log_message('debug', __METHOD__ .' API already called, now try to retrieve the result from DB for :  '.print_r($currencyDate, TRUE));
		$user_preferences = $this->userlib->getUser();
		$cur_monedas_base = $this->userlib->getBaseCurrency();
		$cur_monedas_dest = $this->userlib->getDestCurrency();
		$currency_list_dbarraynow = array();
		$currency_list_dbarraypre = array();
		// ver si id y status es valido ejemplo $this->userlib->isActive(); solo edita si esta activo
		$active = $this->userlib->isActive();
		if($active)
		{
			$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored($currencyDest,$currencyDate,$currencyBase);
			$currency_list_dbarraypre = $this->dbcm->readCurrenciesTodayStored($cur_monedas_dest,NULL,$cur_monedas_base);
		}
		$result = 0;
		if(is_array($currency_list_dbarraypre))
		{
			if(count($currency_list_dbarraypre) > 0 );
				$result = 1;
		}
		if(is_array($currency_list_dbarraynow))
		{
			if(count($currency_list_dbarraynow) > 0 );
				$result = 1;
		}
		$data = array();
		$data['result'] = $result;
		$data['currency_mont'] = '30.90';
		$data['currenturl'] = $this->currenturl;
		log_message('debug', __METHOD__ .' saved? : ' .print_r($data,TRUE). ' from parameter: '.print_r($currencyDate, TRUE));
		$result = json_encode($data);
		echo $result;
		return $result;
	}

}
