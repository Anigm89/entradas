<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ejercicio para mostrar precio entradas">
    <title>Entradas</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body>
    <?php
 
    require_once __DIR__ . '/src/config/loadEnv.php'; 

    ?>
    <section>
        <h1>Entradas</h1>
        <h1>1. Compra tus entradas con vividseats</h1>
        <?php
        include('./src/vividseat.php');
        ?> 
        <h1>2. Compra tus entradas a través de seatgeek</h1>
        <?php
        include('./src/seatgeet.php');
        ?> 
    </section>
   
</body>
</html>


