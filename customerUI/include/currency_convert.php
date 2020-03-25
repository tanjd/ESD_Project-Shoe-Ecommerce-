<?php

// currency converter API
$endpoint = 'latest';
$access_key = '978c0ebe8cf2b9369b0b4aeef0dcfbbe';
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

$_SESSION['currencyAPI'] = CurrencyAPI($url); 



// currency_conversion function
function convert($SGD, $selected_currency){


    $exchangeRates = []; 
    $API_status = false; 
    if (isset($_SESSION['currencyAPI'])){
        $currencyAPI = $_SESSION['currencyAPI']; 
        $exchangeRates = $currencyAPI['rates']; 
        $API_status = $currencyAPI['success']; 
    }

    if (isset($exchangeRates)){
        if ($selected_currency == 'SGD'){
            $result = number_format($SGD, 2, '.', ','); 
            return $result; 
        }
        else{
            $SGDinBase = $exchangeRates['SGD'];
            $result = number_format($SGD / $SGDinBase * $exchangeRates[$selected_currency], 2, '.', ','); 
            return $result; 
        }
    }
    else{
        return false; 
    } 
}





?>