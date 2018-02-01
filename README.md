# iota.lib.php
A small php library that replicates some of the features of the IOTA javascript library. It takes a Tangle address and returns either a confirmed balance or the transaction data associated with that address.

This library is a server side implementation in php of some of the features of iota.lib.js. It is used to retrieve transaction

## How to Use (see demo files for full code)
1) Include the library.php file in your code
2) Set an IOTA address (either from a user input, hardcoded, database query, etc.)
3) Invoke a library function

## Quick Demo (Retrieve all Transactions for an Address - Including Pending/Unconfirmed)
```php
// include iota php library
include('./library.php');

// set an example address (this can be input from a user or sourced from a database, etc.)
$addressesInput = ["DYIUGT9AEKTBYRSROYXLABZDUHILMTUOEXWZP9SFMXBRYQ9BXSNROYYHHAPNVYLUEFIFTRJEHDBBRHLFZ"];

// example to get the values of all transactions for an address (can be pending or confirmed)
$txInput = getTransactionHash($addressesInput,$url);
$txInputJson = (array) json_decode($txInput);                                                                                                   
$txInputHashes = $txInputJson['hashes'];                    

if ($txInput != "ERROR") {
    
    // cycle through transactions (pull the address and value for each)
    $i = 0;
    while ($i < count($txInputHashes)) {
        $tempTx = $txInputHashes[$i];        
        $tempTxArray = [$tempTx];
        $transactionTrytes = getTrytes($tempTxArray,$url);        
        $transactionTrytesJson = (array) json_decode($transactionTrytes);                                                                                                   
        $tempTransactionTrytes = $transactionTrytesJson['trytes'];                    
        $tempTrytes = $tempTransactionTrytes[0];                    
        $transactionData = getDataFromTrytes($tempTrytes);
        if ($transactionData != "ERROR") {
            echo "<br>Value is: ".$transactionData['value'];
            echo "<br>Address is: ".$transactionData['txAddress'];    
        } else {
            echo "<br>There was an error. Transaction data is malformed.";
        }
        $i++;
    }
    
} else {
    echo "There was an error. Address may be wrong or node url could be down.";
}
```
## Setting Light Server Url
The library currently uses nodes.iota.cafe (for https) andeugene.iota.community (for http). To change this server, simply set an url variable in your php code.

```php
// include iota php library
include('./library.php');

// set the url to override library url
$url = "YOUR_URL_FOR_LIGHT_SERVER_INCLUDING_PORT";

// set an example address (this can be input from a user or sourced from a database, etc.)
$addressesInput = ["DYIUGT9AEKTBYRSROYXLABZDUHILMTUOEXWZP9SFMXBRYQ9BXSNROYYHHAPNVYLUEFIFTRJEHDBBRHLFZ"];

// example to check confirmed balance of at address
$value = getBalances($addressesInput,$url);
if ($value != "ERROR") {
    echo "Confirmed balance is ".$value;
    // convert string variable to an integer
    $integerValue = (int) $value;
} else {
    echo "There was an error. Address may be wrong or node url could be down.";
}
```

## Available Functions
The library currently has the following functions:
1) getTransactionHash($inputAddress,$url) - takes an address and returns the associated transaction hashes.
2) getTrytes($inputHash,$url) - takes a transaction hash and returns the trytes.
3) getDataFromTrytes($trytes) - takes the trytees and returns transaction data
  - transaction address
  - signatureMessageFragment
  - tag
  - value
4) getBalances($inputAddress,$url) - takes an address and returns the confirmed balance
