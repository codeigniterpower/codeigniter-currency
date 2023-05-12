<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * elcurrency Userlib Class for requestinig to apilayer using marketshare currency conversion
 *
 * @author      Radioactive99 Angel Gonzalez
 * @copyright Copyright (c) 2023
 * @version ab - 1.0
 */
class Userlib
{
	protected $CI; // CodeIgniter object

	/** session origin  */
	private $sessionficha;
	/** session last  */
	private $sessionflag;
	/** session user  */
	private $sessionuser;

	/** user data but as array  */
	private $user = NULL;

	/** user status as string */
	private $status = 'INACTIVO';
	/** user status as boolean  */
	private $active = FALSE;
	/** user id or the email  */
	private $user_id = NULL;
	/** user full name and second name  */
	private $usernape = 'invalid';
	/** user name or the email  */
	private $username = 'invalid';
	/** user currency monedas base  */
	private $cur_monedas_base = FALSE;
	/** user currency monedas dest  */
	private $cur_monedas_dest = FALSE;
	/** user extra  */
	private $userextra = FALSE;

	/** flag to get status of the class user initialize  */
	private $usersetup = FALSE;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	// TODO init and document tthe lib
	public function initialize($user_id = NULL)
	{
		if(is_null($user_id) !== TRUE and empty($user_id) !== TRUE )
		{
			if($this->user_id != $user_id)
			{
				$this->user_id = $user_id;
				$this->usersetup = FALSE;
			}
		}
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
	}

