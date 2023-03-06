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
		/*
		// THOSE ARE EXAMPLES TO TUNE THE HISTORY VIEW
		$parameters = array();
		// case 1 only count all the history for a specific date, first 100 rows, ordering by cod_tasa ascending
		$parameters['fecha'] = '20230207';
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
		*/
		$currency_list_dbarrayhis = $this->dbcm->readCurrenciesHistStored();
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
		/* 
		 // GROCERYCRUP ONLY dont touch, only work for mysql and will render the hole view
		$this->load->library('Grocery_CRUD');
		$this->load->database('elcurrencydb');
		$crud = new grocery_CRUD();
		$crud->set_theme('bootstrap'); // flexigrid tiene bugs en varias cosas
		$crud->set_table('cur_tasas_moneda');
		$crud->set_primary_key('cod_tasa');
		$crud->columns('cod_tasa','cod_moneda_base','cod_moneda_destino','mon_tasa_moneda','sessionficha','sessionflag');
		$crud->display_as('cod_tasa','Codigo+Hora')
			 ->display_as('cod_moneda_base','Base')
			 ->display_as('cod_moneda_destino','Convertida')
			 ->display_as('mon_tasa_moneda','Vale')
			 ->display_as('sessionficha','Modificada')
			 ->display_as('sessionflag','Creada');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_delete();
		$crud->callback_column('mon_tasa_moneda',array($this,'_numerosgente'));
		$output = $crud->render();
		$data['output'] = $output->output;
		$data['css_files'] = $output->css_files;
		$data['js_files'] = $output->js_files;
		*/
		$this->load->view('header.php',$data);
		$this->load->view('menu',$data);
		$this->load->view('history',$data);
		// $this->load->view('footer',$data);
		$this->load->view('footer_internal',$data);


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

/* End of file Currency_History.php */
/* Location: ./application/controllers/Currency_History.php */
