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
</head>
<body>
    <h1>Second Bank</h1>
    <a href="<?= URL ?>login.php">Login to your personal Second Bank account</a>
    <a href="<?= URL ?>private.php">Clients' area</a> 
</body>
</html>