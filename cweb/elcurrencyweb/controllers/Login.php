<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login Controller Class de inicio login/logout y info user
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2018, 2019
 * @version ab - 1.0
 */
class Login extends CP_Controller {

	/**
	 * name: default constructor
	 * @param
	 * @return
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','html'));
		$this->output->enable_profiler(ENVIRONMENT !== 'production');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->library('form_validation');
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
		$this->login_form();
	}

	/**
	 * login action and set to home
	 * 
	 * @name: home
	 * @param void
	 * @return void
	 */
	public function home($idcheck = NULL)
	{
		$usermail = $this->input->post('usermail');
		$userpass = $this->input->post('userpass');
		$userurl = $this->input->post('userurl');
		$useraddr = $this->input->ip_address();
		$validfields = $this->form_validation->required($usermail);
		$validfields = $this->form_validation->required($userpass);
		$usercurr = $this->session->userdata('username');
		$username = $usermail;
		if( $username != $usercurr OR $validfields == FALSE)
		{
			$this->session->sess_destroy();
			if( $validfields == FALSE )
			{
				log_message('debug', 'invalid inputs for login '.var_export($usermail,TRUE).':'.var_export($userpass,TRUE) );
				redirect('/Index','location');
				return;
			}
		}
		$this->session->sess_regenerate();
		$usuario['userlogin'] = 1;
		$usuario['usermail'] = $usermail;
		$usuario['username'] = $username;
		$usuario['userpass'] = $userpass;
		$usuario['useraddr'] = $useraddr;
		$usuario['userseid'] = $this->session->userdata('session_id');
		$this->session->set_userdata($usuario);
		log_message('debug', 'Usuario session active');
		//redirect('/Home','refresh'); kills the session unfortunatelly
		$data = array();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
        $this->load->view('menu');
		$this->load->view('home',$data);
		$this->load->view('footer',$data);
	}

	/**
	 * login form
	 * 
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function login_form()
	{
		$data = array();
		$data['menu'] = $this->genmenu();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$data['controllerlogin'] = 'Login/home';
		$data['userurl'] = $this->input->get_post('userurl');
		$this->load->view('header.php',$data);
		$this->load->view('login',$data);
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
		$usermail = $this->input->post('usermail');
		$userpass = $this->input->post('userpass');
		$userurl = $this->input->post('userurl');
		$useraddr = $this->input->ip_address();
		$validfields = FALSE;
		$usercurr = $this->session->userdata('username');
		$username = $usermail;
		if( $username != $usercurr OR $validfields == FALSE)
		{
			$this->session->sess_destroy();
			if( $validfields == FALSE )
			{
				log_message('debug', 'erasing login credentiasl and logout '.var_export($usermail,TRUE).':'.var_export($userpass,TRUE) );
				$usermail = NULL;
				$userpass = NULL;
			}
		}
		$this->session->sess_regenerate();
		$usuario['userlogin'] = 0;
		$usuario['usermail'] = $usermail;
		$usuario['username'] = $username;
		$usuario['userpass'] = $userpass;
		$usuario['useraddr'] = $useraddr;
		$usuario['userseid'] = $this->session->userdata('session_id');
		$this->session->set_userdata($usuario);
		log_message('debug', 'Usuario session active');
		//redirect('/Home','refresh'); kills the session unfortunatelly
		$data = array();
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		$this->load->view('indexview',$data);
		$this->load->view('footer',$data);
		redirect('/','location');
	}


}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
