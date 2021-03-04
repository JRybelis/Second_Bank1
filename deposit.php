<?php
require __DIR__.'/bootstrap.php';

//POST scenario:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'] ?? 0;
    $id = (int) $id;

    $amount = $_POST['amount'] ?? 0;
    $amount = (int) $amount;
    if($amount > 25000 ) {
        $errorDisplayStatus = 'block';
        $invalidAmountError = 'Following the governmental anti-money-laundering directives, Second Bank does not permit electronic deposits worth over £25000. Please visit one of our branches to make your intended deposit, or try a lower amount.';
    } elseif ($amount == 0 || $amount < 0) {
        $errorDisplayStatus = 'block';
        $invalidAmountError = 'You must deposit a positive amount of money.';
    }
     else {
        deposit($id, $amount);    
        header('Location: '.URL.'private.php');
        exit;
    }
    
    
    
}

// GET scenario:
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'] ?? 0;
    $id = (int) $id;
    $account = selectAccount($id);
    if(!$account) {
        header('Location: '.URL.'private.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit money</title>
</head>
<body>
    <h1>Add money to your account here:</h1>
    <a href="<?= URL.'private.php' ?>"><button class="navigation">Back to account overview</button></a>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>
    
    <form action="<?= URL ?>deposit.php?id= <?= $account['id'] ?>" method="post">Money to deposit:
    <input type="text" name="amount">
    <span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidAmountError ?></span>
    <button type="submit">Submit</button>
    </form>
</body>
</html>