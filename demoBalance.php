<?php

// include iota php library
include('./library.php');

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

?>
