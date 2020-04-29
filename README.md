# PagaMerchant Nodejs API Library v1.0.0

## Merchant Services exposed by the library

- getTransactionDetails
- getTransactionDetailsByInvoiceNumber
- getProcessDetails
- reconciliationReport
- getForeignExchangeRate
- refundBillPay

For more information on the services listed above, visit the [Paga DEV website](https://mypaga.readme.io/docs/node-library-1)

## How to use

`npm install paga-merchant`

 
```
const PagaMerchant = require('PagaMerchantClient');

var pagaMerchantClient = PagaMerchant.Builder()
      .setPrincipal("<Paga_Merchant_Public_ID>")
      .setCredential("<Paga_Merchant_Credentials>")
      .setApiKey("<Merchant_Api_Key>")
      .setIsTest(true)
      .build();
```

As shown above, you set the principal and credential given to you by Paga, If you pass true as the value for setIsTest(), the library will use the test url as the base for all calls. Otherwise setting it to false will use the live url value you **pass** as the base. 

### Merchant Service Functions

**Get Transaction Details**

To verify the status and details of an executed process or to determine if a transaction was indeed executed on the system using the pre-shared transaction reference number, you call getTransactionDetails function inside PagaMerchantClient and it returns JSONObject

```
pagaMerchantClient.getTransactionDetails('referenceNumber').then(resp => 
 {
    console.log(resp)
 })
```
**Get Transaction Details by Invoice Number**

To verify the status and details of an executed process or to determine if a transaction was indeed executed on the system using the pre-shared transaction invoice number, call getTransactionDetailByInvoiceNumber function inside PagaMerchantClient and it returns JSONObject.

```
pagaMerchantClient.getTransactionDetailByInvoiceNumber('invoiceNumber').then(resp => 
 {
    console.log(resp)
 })
```
**Get Process Details**

To determine if a process was indeed executed on the system using the pre-shared process code, call getProcessDetail function inside PagaMerchantClient and it returns a JSONObject Response

```
pagaMerchantClient.getProcessDetail('processCode').then(resp => 
 {
    console.log(resp)
 })
```
**Reconciliation Report**

To retrieve reconciled reports on the date range provided containing list of processes and transactions call reconciliationReport function inside PagaMerchantClient and it returns a JSONObject Response. Take note that your dates parameter should pass dates in this format: "YYYY-MM-DD".

```
pagaMerchantClient.reconciliationReport(periodStartDateTimeUTC, periodEndDateTimeUTC).then(resp => 
 {
    console.log(resp)
 })
```
**Get Foreign Exchange Rate**

To determine the exchange rate call getForeignExchange function inside PagaMerchantClient and it returns a JSONObject Response.

```
pagaMerchantClient.getForeignExchangeRate('baseCurrency', 'foreignCurrency').then(resp => 
 {
    console.log(resp)
 })
```
**Refund Bill Pay**

To fully or partially refund bill payment previously made by a customer call refundBillPay function inside PagaMerchantClient and it returns a JSONObject Response.

```
pagaMerchantClient.refundBillPay('referenceNumber', includesCustomerFee,fullRefund,'refundAmount','currencyCode','reason','customerPhoneNumber').then(resp => 
 {
    console.log(resp)
 });
```