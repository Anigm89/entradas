<?php
    
    //configuro las options para curl y llamo a la funcion para iniciarlo
    require_once('config/request_curl.php');

    $url='https://api.seatgeek.com/2/events?type=concert&performers.slug=mago-de-oz';
    
    $options = [
        CURLOPT_USERPWD => $_ENV['CLIENT_ID'] . ':' . $_ENV['SECRET']
    ];
    list($http_status, $response) = makeCurlRequest($url, $options);

    if ($http_status == 200) {
        $data = json_decode($response, true);
    } else {
        echo "Error al acceder a la API: Código de respuesta HTTP " . $http_status;
        exit;
    }    
?>
<div class="events">
    <div class="dcha">
    <?php 
        // Mostrar la imagen solo una vez
        if (isset($data['events']) && !empty($data['events'])) : 
            $imageShown = false;
            foreach($data['events'] as $event) : 
                foreach($event['performers'] as $performer) : 
                    if (isset($performer["image"]) && !$imageShown): ?>
                        <img src="<?= htmlspecialchars($performer["image"]) ?>" alt="Imagen de <?= htmlspecialchars($performer["name"]) ?>"> 
                        <?php $imageShown = true; // La imagen ya se mostró, no se vuelve a mostrar ?>
                    <?php endif; 
                endforeach; 
                if ($imageShown) break; 
            endforeach; 
        endif; 
        ?>
    </div>
    <div class="izq">
        <p class="subtitle">Próximos conciertos de Mago de Oz</p>
        <ul>
            <?php if (isset($data['events']) && !empty($data['events'])){ ?>
                <?php foreach($data['events'] as $event) : ?>
                    <?php foreach($event['performers'] as $performer) :?>
                    <li>
                        <p><?= htmlspecialchars($performer["name"]) ?></p>
                        <p>Fecha: 
                        <?php 
                            if(isset($event['datetime_local'])){
                                $date = new DateTime($event['datetime_local']); //formateo la fecha al formato español 
                                echo $date->format('d/m/Y  H:i:s');
                            }
                            else{
                                echo 'Fecha no disponible';
                            }
                        ?>
                        </p>
                        <p>Lugar: 
                            <?php if(isset($event['venue']['city']) && isset($event['venue']['country'])){
                                echo  htmlspecialchars($event['venue']['city'] . '/' . $event['venue']['country']);
                            }
                            else{
                                echo 'Lugar no disponible';
                            }  ?>
                        </p>
                        <a href="<?= htmlspecialchars($event['url']) ?>" target="_blank">Comprar entradas</a>
                    </li>
                    <?php endforeach ?>
                <?php endforeach ?>
            <?php } else { ?>
                <li>No se encontraron eventos.</li>
            <?php }; ?>
        </ul>
    </div>
</div>

