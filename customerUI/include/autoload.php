<?php

    require_once 'microservice_config.php';

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
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($result);
        $status = checkURL($data);

        if ($status == true) {
            return $data;
        } else {
            return false;
        }
    }

    function endsWith($haystack, $end)
    {
        $length = strlen($end);

        return $length === 0 ||
            (substr($haystack, -$length) === $end);
    }

    function checkURL($data)
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

?>