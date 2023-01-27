<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * home Controller Class presentation for user login or non login, just put information depending of the sesion valitadion
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
		$this->load->view('header.php',$data);
		$this->load->view('indexview',$data);
		$this->load->view('footer.php',$data);
    }

}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
