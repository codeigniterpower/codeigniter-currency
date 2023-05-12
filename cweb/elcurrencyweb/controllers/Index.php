<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * THIS CONTROLLER ONLY LOAD WHEN THE APPLICATION CALLS WITHOUT ENTRY POINT OR SPECIFIC ROUTING
 * remmembered that each controller is a request calll in the web app
 * 
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Index extends CP_Controller {

	/**
	 * name: desconocido
	 * @param
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
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
		$data = array();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('indexview',$data);
		$this->load->view('footer',$data);
	}


}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */
