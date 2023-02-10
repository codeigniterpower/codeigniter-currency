<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * THIS CONTROLLER ONLY LOAD WHEN THE APPLICATION CALLS WITH ALREADY LOGGED IN SESSION
 * remmembered that each controller is a request calll in the web app
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Home extends CP_Controller {

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
		$this->load->view('header',$data);
		$this->load->view('menu',$data);
		$this->load->view('home',$data);
		// $this->load->view('footer.php',$data);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
