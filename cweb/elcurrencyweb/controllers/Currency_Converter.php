<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * THIS CONTROLLER ONLY LOAD WHEN THE APPLICATION CALLS AND MUST USE OUR API CALLS
 * remmembered that each controller is a request calll in the web app
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Currency_Converter extends CP_Controller {

	/**
	 * name: desconocido
	 * @param
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','html'));
		$this->output->enable_profiler(ENVIRONMENT !== 'production');

	}

	/**
	 * index that shows the presentation, or login
	 *
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function index()
	{
		$data = array();
		$data['menu'] = $this->genmenu();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->model('Currency_m','dbcm');
		$cod_currency_base_array = $this->dbcm->readCurrencyNames();
		$exx = array('840'=>'VES','971'=>'USD');
		$data['cod_base_currency_array'] = $exx;
		$data['cod_base_currency'] = 'VES';
		$this->load->view('header',$data);
		$this->load->view('menu',$data);
		$this->load->view('converter',$data);
		$this->load->view('footer',$data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
