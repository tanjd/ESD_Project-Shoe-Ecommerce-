<?php

    require_once 'microservice_config.php';

    if (!isset($_SESSION))
    {
        session_start();
    }

    function CallAPI($method, $url, $api_name, $data = false)
    {
        // make sure URL ends with '/'
        if (!endsWith($url, '/')) {
            $url .= '/';
        }
        $url .= $api_name;
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    $data = json_encode($data, JSON_PRETTY_PRINT);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    //Set the content type to application/json
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                // // HTTP GET
                // $query_data =  http_build_query($data);
                // curl_setopt($ch, CURLOPT_URL, "$url?$query_data");
                // curl_setopt($ch, CURLOPT_POST, false);
        }

        // Optional Authentication:
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($result);

        return $data;
    }

    function endsWith($haystack, $end)
    {
        $length = strlen($end);

        return $length === 0 ||
            (substr($haystack, -$length) === $end);
    }

    function checkSuccessOrFailure($data)
    {
        if (isset($data->{'status'})) {
            $status = $data->{'status'};
            if ($status == 'success') {
                return true;
            } elseif ($status == 'fail') {
                return false;
            }
        } else {
            return false;
        }
    }

    function outputError()
    {
        if (isset($_SESSION['error'])){
            $error = $_SESSION['error'];
            echo "<p> {$error} </p>";
            unset($_SESSION['error']);
        }
    }
?>