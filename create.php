<?php

require __DIR__.'/bootstrap.php';

$iban = 'LT601010012345678901';
// POST scenario:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? 0;
    $surname = $_POST['lastName'] ?? 0;
    $dob = $_POST['dateOfBirth'] ?? 0;
    $dob = (string) $dob;
    $idNo = $_POST['personalIdentityNumber'] ?? 0;
    $idNo = (int) $idNo; 
    $accNo = $_POST['accountNumber'] ?? 0;
    create($name, $surname, $dob, $idNo, $accNo);
    header('Location: '.URL.'private.php'); 
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New account</title>
</head>
<body>
    <h1>Open a new account</h1>
    <a href="<?= URL ?>private.php"><button class="navigation">Accounts overview</button></a>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>

    <form action="<?= URL ?>create.php" method="post">
    Your first name: <input type="text" name="name" required>
    Your last name: <input type="text" name="lastName" required>
    Your date of birth: <input type="date" name="dateOfBirth" required>
    Your personal identity number: <input type="text" name="personalIdentityNumber">
    Reserved account number: <input type="text" name="accountNumber" required readonly value="<?= $iban ?>">
    <button type="submit">Submit</button>
    </form>
    
</body>
</html>