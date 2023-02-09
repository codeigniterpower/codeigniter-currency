<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * elcurrency Currencylib Class for requestinig to apilayer using marketshare currency conversion
 *
 * @author     @mckaygerhard PICCORO Lenz McKAY
 * @copyright Copyright (c) 2023
 * @version ab - 1.0.1
 */
class Currencylib
{

	/** internal object from framewrok*/
	private $CI;

	/** result of conversion when invoking the function */
	private $converted;

	/** the desired history point of the currency to convert */
	private $dateCurrency;

	/** 3 letters base currency to compared */
	private $baseCurrency;

	/** 3 letters array or comma separated currency desired to convert */
	private $destiCurrency;

	/** if you desired to convert and amount event just the unit of the currency */
	private $amountCurrency;

	/** apy key of the apilayer, will only work with an valid one */
	private $currencyApiKey;

	/** urs to invoke, mostly not necesary to change */
	private $currencyApiUrl;

	/**
	 * @author      PICCORO Lenz McKAY
	 * name: default constructor
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('currencylib', true);
		$this->dateCurrency = date('Y-m-d');
		$this->amountCurrency = 1;

		$this->currencyApiKey = $this->CI->config->item('currency_api_key', 'currencylib');
		log_message('error', __CLASS__ .' Api key configured ' .$this->currencyApiKey);
		$this->currencyApiUrl = $this->CI->config->item('currency_api_url', 'currencylib');
		log_message('error', __CLASS__ .' Api key URL request '.$this->currencyApiUrl );
	}

	/**
	 * initialize the API using the config stored values from the currencylib config file
	 * @author      PICCORO Lenz McKAY
	 */ 
	public function initialize()
	{
		$this->currencyApiKey = $this->CI->config->item('currency_api_key', 'currencylib');
		log_message('error', __CLASS__ .' Api key configured ' .$this->currencyApiKey);
		$this->currencyApiUrl = $this->CI->config->item('currency_api_url', 'currencylib');
		log_message('error', __CLASS__ .' Api key URL request '.$this->currencyApiUrl );
	}

	/**
	 * this allow to conver and amoutn of one corrency to other one, 
	 * means this is only to get only one currency but with a specific multiplier
	 * 
	 * name: getCurrencys
	 * @author      PICCORO Lenz McKAY
	 * @param string baseCurrency 3 letter code to convert, array or comma separated
	 * @param float multiplicer of currency
	 * @param string dateCurrency YYYY-MM-DD, if null lasted
	 * @return
	 */
	public function getOneCurrencyByApi($baseCurrency = NULL, $destiCurrency = NULL, $amountCurrency = NULL)
	{
		$this->amountCurrency = $amountCurrency;
		$this->getAllCurrencyByApi($baseCurrency, $destiCurrency, NULL);
		return $this->converted;
	}

	/**
	 * this retrieve all the currency by a date or at current date, 
	 * you can pass specific currencies in 3 letter form code and 
	 * optionaly specified a base currency (by default USD )
	 * 
	 * name: getCurrencyByApi
	 * @author      PICCORO Lenz McKAY
	 * @param string baseCurrency 3 letter code to convert, array or comma separated
	 * @param string destiCurrency 3 letter code base to compare
	 * @param string dateCurrency YYYY-MM-DD, if null lasted
	 * @return
	 */
	public function getAllCurrencyByApi($baseCurrency = NULL, $destiCurrency = NULL, $dateCurrency = NULL)
	{
		$this->baseCurrency = $baseCurrency;
		$this->destiCurrency = $destiCurrency;
		$this->dateCurrency = $dateCurrency;

		$this->requestCurrency();
		return $this->converted;

	}

	/**
	 * name: requestCurrency
	 * @author      PICCORO Lenz McKAY
	 * @return mixed array with the resquested ones based on conCurrency/getCurrencys parameters
	 */
	private function requestCurrency()
	{

		if (NULL == $this->currencyApiKey) {
			log_message('error', __CLASS__ .' missing apy key' );
			return array('ERR'=>0);
		}
		if (NULL == $this->amountCurrency) {
			log_message('debug', __CLASS__ .' amount of currency error, set to 1 before convert' );
			$this->amountCurrency = 1;
		}
		if (NULL == $this->dateCurrency) {
			log_message('error', __CLASS__ .' missing date currency request, set to current day' );
			$this->dateCurrency = date('Y-m-d');
		}
		if (NULL == $this->baseCurrency) {
			log_message('error', __CLASS__ .' missing base currency request, set to USD' );
			$this->baseCurrency = 'USD';
		}
		if (NULL == $this->destiCurrency) {
			log_message('error', __CLASS__ .' missing destiny currency request, set to all' );
			$this->destiCurrency = '';
		}

		$urlrequested = $this->currencyApiUrl."/".$this->dateCurrency."?symbols=".$this->destiCurrency."&base=".$this->baseCurrency;

		log_message('debug', __CLASS__ .' URL: '.print_r($urlrequested,TRUE) );
		$this->converted = 0;

		$curl = curl_init();
		// TODO : use socket and async calls .. this take too much time and its not good for request sync
		curl_setopt_array($curl, array(
			CURLOPT_URL => $urlrequested,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: text/plain",
				"apikey: ".$this->currencyApiKey
			),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET"
		));
		log_message('debug', __CLASS__ .':curl request: '. print_r($curl,TRUE) );

		$response = curl_exec($curl);
		$conversion = json_decode($response, true);
		$resulterr = FALSE;

		if (! isset($response)) 
		{
			$resulterr = array('ERR'=>1);
			log_message('debug', __CLASS__ .':json ERROR response: '. print_r($resulterr,TRUE) .' '. print_r($urlrequested,TRUE) );
		}
		else if( !is_array($conversion) )
		{
			$resulterr = array('ERR'=>2);
			log_message('debug', __CLASS__ .':json ERROR validation: '. print_r($resulterr,TRUE) .' '. print_r($response,TRUE) );
		}
		else if(! array_key_exists('rates', $conversion))
		{
			$resulterr = array('ERR'=>3);
			log_message('debug', __CLASS__ .':json ERROR decode: '. print_r($resulterr,TRUE) .' '. print_r($response,TRUE));
		}
		curl_close($curl);

		if( $resulterr !== FALSE )
		{
			$this->converted = array(0=>$resulterr);
			return $resulterr;
		}

		$rates = $conversion['rates'];

		foreach($rates as $destiCurrency => $valueCurrency)
		{
			$valueCurrency = floatval($valueCurrency)*floatval($this->amountCurrency);
			$rates[$destiCurrency] = $valueCurrency;
		}

		$this->converted = $rates;

		$currency_list_apiarray = array();
		foreach( $this->converted as $keyc => $valc)
		{
			$currency_list_apiarray[] = array('moneda' => $keyc, 'mon_tasa_moneda' => $valc);
		}

		log_message('debug', __CLASS__ .': converted rates: '. print_r($currency_list_apiarray,TRUE) );
		$this->converted = $currency_list_apiarray;
		return $this->converted;

	}

}
