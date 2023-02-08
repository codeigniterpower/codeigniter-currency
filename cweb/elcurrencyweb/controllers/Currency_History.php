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
	public function listcurrencies($id = NULL)
	{
		$data = array();
		$data['menu'] = $this->genmenu();

		$currency_list_dbarrayhis = array();
		$currency_list_dbarraycou = array();
		$this->load->model('Currency_m','dbcm');
		$parameters = array();
		// case 1 only count all the history for a specific date, first 100 rows, ordering by cod_tasa ascending
		$parameters['fecha'] = '20230207';
		$parameters['curDest'] = 'VES';
		$howmany = 100;
		$iniciar = 0;
		$ordercol = 'cod_tasa';
		$sorting = 'ASC';
		$countall = TRUE;
		$currency_list_dbarraycou = $this->dbcm->readCurrenciesHistStored($parameters,$howmany,$iniciar,$ordercol,$sorting,$countall);
		// case 2 get all the history for a specific date, first 100 rows, ordering by cod_tasa ascending
		$parameters['fecha'] = '20230207';
		$parameters['curDest'] = 'VES';
		$howmany = 100;
		$iniciar = 0;
		$ordercol = 'cod_tasa';
		$sorting = 'ASC';
		$countall = NULL;
		$currency_list_dbarrayhis = $this->dbcm->readCurrenciesHistStored($parameters,$howmany,$iniciar,$ordercol,$sorting,$countall);

		$totalcount = 0;
		if(is_array($currency_list_dbarrayhis))
		{
			$totalcount = count($currency_list_dbarrayhis);
		}
		if(is_array($currency_list_dbarraycou))
		{
			if(count($currency_list_dbarraycou))
				$totalcount = $currency_list_dbarraycou[0]['cod_tasa'];
		}

		$data['totalcount'] = $totalcount;
		$data['currency_list_dbarrayhis'] = $currency_list_dbarrayhis;
		$data['currenturl'] = $this->currenturl;

		$this->load->view('header.php',$data);
		$this->load->view('menu');
		$this->load->view('history',$data);

	}

	/**
	 * fix the format using, set number to decimal with two digits
	 *
	 * @access	public
	 * @param	none
	 * @return	boolean FALSE on errors
	 */
	public function _numerosgente($value, $row)
	{
		$formateado = number_format($row->mon_tasa_moneda, 2, ',', '.');
		return $formateado;
	}
}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
