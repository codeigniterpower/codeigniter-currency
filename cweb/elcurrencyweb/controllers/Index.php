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
		$this->data = $data;
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
		$data = $this->data;
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('indexview',$data);
		$this->load->view('footer',$data);
	}

	/**
	 * index que muestra vista con instrucciones, las instrucciones estan en la vista indexinput
	 * esta vista revisa si es sesion activa y la muestra, sino redirige a login.
	 * 
	 * @name: vistainicio
	 * @param void
	 * @return void
	 */
	public function vistainterna()
	{
		$this->checksession();
		$data = $this->data;
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('vista_home',$data);
		$this->load->view('footer',$data);
	}

	/**
	 * vistasalida que muestra vista con instrucciones, las instrucciones estan en la vista indexinput
	 * esta vista es publica por defecto, y no necesita revisarse por sesion activa
	 * 
	 * @name: vistasalida
	 * @param void
	 * @return void
	 */
	public function vistapublica()
	{
		$data = $this->data;
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('vista_publica',$data);
		$this->load->view('footer',$data);
	}

}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */
