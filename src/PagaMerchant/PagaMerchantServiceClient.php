<?php

/**
 * Parses and verifies the doc comments for files.
 *
 * PHP version >=5
 *
 * @category  PHP
 * @package   PagaMerchant
 * @author    PagaDevComm <devcomm@paga.com>
 * @copyright 2020 Pagatech Financials
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      https://packagist.org/packages/paga/paga-merchant
 */

namespace PagaMerchant;

/**
 * Parses and verifies the doc comments for files.
 *
 * PHP version >=5
 *
 * @category  PHP
 * @package   PagaMerchant
 * @author    PagaDevComm <devcomm@paga.com>
 * @copyright 2020 Pagatech Financials
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      https://packagist.org/packages/paga/paga-merchant
 */
class PagaMerchantServiceClient
{

    var $test_server = "https://beta.mypaga.com"; //"http://localhost:8080"
    var $live_server = "https://www.mypaga.com";


    /**
     * __construct function
     *
     * @param mixed[] $builder Builder Object
     */
    function __construct($builder)
    {
        $this->apiKey =$builder->apiKey;
        $this->principal = $builder->principal;
        $this->credential = $builder->credential;
        $this->test = $builder->test;
    }

    /**
     * Builder function
     *
     * @return void
     */
    public static function builder()
    {
        return new Builder();
    }

  
    /**
     * Undocumented function
     *
     * @param string  $url  Authorization code url
     * @param string  $hash sha512 encoding of the required parameters and the clientAPI key
     * @param mixed[] $data request body data
     * 
     * @return void
     */
    public function buildRequest($url, $hash, $data = null)
    {

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array("content-type: application/json", "Accept: application/json","hash:$hash","principal:$this->principal", "credentials: $this->credential"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120
            )
        );

        if ($data != null) {
            $data_string = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        }

        return $curl;
    }


     /**
      * Get Transaction Details function
      *
      * @param [string] $reference_number A unique reference number identifying the transaction
      * 
      * @return JSON Object with transaction details
      */
    public function getTransactionDetails($reference_number)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/getTransactionDetails";
        $data = array(
            'referenceNumber'=>$reference_number
        );

        $hash_string = $reference_number.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }

  
     /**
      * Get Transaction Details By Reference Number function
      *
      * @param string $invoice_number invoice number of the transaction.
      * 
      * @return JSON Object with transaction details
      */
    public function getTransactionDetailsByInvoiceNumber($invoice_number)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/getTransactionDetailsByInvoiceNumber";
        $data = array(
            'invoiceNumber'=>$invoice_number
        );

        $hash_string = $invoice_number.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }

   

     /**
      * Get Process Details function
      *
      * @param string $processCode The process code of the transaction
      *
      * @return JSON Object with process details
      */
    public function getProcessDetails($processCode)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/getProcessDetails";
        $data = array(
            'processCode'=>$processCode
        );

        $hash_string = $processCode.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }

   

    /**
     * Reconciliation Report function
     *
     * @param date:string $startDate The date period(yyyy-mm-dd eg. 2016-01-30) for the reconciliation report to start
     * @param date:string $endDate   The date period(yyyy-mm-dd eg. 2017-01-30) for the reconciliation report ends                                                                                
     * 
     * @return JSON Object with reconciliationItems
     */
    public function reconciliationReport($startDate,$endDate)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/reconciliationReport";
        $periodStartDateTimeUTC = strtotime($startDate)*1000;
        $periodEndDateTimeUTC = strtotime($endDate)*1000;

        $data = array(
            'periodStartDateTimeUTC'=>$periodStartDateTimeUTC,
            'periodEndDateTimeUTC'=>$periodEndDateTimeUTC
        );

        $hash_string = $periodEndDateTimeUTC.$periodStartDateTimeUTC .$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }

  

     /**
      * Get Foreign Exchange function
      *
      * @param string $baseCurrency    the originating currency code
      * @param string $foreignCurrency the currency code we want to get the exchange rate for
      *
      * @return JSON Object with buyRate and sellRate
      */
    public function getForeignExchangeRate($baseCurrency,$foreignCurrency)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/getForeignExchangeRate";
        $data = array(
            'baseCurrency'=>$baseCurrency,
            'foreignCurrency'=>$foreignCurrency
        );

        $hash_string = $baseCurrency.$foreignCurrency.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }

 

     /**
      * Refund Bill Pay function
      *
      * @param string $referenceNumber     The unique reference number provided as part of the original transaction which identifies the transaction to be refunded
      * @param string $refundAmount        the amount to be refunded
      * @param string $customerPhoneNumber The phone number of the customer that performed the operation
      *
      * @return JSON Object with Refund Bill Pay Item
      */
    public function refundBillPay($referenceNumber,$refundAmount,$customerPhoneNumber)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/refundBillPay";
        $data = array(
            'referenceNumber'=>$referenceNumber,
            'refundAmount'=>$refundAmount,
            'customerPhoneNumber'=>$customerPhoneNumber
        );

        $hash_string = $referenceNumber.$refundAmount.$customerPhoneNumber.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }


    /**
     * Get Transaction By Merchant Reference Number function
     *
     * @param string $merchantReference The unique reference number provided as part of the original transaction which identifies the transaction to be refunded
     * 
     * @return JSON Object with transaction details
     */
    public function getTransactionDetailsByMerchantReferenceNumber($merchantReference)
    {

        $server = ($this->test) ? $this->test_server : $this->live_server;
        $url = $server."/paga-webservices/merchant-rest/secured/getTransactionDetailsByMerchantReference";
        $data = array(
            'merchantReference'=>$merchantReference,
        );

        $hash_string = $merchantReference.$this->apiKey;

        $hash = hash('sha512', $hash_string);

        $curl = $this->buildRequest($url, $hash, $data);
        $response = curl_exec($curl);
        $this->checkCURL($curl);
        return $response;
    }


   

    /**
     * CheckUrl function
     *
     * @param string $curl CURL
     * 
     * @return void
     */
    public function checkCURL($curl)
    {
        if (curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        printf("<br/>HTTP Code: " . $httpcode);

        if ($httpcode == 200) {
            printf("SUCCESSFUL");
        }
        //var_dump($response);

        curl_close($curl);
    }



}

/**
 * Builder class
 * 
 * @category PHP
 * @package  Builder
 * @author   PagaDevComm <devcomm@paga.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://packagist.org/packages/paga/paga-merchant
 */
class Builder
{
    /**
     * __construct function
     */
    function __construct() 
    {

    }

    /**
     * Set API Key function
     *
     * @param string $apiKey Merchant api key
     * 
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Set Principal function
     *
     * @param string $principal Merchant public ID from paga
     * 
     * @return void
     */
    public function setPrincipal($principal) 
    {
        $this->principal = $principal;
        return $this;
    }

    /**
     * Set Credential function
     *
     * @param string $credential Merchant password from paga
     * 
     * @return void
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * Set Test function
     *
     * @param string $flag flag to set testing or live(true for test,false for live)
     * 
     * @return void
     */
    public function setTest($flag)
    {
        $this->test = $flag;
        return $this;
    }

    /**
     * Build function
     *
     * @return void
     */
    public function build() 
    {
        return new PagaMerchantServiceClient($this);
    }
}


?>


