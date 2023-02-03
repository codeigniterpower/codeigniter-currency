<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Currency_History is the URI controller that will show all the rates stored in DB, 
 * means that can be used to check a currency in the history.. usefull to older rate convertions
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Currency_History extends CP_Controller {

	/**
	 * name: __construct
	 */
	function __construct()
	{
		parent::__construct();
	$this->load->helper(array('form', 'url','html'));
	$this->output->enable_profiler(ENVIRONMENT !== 'production');

	}

	/**
	 * index entry point
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
	 * list currency and also the last retrieve from api
	 * this controller will show the views for the history of stored currency since app installed
	 * basically wil show a table of data of the currency on the DB, 
	 * will request agains the DB and also the API, so the key api must be configured.
	 *
	 * @access	public
	 * @param	none
	 * @return	boolean FALSE on errors
	 */
	public function listcurrencies()
	{
		$data = array();
		$data['menu'] = $this->genmenu();

		$currency_list_dbarrayhis = array();
		$this->load->model('Currency_m','dbcm');
		$currency_list_dbarrayhis = $this->dbcm->readCurrenciesHistStored();

// how to call the models
//		$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored('VES', NULL, 'USD'); // get VES bolivares currencies on assumed date today but using base USD dollar
//		$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored('VES','20230201'); // get VES bolivares currencies fro the give date string, YYYYMMDDHH+XXXX the last X are a fouth digit id
//		$currency_list_dbarray = $this->dbcm->readCurrenciesTodayStored(NULL,'20230201'); // get all the currencies fro the give date string, YYYYMMDDHH+XXXX the last X are a fouth digit id
//		$currency_list_dbarray = $this->dbcm->getTasas(array('fecha_tasa'=>'20230201104302')); // againt table retrieve all the columns get only the currencies fro the give date string, YYYYMMDDHH+XXXX the last X are a fouth digit id

		$data['currency_list_dbarrayhis'] = $currency_list_dbarrayhis;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header.php',$data);
		$this->load->view('menu');
		$this->load->view('history',$data);
	}

	public function updateCurrenci($id = NULL)
	{
		
	}
}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
