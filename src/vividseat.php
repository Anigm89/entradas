<?php
    require_once('simple_html_dom.php');

    $url='https://www.vividseats.com/real-madrid-tickets-estadio-santiago-bernabeu-12-22-2024--sports-soccer/production/5045935';

    //inicio curl
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.vividseats.com');  // Referer
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Guarda las cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Usa las cookies guardadas
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Sigue redirecciones

    $html = curl_exec($ch);
    
    if(curl_errno($ch)){
        echo "Error en curl: ". curl_error($ch);
        exit;
    }   
    curl_close($ch);

    // Cargo el HTML en el DOM
    $dom = str_get_html($html);


        //echo htmlspecialchars($html)

    //saco el titulo del evento del meta data
    $metaTitle = $dom->find('meta[property=og:title]', 0);
    $title = $metaTitle ? $metaTitle->content : 'No encontrado';

    //intento sacar la informacion de las entradas  por categorias
    $categories = $dom->find('div[class=MuiTypography-root MuiTypography-small-medium styles_nowrap___p2Eb mui-6w2num]');

?>

<div>
    <h2>Evento: <?= $title ?></h2>
    
        <?php
            if($categories){
                foreach($categories as $category) {
                    echo'<p> Sección:'. $category->plaintext . '</p>';
                }
                // Dentro de cada sección, busco las filas y los precios
                 $rows = $category->parent()->parent()->find('div.styles_listingRowContainer__d8WLZ');

                foreach($rows as $row){
                    $rowSection = $row->find('span.styles_rowText__0qCtO', 0)->plaintext ?? 'No disponible';
                    $price = $row->find('span[data-testid=listing-price]', 0)->plaintext ?? 'No disponible';
                    echo'<p> Fila:'. $rowSection. '</p>';
                    echo'<p> precio:'. $price . '</p>';
                }

            }
            else{
                echo 'No se ha encontrado información sobre las entradas';
            }
        ?>
    
</div>