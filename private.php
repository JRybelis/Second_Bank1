<?php

require __DIR__.'/bootstrap.php';


if(!isset($_SESSION['login']) || 1 != $_SESSION['login']) {
    header('Location:'.URL.'login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private</title>
</head>
<body>
    <h1>Hello, <?= $_SESSION['user']['name']?> <?=$_SESSION['user']['surname']?></h1>
    <a href="<?= URL ?>login.php?logout">LogOut</a> 
    <br><br>
    <a href="<?= URL ?>create.php"><button class="openAccount">Open new account</button>
    </a>
    <button class="closeAccount">Close account</button>
    <br><br>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>
    
    <ul class="accountList">
    <?php foreach(readData()as $account) { ?>
        <li>
        <span>ID: <?= $account ['id'] ?></span>
        <span> Name: <?= $account['name'] ?></span>
        <span> Surname: <?= $account['lastName'] ?></span>
        <span> Date of birth: <?= $account['dateOfBirth'] ?></span>
        <span> National identity number: <?= $account['personalIdentityNumber'] ?></span>
        <span> Account number: <?= $account['accountNumber'] ?></span>
        <span> Funds available: <?= $account['balance'] ?></span>

        </li>
    <?php } ?>; 
    </ul>

</body>
</html>
