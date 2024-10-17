<?php

//llamo a la funcion de inicio de curl para hacer scraping 
    require_once('simple_html_dom.php');
    require_once('config/request_curl.php');

    $url='https://www.vividseats.com/real-madrid-tickets-estadio-santiago-bernabeu-12-22-2024--sports-soccer/production/5045935';
    $urlFilter=filter_var($url, FILTER_VALIDATE_URL);
    $options = [
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        CURLOPT_REFERER => 'https://www.vividseats.com',
        CURLOPT_COOKIEJAR => 'cookies.txt',
        CURLOPT_COOKIEFILE => 'cookies.txt',
        CURLOPT_FOLLOWLOCATION => true
    ];
    list($http_status, $html) = makeCurlRequest($urlFilter, $options);

    if ($http_status !== 200 || !$html) {
        throw new Exception("Error al acceder a la URL: Código de respuesta HTTP $http_status");
    }

    // Cargo el HTML en el DOM
    $dom = str_get_html($html);

       // var_dump($html);
       // echo htmlspecialchars($html);
    if (!$dom) {
        echo "Error al cargar el DOM: " . $html;
        exit;
    }
    //saco el titulo del evento del meta data
    $metaTitle = $dom->find('meta[property=og:title]', 0);
    $title = $metaTitle ? $metaTitle->content : 'No encontrado';

    //intento sacar la informacion de las entradas  por categorias
    $categories = $dom->find('div[class=MuiTypography-root MuiTypography-small-medium styles_nowrap___p2Eb mui-6w2num]');

?>

<div class="ej1">
    <h4>Evento: <?= htmlspecialchars($title) ?></h4>
    
        <?php
            if($categories){
                foreach($categories as $category) {
                    echo'<p> Sección:'. $category->plaintext . '</p>';
                
                // Dentro de cada sección, busco las filas y los precios
                    $rows = $category->find('div.styles_listingRowContainer__d8WLZ');
                    
                    if($rows){
                        foreach($rows as $row){
                            $rowSection = $row->find('span.styles_rowText__0qCtO', 0)->plaintext ?? 'No disponible';
                            $price = $row->find('span[data-testid=listing-price]', 0)->plaintext ?? 'No disponible';
                            echo'<p> Fila:'. htmlspecialchars($rowSection). '</p>';
                            echo'<p> precio:'. htmlspecialchars($price) . '</p>';
                        }
                    }
                    else{ echo 'No se ha encontrado información sobre filas';}
                }
            }
            else{
                echo '<p> No se ha encontrado información sobre las entradas </p>';
            }
        ?>
    
</div>