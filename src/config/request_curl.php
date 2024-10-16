<?php
//inicio cURL  
    function makeCurlRequest($url, $options = []) {
       
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        foreach ($options as $option => $value) {
            curl_setopt($ch, $option, $value);
        }
        
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch); 
        curl_close($ch);

        if($curl_error){
            echo "Error en cURL: " . $curl_error;
            exit;
        }

        if ($http_status !== 200) {
            echo "Error al acceder a la URL: Código de respuesta HTTP " . $http_status;
        }
        return [$http_status, $response];
    }

?>