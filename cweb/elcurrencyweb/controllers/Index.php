<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * elyanero Controller Class de inicio login/logout y info user
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
	$this->load->helper(array('form', 'url','html'));
	$this->output->enable_profiler(ENVIRONMENT !== 'production');

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
		$data['menu'] = $this->genmenu();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header.php',$data);
		$this->load->view('indexinput',$data);
		$this->load->view('footer.php',$data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
