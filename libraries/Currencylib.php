<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * elcurrency Currencylib Class for requestinig to apilayer using marketshare currency conversion
 *
 * @author      PICCORO Lenz McKAY
 * @copyright Copyright (c) 2023
 * @version ab - 1.0
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
	 * name: descondefault constructor
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->load('currencylib', true);
		$this->dateCurrency = date('Y-m-d');
		$this->amountCurrency = 1;
		$this->currencyApiKey = $this->CI->config->item('currency_api_key', 'currencylib');
		$this->currencyApiUrl = $this->CI->config->item('currency_api_url', 'currencylib');
	}

	// TODO init and document tthe lib
	public function initialize()
	{
		// TODO init the amount, destino, base and date using array parameters
	}

	/**
	 * name: getCurrencys
	 * @author      PICCORO Lenz McKAY
	 * @param string baseCurrency 3 letter code to convert, array or comma separated
	 * @param float multiplicer of currency
	 * @param string dateCurrency YYYY-MM-DD, if null lasted
	 * @return
	 */
	public function getCurrencys($baseCurrency = NULL, $amountCurrency = NULL, $dateCurrency = NULL)
	{
		$this->amountCurrency = $amountCurrency;
		$this->conCurrency($baseCurrency, NULL, $dateCurrency);
		return $this->converted;
	}

	/**
	 * name: conCurrency
	 * @author      PICCORO Lenz McKAY
	 * @param string baseCurrency 3 letter code to convert, array or comma separated
	 * @param string destiCurrency 3 letter code base to compare
	 * @param string dateCurrency YYYY-MM-DD, if null lasted
	 * @return
	 */
	public function conCurrency($baseCurrency = NULL, $destiCurrency = NULL, $dateCurrency = NULL)
	{
		$this->baseCurrency = $baseCurrency;
		$this->destiCurrency = $destiCurrency;
		$this->dateCurrency = $dateCurrency;

		if (strcasecmp($this->baseCurrency,$this->destiCurrency) == 0)
			return $this->converted = array($this->baseCurrency => 1);
 
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
			$this->amountCurrency = 1;
		}
		if (NULL == $this->dateCurrency) {
			$this->dateCurrency = date('Y-m-d');
		}
		if (NULL == $this->baseCurrency) {
			$this->baseCurrency = 'USD';
		}
		if (NULL == $this->destiCurrency) {
			$this->destiCurrency = 'VES';
		}

		$urlrequested = $this->currencyApiUrl."/".$this->dateCurrency."?symbols=".$this->destiCurrency."&base=".$this->baseCurrency;

		log_message('debug', __CLASS__ .'URL: '.print_r($urlrequested,TRUE) );
		$this->converted = 0;

		$curl = curl_init();

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
		log_message('debug', __CLASS__ .':json response: '. print_r($response,TRUE) );
		if (! isset($response)) 
		{
			return array('ERR'=>0);
		}
		curl_close($curl);

		$conversion = json_decode($response, true);
		log_message('debug', __CLASS__ .':json decode: '. print_r($response,TRUE) );
		if(! array_key_exists('rates', $conversion))
		{
			return array('ERR'=>0);
		}
		$rates = $conversion['rates'];

		$this->converted = $rates;
		$resultstoprint = '';
		foreach($rates as $destiCurrency => $valueCurrency)
		{
			$valueCurrency = floatval($valueCurrency)*floatval($this->amountCurrency);
			$resultstoprint .= $destiCurrency.':'.$valueCurrency.'; ';
			$this->converted[$destiCurrency] = $valueCurrency;
		} 
		log_message('info', __CLASS__ .': converted rates: '. print_r($resultstoprint,TRUE) );
		log_message('debug', __CLASS__ .': converted rates: '. print_r($this->converted,TRUE) );
		return $this->converted;

	}

}
