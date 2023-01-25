<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Currencylib
{

    private $CI;

    private $converted;

    private $dateCurrency;

    private $baseCurrency;

    private $destiCurrency;

    private $amountCurrency;

    private $currencyApiKey;

    private $currencyApiUrl;

    public function __construct()
    {
        $this->CI =& get_instance();
//        $this->CI->config->load('currencylib', true);

        $this->dateCurrency = date('Y-m-d');
        $this->amountCurrency = 1;
//        $this->currencyApiKey = $this->CI->config->item('currency_api_key', 'currencylib');
//        $this->currencyApiUrl = $this->CI->config->item('currency_api_url', 'currencylib');
    }

    public function initialize()
    {
        // TODO init the amount, destino, base and date using array parameters
    }

    public function convertCurrency($baseCurrency = NULL, $destiCurrency = NULL, $dateCurrency = NULL)
    {
        if (NULL == $this->currencyApiKey) {
//            throw new \Exception('Api Key missing');
        }

        $this->baseCurrency = $baseCurrency;
        $this->destiCurrency = $destiCurrency;
        $this->dateCurrency = $dateCurrency;

        if (strcasecmp($this->baseCurrency,$this->destiCurrency) == 0)
            return 1;
 
        $this->converted = $this->requestCurrency();
        $this->converted = $this->converted * $this->amountCurrency;

        return $this->converted;
    }

    private function requestCurrency()
    {

        $this->converted = 0;
    //curl --request GET --url 'https://api.apilayer.com/exchangerates_data/2022-12-12?symbols=VES&base=USD' --header 'apikey: VT8SP8bScl98eMHzetvJQS9a1D8U0Y8j'

        $postdata = http_build_query(
            array(
                'symbols' => 'VES',
                'base' => 'USD'
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header'  => 'apikey: VT8SP8bScl98eMHzetvJQS9a1D8U0Y8j\r\nContent-Type: text/plain\r\n',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);

        $result = file_get_contents('https://api.apilayer.com/exchangerates_data/'.date('Y-m-d'), false, $context);

        log_message('info', 'result of data json: '. print_r($result,TRUE) );

        if (isset($result)) {
            $conversion = json_decode($result, true);
            $rates = $conversion['rates'];

            if ( isset($rates) ) {
                $this->converted = $rates['VES'];
            }
        }
        log_message('info', 'result of convert: '. print_r($this->converted,TRUE) );
        return $this->converted;

/*
        $url = 'https://free.currencyconverterapi.com/api/v5/convert?q=' . $this->baseCurrency . '_' . $this->destiCurrency . '&compact=ultra&apiKey=' . $this->currencyApiKey;
        $handle = @fopen($url, 'r');

        if ($handle) {
            $result = fgets($handle, 4096);
            fclose($handle);
        }

        if (isset($result)) {
            $conversion = json_decode($result, true);
            if (isset($conversion[$this->baseCurrency . '_' . $this->destiCurrency])) {
                return $conversion[$this->baseCurrency . '_' . $this->destiCurrency];
            }
        }

        return $this->converted = 0;*/
    }

    public function setApiKey($apiKey)
    {
        $this->currencyApiKey = $apiKey;
    }
}
