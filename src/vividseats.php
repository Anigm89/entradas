<?php
/*
    $token = 'DWXfsOpLWsjzRyCXprHSRqZej6K2jB9l3JH0Vh6IrT8=';
    $url = 'https://brokers.vividseats.com/webservices/listings/v2/get';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Api-token:' . $token,
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);     var_dump($response);
    curl_close($ch);
    $data = json_decode($response, true);
    var_dump($data);
    */
?>
<?php
    $token = $_ENV['TOKEN'];
    $curl = curl_init();
    
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://brokers.vividseats.com/webservices/listings/v2/get",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Api-token: $token"
      ],
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    
    curl_close($curl);
    
    //manejo los posibles errores
    if ($err) {
      echo "Error en la solicitud: " . $err;
  } else {
      
      if ($httpCode != 200) {
          echo "No se pudo conectar a la API. Código HTTP: " . $httpCode;
      } else {
          
          $data = json_decode($response, true);
          
          if (json_last_error() !== JSON_ERROR_NONE) {  // Si hay un error al decodificar el JSON
            
              echo "Error al procesar la respuesta de la API.";
          } else {
              // Si la API devuelve 'success' en la respuesta, comprueba ese campo
              if (isset($data['success']) && !$data['success']) {
                  echo "La API respondió pero con un error: No pudo obtener los datos. ".$data['message'] ;
              } 
              else {
                 
                  echo "Respuesta de la API: ";
                  print_r($data); 
              }
          }
      }
  }

?>