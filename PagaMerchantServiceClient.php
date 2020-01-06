<?php


class PagaMerchantServiceClient {

    var $test_server = "https://qa1.mypaga.com"; //"http://localhost:8080"
    var $live_server = "https://www.mypaga.com";


    /**
     * @param string apiKey
     *            Merchant api key
     * @param string principal
     *            Merchant public ID from paga
     * @param string credential
     *            Merchant password from paga
     * @param boolean test
     *            flag to set testing or live(true for test,false for live)
     */

    function __construct($builder) {
        $this->apiKey =$builder->apiKey;
        $this->principal = $builder->principal;
        $this->credential = $builder->credential;
        $this->test = $builder->test;
    }

    public static function builder(){
        return new Builder();
    }


    /**
     * @param string @url
     *            Authorization code url
     * @param string @hash
     *            sha512 encoding of the required paramers and the clientAPI key
     * @param array @data
     *           request body data
     */
    public function buildRequest($url, $hash, $data = null) {

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
        ));

        if($data != null) {
            $data_string = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data_string);

        }

        return $curl;
    }


    /**
     * @param string $reference_number
     *               A unique reference number identifying the transaction.
     * @return JSON Object with transaction details
     */
    public function getTransactionDetails($reference_number){

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
     * @param string $processCode
     *               The process code of the transaction
     * @return JSON Object with process details
     */
    public function getProcessDetails($processCode){

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
     * @param string $StartDate
     *                The date period(yyyy-mm-dd eg. 2016-01-30) for the reconciliation report to start
     * @param string $EndDate
     *               The date period(yyyy-mm-dd eg. 2017-01-30) for the reconciliation report ends
     * @return JSON Object with reconciliationItems
     */
    public function reconciliationReport($startDate,$endDate){

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
     * @param string $baseCurrency
     *               the originating currency code
     * @param string $foreignCurrency
     *               the currency code we want to get the exchange rate for
     * @return JSON Object with buyRate and sellRate
     */
    public function getForeignExchangeRate($baseCurrency,$foreignCurrency){

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
     * @param string $referenceNumber
     *              The unique reference number provided as part of the original transaction which identifies the transaction to be refunded
     * @param string $refundAmount
     *               the amount to be refunded
     * @param string $customerPhoneNumber
     *               The phone number of the customer that performed the operation
     * @return JSON Object with buyRate and sellRate
     */
    public function refundBillPay($referenceNumber,$refundAmount,$customerPhoneNumber){

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
     * @param $curl
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

class Builder {
    function __construct() {

    }

    public function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
        return $this;
    }
    public function setprincipal($principal) {
        $this->principal = $principal;
        return $this;
    }
    public function setCredential($credential){
        $this->credential = $credential;
        return $this;
    }
    public function setTest($flag){
        $this->test = $flag;
        return $this;
    }
    public function build() {
        return new PagaMerchantServiceClient($this);
    }
}


?>

