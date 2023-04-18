<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Indexauth extends YA_Controller {

	function __construct()
	{
		parent::__construct();
		$data['menu'] = $this->genmenu();
		$data['menusub'] = '';
		$this->data = $data;
	}

	/**
	 * index que muestra login para autenticacion, y verifica esta contra el modelo de datos
	 * este controlador no necesita verirficar la session ya que este solo muestra si entra o no
	 * 
	 * @name: index
	 * @param void
	 * @return void
	 */
	public function index($data = NULL)
	{
		$message = 'Auth system prepared';

		if(is_array($data))
		{
		    array_merge($this->data,$data);
		}
		else
		{
		    if($data == 'autherror')
			    $message = 'Error login or invalid credentials';
		    if($data == 'authcheck')
			    $message = 'Invalid access or invalid credentials';
		    if($data == 'logout')
			    $message = 'Session closed';
		    if($data == 'logauth')
			    $message = 'Auth prepared to valid credentials';
		    $data = $this->data;
		}

		$this->config->load('imap');
		$data['sitename'] = $this->config->item('imap_host');

		$data['message'] = $message;
		$this->load->view('header.php',$data);
		$this->load->view('inicion.php',$data);
		$this->load->view('footer.php',$data);
	}

	public function auth($action = 'logout', $username = NULL, $userclave = NULL)
	{
		$typeerror = 'logout';

		if($username == NULL)
			$username = $this->input->post('username');
		if($userclave == NULL)
			$userclave = $this->input->post('userclave');

		if ( $action == 'login' )
		{
			$this->load->model('authmodel');
			$im_access = $this->authmodel->authimap($username, $userclave);
			$rs_access = $this->authmodel->authtable($username, $userclave);
			if($im_access == FALSE)
				$typeerror = 'autherror';
			if($rs_access == FALSE)
				$typeerror = 'authcheck';
		}

		if ( $action == 'logauth' )
			$typeerror = 'logauth';

		$data = array();
		if($rs_access AND $im_access)
		{
			$this->session->set_userdata('userdata', $rs_access);
			redirect('Index/vistainterna');
		}
		else
		{
			$this->session->sess_destroy(); sleep(3);
			header('location:'.site_url('/Indexauth/index/'.$typeerror));
		}
	}

}

/* End of file Indexauth.php */
/* Location: ./application/controllers/Indexauth.php */
