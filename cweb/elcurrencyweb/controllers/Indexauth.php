<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indexauth extends CP_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index($indexerror = NULL)
	{
		$data = array();
		$message = 'Auth system prepared';
		if( !is_array($indexerror) AND $indexerror != NULL)
		{
		    if($indexerror == 'autherror')
			    $message = 'Error login or invalid credentials';
		    if($indexerror == 'authcheck')
			    $message = 'Invalid access or invalid credentials';
		    if($indexerror == 'logout')
			    $message = 'Session closed';
		    if($indexerror == 'logauth')
			    $message = 'Ready again to valid credentials';
		}
		$data['message'] = $message;
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$data['controllerlogin'] = 'Indexauth/auth/login';
		$data['userurl'] = $this->input->get_post('userurl');
		$this->load->view('header.php',$data);
		$this->load->view('login.php',$data);
		$this->load->view('footer.php',$data);
	}

	/**
	 * authenticator that uses action and user key credentials
	 * 
	 * @name: auth
	 * @param string $action logout|login
	 * @param string $username the user email or login name
	 * @param string $userclave the user password or user key api access
	 * @return
	 * 
	 */
	public function auth($action = 'logout', $username = NULL, $userclave = NULL)
	{
		$typeerror = 'nologin';

		if($username == NULL)
			$username = $this->input->post('username');
		if($userclave == NULL)
			$userclave = $this->input->post('userclave');

		if ( $action == 'login' )
		{
			$this->load->model('authmodel');
			$im_access = true;//$this->authmodel->authimap($username, $userclave);
			$rs_access = $this->authmodel->authtable($username, $userclave);

			if($im_access == FALSE)
				$typeerror = 'autherror';
			if($rs_access == FALSE)
				$typeerror = 'authcheck';
		}

		if ( $action == 'logauth' OR $action == 'logout' )
			$typeerror = $action;

		$data = array();
		if($rs_access != FALSE AND $im_access != FALSE)
		{
			$this->session->set_userdata('userdata', $rs_access);
			redirect('Home');
		}
		else
		{
			$this->session->sess_destroy();
			if($action == 'logout')
				redirect('Index');
			else
				header('location:'.site_url('/Indexauth/index/'.$typeerror));
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
