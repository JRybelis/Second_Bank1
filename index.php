<?php

require __DIR__.'/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <link rel="stylesheet" href="http://localhost/second_bank/public/css/app.css"
</head>
<body class="p-3 mb-2 bg-secondary text-white">
    <div class="d-inline-block rounded-right p-3 mb-2 bg-light text-white">
        <h1 class="text-danger">Second Bank</h1>
        <a href="<?= URL ?>login.php"><button class="navigation">Login to your personal Second Bank account</button></a>
        <a href="<?= URL ?>private.php"><button class="navigation">Clients' area</button></a> 
    </div>

    <img style="max-width: 100%" src="http://localhost/second_bank/public/img/need_money.jpeg" alt="needMoney">
    

    
</body>
</html>