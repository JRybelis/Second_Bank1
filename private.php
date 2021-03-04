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
    <a href="<?= URL ?>create.php"><button class="create">Open new account</button>
    </a>
    <!-- <button class="delete">Close account</button> -->
    <br><br>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>
    
    <ul class="accountList">
    <?php foreach(readData()as $account) { ?>
        <li>
        <span>ID: <?= $account ['id'] ?><br></span>
        <span> Name: <?= $account['name'] ?><br></span>
        <span> Surname: <?= $account['lastName'] ?><br></span>
        <span> Date of birth: <?= $account['dateOfBirth'] ?><br></span>
        <span> National identity number: <?= $account['personalIdentityNumber'] ?><br></span>
        <span> Account number: <?= $account['accountNumber'] ?><br></span>
        <span> Funds available: <?= $account['balance'] ?><br></span>
        <a href="<?= URL ?>deposit.php?id= <?= $account['id'] ?>"><button class="update">Make a deposit</button></a>
        <a href="<?= URL ?>withdrawal.php?id= <?= $account['id'] ?>"><button class="update">Make a withdrawal</button></a>
        <form action="<?= URL ?>delete.php?id=<?= $account['id'] ?>" method="post">
        <button type="submit" class="delete">Close the account</button></form>
        
        </li>
    <?php } ?>
    </ul>

    

</body>
</html>
