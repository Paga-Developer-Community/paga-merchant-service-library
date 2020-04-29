# Paga Merchant PHP API Library v1.0.0

## Merchant Services exposed by the library

- getTransactionDetails
- getTransactionDetailsByInvoiceNumber
- getProcessDetails
- reconciliationReport
- getForeignExchangeRate
- refundBillPay

For more information on the services listed above, visit the [Paga DEV website](https://developer-docs.paga.com/docs/php-library-2)

## How to use

`composer require paga/paga-merchant`

 
```
include("PagaMerchantServiceClient.php");

$merchantServiceClient = PagaMerchantServiceClient::builder()
    ->setApiKey("<apiKey>")
    ->setPrincipal("<clientId>")
    ->setCredential("<password>")
    ->setTest(true)
    ->build();
```

As shown above, you set the principal and credential given to you by Paga, If you pass true as the value for setIsTest(), the library will use the test url as the base for all calls. Otherwise setting it to false will use the live url value you **pass** as the base. 

### Merchant Service Functions

**Get Transaction Details**

To verify the status and details of an executed process or to determine if a transaction was indeed executed on the system using the pre-shared transaction reference number, you call getTransactionDetails function inside PagaMerchantClient and it returns JSONObject

```
$response=$merchantServiceClient -> getTransactionDetails("<referenceNumber>");
```
**Get Transaction Details by Invoice Number**

To verify the status and details of an executed process or to determine if a transaction was indeed executed on the system using the pre-shared transaction invoice number, call getTransactionDetailByInvoiceNumber function inside PagaMerchantClient and it returns JSONObject.

```
$response=$merchantServiceClient -> getTransactionDetailsByInvoiceNumber("<invoice_Number>");
```
**Get Process Details**

To determine if a process was indeed executed on the system using the pre-shared process code, call getProcessDetail function inside PagaMerchantClient and it returns a JSONObject Response

```
$response=$merchantServiceClient -> getProcessDetails("<process_code>");

```
**Reconciliation Report**

To retrieve reconciled reports on the date range provided containing list of processes and transactions call reconciliationReport function inside PagaMerchantClient and it returns a JSONObject Response. Take note that your dates parameter should pass dates in this format: "YYYY-MM-DD".

```
$response=$merchantServiceClient -> reconciliationReport('2015-01-30','2016-01-30');

```
**Get Foreign Exchange Rate**

To determine the exchange rate call getForeignExchange function inside PagaMerchantClient and it returns a JSONObject Response.

```
$response=$merchantServiceClient -> getForeignExchangeRate('NGN','USD');
```
**Refund Bill Pay**

To fully or partially refund bill payment previously made by a customer call refundBillPay function inside PagaMerchantClient and it returns a JSONObject Response.

```
$response=$merchantServiceClient -> refundBillPay('<reference_Number>','<refund_amount','<customerPhoneNumber>');
```

**Get Transaction Details By Merchant Reference Number**

This service allows the merchant to verify the status and details of an executed transaction or to determine if a transaction was indeed executed on the system using the merchant reference number. Merchant aggregators checking for transaction status across multiple users should use this method.

```
$response=$merchantServiceClient -> getTransactionDetailsByMerchantReference('<merchantReference>');
```