	/**
	 * get status as string of user, same as if get if user is active or not
	 * 
	 * @return string $status 'ACTIVE' OR 'INACTIVE'
	 */
	public function getStatus()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->status;
	}

	/**
	 * get status as FLAG of user, same as if get if user is active or not
	 * 
	 * @return bool $status TRUE or FALSE
	 */
	public function isActive()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->active;
	}

	/**
	 * get username as string of user
	 * 
	 * @return string $username
	 */
	public function getName()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->username;
	}

	/**
	 * get user id as string of user, same as user name but using mail
	 * 
	 * @return string $user_id
	 */
	public function getID()
	{
		return $this->user_id;
	}

	/**
	 * get user base currencies as comma separated strings
	 * 
	 * @return string $cur_monedas_base
	 */
	public function getBaseCurrency()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->cur_monedas_base;
	}

	/**
	 * get user rate currencies as comma separated strings
	 * 
	 * @return string $cur_monedas_dest
	 */
	public function getDestCurrency()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->cur_monedas_dest;
	}


	/**
	 * get user session flag that means last session mark for this user
	 * 
	 * @return string $sessionflag YYYYMMDDHHmmss.userid.ip
	 */
	public function getSessionFlag()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->sessionflag;
	}

	/**
	 * get user session ficha that means first session in system for this user
	 * 
	 * @return string $sessionficha YYYYMMDDHHmmss.creator.ip
	 */
	public function getSessionFicha()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->sessionficha;
	}

	/**
	 * get user session at request that means current running session in system for this user
	 * 
	 * @return string $sessionuser YYYYMMDDHHmmss.userid.ip.XXXXXX
	 */
	public function getSessionUser()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->sessionuser;
	}

	/**
	 * save user running session in system for this user, into the database
	 * 
	 * @return string $sessionuser YYYYMMDDHHmmss.userid.ip.XXXXXX
	 */
	public function setSessionUser()
	{
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);

		$user_email = $this->user_id;
		log_message('info', ' setting data to DB for' . $user_email);
		$this->CI->load->model('Usuario_m');
		$userarray['username'] = $this->username ;
		$userarray['user_id'] = $this->user_id ;
		$userarray['status'] = $this->status ;
		$userarray['active'] = $this->active ;
		$userarray['cur_monedas_base'] = $this->cur_monedas_base ;
		$userarray['cur_monedas_dest'] = $this->cur_monedas_dest ;
		$userarray['sessionficha'] = $this->sessionficha ;
		$userarray['sessionflag'] = $this->sessionflag ;
		$userarray['sessionuser'] = $this->sessionuser ;
		$userarray['userextra'] = $this->userextra ;
		$this->user = $userarray;
		$this->usersetup = TRUE;
		return $this->sessionuser;
	}

	/**
	 * This configure the data for user fromthe panel preferences if and admin invokes
	 * name: getUser
	 * @author    Radioactive99 Angel Gonzalez
	 * @param string user_id
	 * @return array user_preferences
	 */
	public function getUser($user_id = NULL)
	{
		if(is_null($user_id) !== TRUE and empty($user_id) !== TRUE )
		{
			if($this->user_id != $user_id)
			{
				$this->user_id = $user_id;
				$this->usersetup = FALSE;
			}
		}
		if(!$this->usersetup)
			$this->getUserDataAndSetup($this->user_id);
		return $this->user;
	}

	/**
	 * This check that the string does not being empty, null, or do not contains invalid chars
	 * name: _checkinputsuser
	 * @author    mckaygerhard
	 * @param string user_id
	 * @return array user_preferences
	 */
	private function _checkinputsuser($variable)
	{
		return preg_match('/^[0-9A-Za-z\-_]+$/', $variable);
	}

	/**
	 * setup and get all the user info into the class
	 *
	 * @author  mckaygerhard PICCORO Lenz McKAY
	 * @access	public
	 * @param	string  $user_email : Opcional
	 * @return	string  tabla HTML con la info formateada
	 */
	function getUserDataAndSetup($user_email = null) 
	{

		if( $this->_checkinputsuser($user_email) !== FALSE ) $this->user_id = $user_email;

		$user_email = $this->user_id;
		log_message('info', ' getting data from DB for' . $user_email);
		$this->CI->load->model('Usuario_m');
		$dbarray = $this->CI->Usuario_m->getUserData($user_email);
		if( !is_array($dbarray) OR $dbarray == FALSE )
		{
			log_message('error', ' DB problem.. check settings');
			return FALSE;
		}
		if( count($dbarray) < 1 OR count($dbarray) > 1 )
		{
			log_message('error', ' DB data.. seems hacked user settings');
			return FALSE;
		}

		$user_data = $dbarray[0];
		$this->usernape = str_replace('_',' ',$user_data['user_id']);
		$this->user_id = $user_data['user_id'];
		$this->username = $user_data['user_id'];
		$this->status = $user_data['user_status'];
		if($this->status == 'ACTIVO') $this->active = TRUE; else $this->active = FALSE;
			log_message('error', ' Dagtivo'.print_r($this->active,TRUE));
		$this->cur_monedas_base = $user_data['cur_monedas_base'];
		$this->cur_monedas_dest = $user_data['cur_monedas_dest'];
		$this->sessionficha = $user_data['sessionficha'];
		$this->sessionflag = $user_data['sessionflag'];
		
		//log_message('info', ' getting session from DB for' . $user_email);
		//$dbarray = $this->CI->Usuario_m->getUserSession($user_email);
		//if( !is_array($dbarray) OR $user_data === FALSE )
		//{
			//log_message('error', ' DB problem.. check user session');
			//return FALSE;
		//}
		//if( count($dbarray) == 0 )
		//{
			//log_message('info', ' DB data.. seems no session for this user');
			//$this->sessionuser = FALSE;
			//$this->active = FALSE;
			//$this->userextra = FALSE;
		//}
		//else
		//{
			//$user_data = $dbarray[0];
			//$this->sessionuser = $user_data['sessionuser'];
			//$this->userextra = $user_data['user_extra'];
		//}

		$userarray['username'] = $this->username ;
		$userarray['user_id'] = $this->user_id ;
		$userarray['status'] = $this->status ;
		$userarray['active'] = $this->active ;
		$userarray['cur_monedas_base'] = $this->cur_monedas_base ;
		$userarray['cur_monedas_dest'] = $this->cur_monedas_dest ;
		$userarray['sessionficha'] = $this->sessionficha ;
		$userarray['sessionflag'] = $this->sessionflag ;
		$userarray['sessionuser'] = $this->sessionuser ;
		$userarray['userextra'] = $this->userextra ;
		$this->user = $userarray;
		$this->usersetup = TRUE;
		return $userarray;
	}
}
