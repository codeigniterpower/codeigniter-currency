<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * login Controller Class de inicio login/logout y info user
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Login extends CP_Controller {

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
     * index default action
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
		$this->load->view('indexlogin',$data);
		$this->load->view('footer.php',$data);
    }

    /**
     * login action
     * 
     * @name: index
     * @param void
     * @return void
     */
    public function login()
    {
        $data = array();
		$data['menu'] = $this->genmenu();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header.php',$data);
		$this->load->view('indexlogin',$data);
		$this->load->view('footer.php',$data);
    }

    /**
     * logout action
     * 
     * @name: index
     * @param void
     * @return void
     */
    public function logout()
    {
        $data = array();
		$data['menu'] = $this->genmenu();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header.php',$data);
		$this->load->view('indexlogin',$data);
		$this->load->view('footer.php',$data);
    }


}

/* End of file currency_manager.php */
/* Location: ./application/controllers/welcome.php */
