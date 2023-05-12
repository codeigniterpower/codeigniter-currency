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
		$this->checksession();
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
		$this->listTodayCurrencies();
	}

	/**
	 * this controler is the URI call to set the currency and stored into DB,
	 * it also has a button or trick to request a call to api and get lasted currency from api
	 * mean can also have a form to request a specific currency conversion
	 *
	 * @access	public
	 */
	public function listTodayCurrencies()
	{
		// load user preferences, lib must be init after loading
		$this->load->library('Userlib');
		$this->userlib->initialize('gonzalez_angel');
		//$this->userlib->initialize('lenz_gerardo');

		$this->userlib->getID();
		$this->load->model('Currency_m','dbcm');
		$user_preferences = $this->userlib->getUser();
		$cur_monedas_base = $this->userlib->getBaseCurrency();
		$cur_monedas_dest = $this->userlib->getDestCurrency();
		// tambien puedes consultart aparte de $this->userlib->isActive(); tambien $this->userlib->getStatus();
		$currency_list_dbarraynow = array();
		$currency_list_dbarraypre = array();
		// ver si id y status es valido ejemplo $this->userlib->isActive(); solo edita si esta activo
		$data['active'] = $active = $this->userlib->isActive();
		$currency_list_dbarraynow = $this->dbcm->readCurrenciesTodayStored();
		if($active)
		{
			$currency_list_dbarraypre = $this->dbcm->readCurrenciesTodayStored($cur_monedas_dest,NULL,$cur_monedas_base);
		}
		$buttonicon = '<i class="bi bi-x-octagon-fill" style="font-size: 30px;"></i>';
		if(is_array($currency_list_dbarraypre))
		{
			if(count($currency_list_dbarraypre) > 0 );
				$buttonicon = '<i class="bi bi-currency-exchange" style="font-size: 30px;"></i>';
		}
		$data['buttonicon'] = $buttonicon;
		$data['user_preferences'] = $user_preferences;
		$data['currency_list_dbarraynow'] = $currency_list_dbarraynow;
		$data['currency_list_dbarraypre'] = $currency_list_dbarraypre;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header',$data);
		$this->load->view('menu',$data);
		$this->load->view('currency',$data);
		$this->load->view('footer_internal',$data);
	}

}

/* End of file Currency_Manager.php */
/* Location: ./application/controllers/Currency_Manager.php */
