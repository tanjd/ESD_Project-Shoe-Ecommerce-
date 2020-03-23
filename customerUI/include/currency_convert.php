<?php

include 'autoload.php'; 
// currency converter API
$endpoint = 'latest';
$access_key = '753b707189493b7ccd9a2c7d9cd5658e';
$symbols = 'USD,SGD,GBP,EUR,AUD'; 
$url = 'http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&symbols='.$symbols.''; 
// base currency is EUROS

function CurrencyAPI($url){
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($json, true); 

    return $data; 
}





// currency_conversion function
function convert($SGD, $selected_currency){
    $endpoint = 'latest';
    $access_key = '753b707189493b7ccd9a2c7d9cd5658e';
    $symbols = 'USD,SGD,GBP,EUR,AUD'; 
    $url = 'http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&symbols='.$symbols.''; 
    // base currency is EUROS

    $currencyAPI = CurrencyAPI($url); 

    $exchangeRates = []; 
    $API_status = false; 
    if (isset($currencyAPI)){
        $exchangeRates = $currencyAPI['rates']; 
        $API_status = $currencyAPI['success']; 
    }

    if (isset($exchangeRates)){
        if ($selected_currency == 'SGD'){
            return $SGD; 
        }
        else{
            $SGDinBase = $exchangeRates['SGD'];
            $result = round($SGD / $SGDinBase * $exchangeRates[$selected_currency], 2); 
            return $result; 
        }
    }
    else{
        return false; 
    } 
}



?>