<?php

require __DIR__.'/bootstrap.php';

$iban = 'LT601010012345678901';

// POST scenario:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? 0;
    $surnname = $_POST['lastName'] ?? 0;
    $dob = $_POST['dateOfBirth'] ?? 0;
    $accNo = $_POST['accountNumber'] ?? 0;
    $idNo = $_POST['personalIdentityNumber'] ?? 0;
    create($name, $surname, $dob, $accNo, $idNo);
    header('Location: '.URL); 
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
    <a href="<?= URL ?>create.php">Open an account</a>
    <a href="<?= URL ?>">Back to home page</a>

    <form action="<?= URL ?>create.php" method="post">
    Your first name: <input type="text" name="name" required>
    Your last name: <input type="text" name="lastName" required>
    Your date of birth: <input type="date" name="dateOfBirth" required>
    Account number: <input type="text" name="accountNumber" required readonly value="<?= $iban ?>">
    Your personal identity number: <input type="text" name="personalIdentityNumber">
    <button type="submit">Submit</button>
    </form>
    
</body>
</html>