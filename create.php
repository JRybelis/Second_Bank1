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
    
    // } elseif (
    //     $dob < '2000-01-01' && $dob[0] != 3 || 
    //     $dob < '2000-01-01' && $dob[0] != 4 || 
    //     $dob > '2000-01-01' && $dob[0] != 5 || 
    //     $dob > '2000-01-01' && $dob[0] != 6) 
    //     {
    //     $_SESSION['error_message'] = 'Please double check your personal identity number and / or date of birth was entered correctly and try again.';
    //     header('Location'.URL.'private.php');
    //     exit;
    // } elseif () 
    if(strlen($name) < 2) {
        $errorDisplayStatus = 'block';
        $invalidNameLengthError = 'Your first name must be at least two characters long. Use of initials is not allowed.';
    } elseif (strlen($surname) < 2) {
        $errorDisplayStatus = 'block';
        $invalidSurnameLengthError = 'Your surname must be at least two characters long. Use of initials is not allowed.';
    } elseif (patronAge($dob) < 18) {
        $errorDisplayStatus = 'block';
        $invalidAgeError = 'Second Bank follows the national regulation on not permitting minors to independently open and operate bank accounts. If you still wish to open an account, please call our client service at +370 666 70417 to discuss your options.';
    } else {
        patronAge($dob);
        create($name, $surname, $dob, $idNo, $accNo);
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
    <title>New account</title>
</head>
<body>
    <h1>Open a new account</h1>
    <a href="<?= URL ?>private.php"><button class="navigation">Accounts overview</button></a>
    <a href="<?= URL ?>"><button class="navigation">Back to home page</button></a>

    <form action="<?= URL ?>create.php" method="post">
        <br> Your first name: <input type="text" name="name" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidNameLengthError ?></span><br>

        <br> Your last name: <input type="text" name="lastName" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidSurnameLengthError ?></span><br>
        
        <br> Your date of birth: <input type="date" name="dateOfBirth" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidAgeError ?></span><br>
        
        <br> Your personal identity number: <input type="text" name="personalIdentityNumber"> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidIdError ?></span><br>
        
        <br> Reserved account number: <input type="text" name="accountNumber" required readonly value="<?= $iban ?>"> 
        
        <br> <button type="submit">Submit</button>
    </form>
    
</body>
</html>