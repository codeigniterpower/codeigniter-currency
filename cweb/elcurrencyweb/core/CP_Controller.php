<?php

/**
 * CIP elsistema Application Controller Class, super clase que todo controlador hereda para funciones comunes
 *
 * @author    PICCORO lenz McKAY <mckaygerhard>
 * @copyright Copyright (c) 2016, 2022
 * @version ac - 1.1
 */
class CP_Controller extends CI_Controller
{
	/** inicia y en checku se asigna a la url pedida por get/post userurl */
	public $userurl = NULL;
	/** es la ruta actual de esta raiz del sistema */
	public $currenturl = NULL;
	/** es el nombre del inx indice de el url raiz (nombre del controler) */
	public $currentctr = NULL;
	/** es el nombre del sub indice de el url raiz (metodo del controler) */
	public $currentinx = NULL;
	/** si currenturl esta en un modulo, este es el nombre del modulo  */
	public $currentmod = NULL;
	/** collecion o arreglo de todos los elementos de el url RAIZ no del URL completo */
	public $arraymurls = NULL;
	/**  permiso cargado en el controler en cda request */
	public $permite = FALSE;
	/**  nombre de usuario tomado de la session activa */
	public $username = FALSE;
	/** mecanismo barato para ver el controller que se denego desde la herencia*/
	public $modulo = NULL;

	/**
	 * establece librerias de sesion y permisos asi como modulo si se especifica
	 * 
	 * @param string $modulo : Que grupo de controladores se manejan
	 */
	public function __construct($modulo = NULL)
	{
		parent::__construct();

		$this->load->helper(array('form', 'url','html'));
		$this->load->library(array('table','session'));

		$this->currentctr = $this->router->fetch_class();
		$this->currentinx = $this->router->fetch_method();

		$this->currenturl = $this->uri->uri_string();
		$this->arraymurls = explode("/", $this->currenturl );
		$this->currentmod = $this->arraymurls[0];

		if($modulo !== NULL AND trim($modulo) !== '')
			$this->module = $modulo;

		if(ENVIRONMENT !== 'production'){
			$this->output->set_header("HTTP/1.1 200 OK");
			$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		}

		if(ENVIRONMENT !== 'production')
			$this->output->enable_profiler(TRUE);

	}

	/** revision de session, si invalidad redirige a login */
	public function checku()
	{
		$this->userurl = $this->input->get_post('userurl');
		$this->currenturl = $this->uri->uri_string(); //$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4);

		$userurl = str_replace('/','',$this->userurl);
		$redirurl = $this->currenturl;
		if( $userurl != '')
			$redirurl = $this->userurl;

		//$username = $_SESSION['username'];

		//$this->username = $username;
	}

