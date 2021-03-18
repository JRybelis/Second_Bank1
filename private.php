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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <script> const uriPath = '<?= URL ?>';</script>
    <script src="<?= URL?>resources/app/app.js" defer></script>
    <title>Private</title>
    <link rel="stylesheet" href="http://localhost/second_bank/public/css/app.css?ver=<?= time() ?>"

</head>
<body>
    <h1>Hello, <?= $_SESSION['user']['name']?> <?=$_SESSION['user']['surname']?></h1>
    <br><br>
    <a href="<?= URL ?>login.php?logout"><button class="navigation">LogOut</button></a> 
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>
    <br><br>
    
    <!-- <a href="<?= URL ?>create.php"><button type="button" class="create btn btn-info">Open new account</button>
    </a>
    <br><br> -->
    <a href="<?= URL ?>create.php"><button type="button" class="create btn btn-info">Open new account</button>
    </a>
    <br><br>
    
    <ul style="list-style-type: none; display: inline-block" class="container-fluid accountList">
    <li class="row">
        <span class="col account">ID:<br></span>
        <span class="col-1 account"> Name:<br></span>
        <span class="col-1 account"> Surname:<br></span>
        <span class="col account"> Gender:<br></span>
        <span class="col-1 account"> Date of birth:<br></span>
        <span class="col-2 account"> National identity number:<br></span>
        <span class="col-2 account"> Account number:<br></span>
        <span class="col account"> Funds available: €<br></span>
        
    <?php foreach(readData() as $account) { ?>
    <li class="row">
        <span class="col account"><?= $account ['id'] ?><br></span>
        <span class="col-1 account"><?= $account['name'] ?><br></span>
        <span class="col-1 account"><?= $account['lastName'] ?><br></span>
        <span class="col account"><?= $account['gender'] ?><br></span>
        <span class="col-1 account"><?= $account['dateOfBirth'] ?><br></span>
        <span class="col-2 account"><?= $account['personalIdentityNumber'] ?><br></span>
        <span class="col-2 account"><?= $account['accountNumber'] ?><br></span>
        <span class="col account"><?= $account['balance'] ?><br></span> 
        <span class="display: inline-block col-4">
            <a href="<?= URL ?>deposit.php?id= <?= $account['id'] ?>"><button class="update">Make a deposit</button></a>
            <a href="<?= URL ?>withdrawal.php?id= <?= $account['id'] ?>"><button class="update">Make a withdrawal</button></a>
            <form class="display: inline-block" action="<?= URL ?>delete.php?id=<?= $account['id'] ?>" method="post">
            <button type="submit" class="delete">Close the account</button></form>
        </span>
        <br><br>
        </li>
    <?php } ?>
    </ul>

    

</body>
</html>
