<?php
require __DIR__.'/bootstrap.php';

//POST scenario:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'] ?? 0;
    $id = (int) $id;

    $amount = $_POST['amount'] ?? 0;
    $amount = (int) $amount;
    withdraw($id, $amount);
    header('Location: '.URL.'private.php');
    exit;
    
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
    <title>Withdraw money</title>
</head>
<body>
    <h1>Retrieve money from your account here:</h1>
    <a href="<?= URL.'private.php' ?>"><button class="navigation">Back to account overview</button></a>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>
    
    <form action="<?= URL ?>withdrawal.php?id= <?= $account['id'] ?>" method="post">Money to withdraw:
    <input type="text" name="amount">
    <button type="submit">Submit</button>
    </form>
</body>
</html>