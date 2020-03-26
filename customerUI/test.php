<?php
$names = [['name' => 'ava'], ['name' => 'bob'], ['name'=> 'char']]; 
$id = 'ava'; 

foreach ($names as $name){
    if ($name['name'] == $id){
        echo 'hello'; 
    break;
    }

    else{
        echo 'oh no'; 
        array_push($names, $id); 
    break; 
    }
}

var_dump($names); 



?>