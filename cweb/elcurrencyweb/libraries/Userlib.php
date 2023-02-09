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
	/** session active  */
	private $sessionflag;

	/** user   */
	private $user = array();


	public function __construct()
	{
        $this->CI =& get_instance();
    }
	// TODO init and document tthe lib
	public function initialize()
	{}

    /**
     * This is to work the user's session among other things related to the user
	 * name: User
	 * @author    Radioactive99 Angel Gonzalez
	 * @param array user_preferences
	 * @return
	 */
    public function keepUser($dataUser = NULL){
			if(count($dataUser)){
				$user = $dataUser[0];
				if(array_key_exists('user_id',$user)){
					$this->$user['user_id'] = $user['user_id'];
				}else{
					log_message('error', __CLASS__ .' missing key user_id' .  print_r($user,TRUE) );
					$this->$user['user_id'] = NULL;
				}
				if(array_key_exists('user_status',$user)){
					$this->$user['user_status'] = $user['user_status'];	
				}else{
					log_message('error', __CLASS__ .' missing key user_status' .  print_r($user,TRUE) );
					$this->$user['user_status'] = 'INACTIVO';	
				}
				if(array_key_exists('cur_monedas_base',$user)){
					$this->$user['cur_monedas_base'] = $user['cur_monedas_base'];	
				}else{
					log_message('error', __CLASS__ .' missing key cur_monedas_base' .  print_r($user,TRUE) );
					$this->$user['cur_monedas_base'] = 'USD';						
				}
				if(array_key_exists('cur_monedas_dest',$user)){
					$this->$user['cur_monedas_dest'] = $user['cur_monedas_dest'];	
				}else{
					log_message('error', __CLASS__ .' missing key cur_monedas_dest' .  print_r($user,TRUE) );
				}
				if(array_key_exists('sessionflag',$user)){
					$this->$user['sessionflag'] = $user['sessionflag'];	
				}else{
					log_message('error', __CLASS__ .' missing key sessionflag' .  print_r($user,TRUE) );
				}
				if(array_key_exists('sessionficha',$user)){
					$this->$user['sessionficha'] = $user['sessionficha'];	
				}else{
					log_message('error', __CLASS__ .' missing key sessionficha' .  print_r($user,TRUE) );
				}
			}else{
				log_message('error', __CLASS__ .' No is array' .  print_r($dataUser,TRUE) );				
			}
			return $user;
    }

	public function logout($dataUser = NULL){
	
	}
}