	/* 
	 * la logica de menu esta descrita en docs/desarrollo-gencontroler-y-menu.md
	 * name: genmenu 
	 * @description genera un menu de enlaces plano usando `getcontrollers` segun los nombres de controladores del directorio
	 * @param string $moduledir nombre del directorio de controllers especifico sino directorios de modulos
	 * @return string html table con los nombres de archivos de controladores o los directorios si no se especifica modulo dir
	 */
	public function genmenu($modulename = NULL, $menuclasscss = NULL)
	{
		$currentctr = $this->currentctr;
		$currentinx = $this->currentinx;
		$currenturl = $this->currenturl;
		$arraymodules = $this->arraymurls;        
		$arraycontrls = $this->getcontrollers($modulename);

		$user_loged = $this->session->userdata('username');
		$user_email = $this->session->userdata('useraddress');

		$menumainstring = '';

		if(($modulename == NULL OR $modulename == FALSE) AND $currentinx !== '')
		{
			$menuitemactive = '';
			$menuclasssubdi = '';
			$menumainstring = '';

/*			if( $user_email == NULL OR $user_loged == FALSE )
			{
				$menumainstring .= '</div>';
				return $menumainstring;
			}
			else
*/			{
//				$menumainstring .= ' '.anchor('/',ucfirst(SYSDIR),'class="active" ');
				$menumainstring .= anchor('',' ');
				$modulename = $arraymodules[0];
				foreach($arraycontrls as $menuidex=>$menulink)
				{
					$menuitemactive = '';
					$findname = '/'.$modulename.'/';
					$menuname = preg_replace($findname, '', $menulink, 1);
					$menuclic = $menuname;
					$menuname = stristr($menuname,'index');
					$menuname = str_replace('index','',$menuname);
					$menuname = str_replace('Index','',$menuname);
					$menuname = str_replace('_', ' ', $menuname);
					$menuname = str_replace('m', '', $menuname);
					$menuname = ucfirst($menuname);
					$menuname = ucwords($menuname);
					$menulink = strtolower($menulink);
					if(stripos($menulink,'/')>2)
					{
						if(stripos($menuclic,$modulename)>1)
							$menuitemactive = 'active';
						$menumainstring .= ' '.anchor($menulink,ucfirst($menuname),'class=" '.$menuitemactive.' " ');
					}
				}
//				$menumainstring .= ' '.anchor('indexlogin/salirlogin','Salir','class="" ');
			}
		}
		else
		{
			$menuclasssubdi = '';
			foreach($arraycontrls as $menuidex=>$menulink)
			{
				$menuitemactive = '';
				if(stripos($menulink,$currentctr)>1)
					$menuitemactive = 'active';
				$findname = '/'.$modulename.'/';
				$menuname = preg_replace($findname, '', $menulink, 1);
				$menuname = str_replace('/','',$menuname);
				$menuname = ucfirst($menuname);
				$menuname = str_replace('_', ' ', $menuname);
				$menuname = ucwords($menuname);
				$menulink = strtolower($menulink);
				$menumainstring .= ' '.anchor($menulink,$menuname,'class=" '.$menuclasscss .' '. $menuitemactive.' " ').' ';
			}
		}
		$menumainstring .= '</div>';
		return $menumainstring;
 
	}

	/* 
	 * esta logica esta descrita en docs/desarrollo-gencontroler-y-menu.md
	 * name: getcontrollers obtiene nombre de controladores o nombre de directorios de controladores
	 * @param string $moduledir nombre del directorio de controllers especifico sino directorios de modulos
	 * @return array con los nombres de archivos de controladores o los directorios si no se especifica modulo dir
	 */
	public function getcontrollers($moduledir = NULL)
	{
		if($moduledir == NULL)
			$moduledir = '';
		$controllers = array();
		$moduledir = str_replace(' ','',$moduledir);
		// Scan files in the /application/controllers{moduledir} directory
		$this->load->helper('file');
			$files = get_dir_file_info(APPPATH.'controllers/'.$moduledir, TRUE);
		if(!is_array($files) OR count($files)<1)
			$files = get_dir_file_info(APPPATH.'controllers/', TRUE);
		foreach(array_keys($files) as $file)
		{
			if( strpos($file,'htm') !== FALSE)
				continue;
			$name = $moduledir.'/'.str_replace('.php', '', $file);
			$controllers[] = $name;
		}
		return $controllers;
	}

	/** permite repintar sin llamar tanto o escribir tanto, automaticamente carga header y footer */
	public function render($view, $data = NULL) 
	{
		if( !isset($data['currenturl']) )
			$data['currenturl'] = $this->currenturl;
		if( !isset($data['userurl']) )
			$data['userurl'] = $this->userurl;
		$this->seccion = uri_string();
		$data['menu'] = $this->genmenu();
		$data['seccion'] = $this->seccion;
		$data['currentctr'] = $this->currentctr;
		$data['currentinx'] = $this->currentinx;
		$data['currenturl'] = $this->currenturl;
		$this->load->view('header',$data);
		if(!is_array($view) )
		{
			if($view != '' OR $view != NULL)
				$this->load->view($view, $data);
		}
		else
		{
			foreach($view as $vistas=>$vistacargar)
				$this->load->view($vistacargar, $data);
		}
		$this->load->view('footer',$data);
	}

}

