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

?>
