<?php

require __DIR__.'/bootstrap.php';

// $iban = 'LT601010012345678901';
$iban = ibanGenerator();

// POST scenario:
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? 0;
    $surname = $_POST['lastName'] ?? 0;
    $gender = $_POST['gender'] ?? 0;
    $gender = (string) $gender;
    $dob = $_POST['dateOfBirth'] ?? 0;
    $dob = (string) $dob;
    $idNo = $_POST['personalIdentityNumber'] ?? 0;
    $idArray = str_split($idNo, 1);
    $accNo = $_POST['accountNumber'] ?? 0;
    
    if(strlen($name) < 2) {
        $errorDisplayStatus = 'block';
        $nameError = 'Your first name must be at least two characters long. Use of initials is not allowed.';
    } elseif (checkName($name) == false) {
        $errorDisplayStatus = 'block';
        $nameError = 'Your name must contain letters only.';
    } elseif (strlen($surname) < 2) { // does not fire?? 
        $errorDisplayStatus = 'block';
        $invalidSurnameLengthError = 'Your surname must be at least two characters long. Use of initials is not allowed.';
        _d(checkName($surname));
        _d($surname);
        _d(strlen($surname));
    } elseif (checkName($surname) == false) {
        $errorDisplayStatus = 'block';
        $surnameError = 'Your last name must contain letters only.';
    } elseif (patronAge($dob) < 18) {
        $errorDisplayStatus = 'block';
        $invalidAgeError = 'Second Bank follows the national regulation on not permitting minors to independently open and operate bank accounts. If you still wish to open an account, please call our client service at +370 666 70417 to discuss your options.';
    } elseif (idNoFormat($idNo) == false) {
        $errorDisplayStatus = 'block';
        $invalidIdError = 'Please ensure your personal identity code consists of digits only and is 11 characters long.';
    } elseif (
        ($dob < '2000-01-01' && $idArray[0] != 3 && $gender == 'male') || 
        ($dob < '2000-01-01' && $idArray[0] == 3 && $gender == 'female') || 
        ($dob < '2000-01-01' && $idArray[0] != 4 && $gender == 'female') || 
        ($dob < '2000-01-01' && $idArray[0] == 4 && $gender == 'male') ||  
        ($dob >= '2000-01-01' && $idArray[0] != 5 && $gender == 'male') ||
        ($dob >= '2000-01-01' && $idArray[0] == 5 && $gender == 'female') ||
        ($dob >= '2000-01-01' && $idArray[0] != 6 && $gender == 'female') ||
        ($dob >= '2000-01-01' && $idArray[0] == 6 && $gender == 'male') 
        ) {
        $errorDisplayStatus = 'block';
        $invalidIdError = 'Please ensure the first digit of your personal identity code is correct.';
        
        _d('DOB is before 2000: ');
        _d($dob < '2000-01-01');
        _d('ID does not start with 3: ');
        _d($idArray[0] != 3);
        _d('ID starts with: ');
        _d($idArray[0]);
        _d('The gender supplied is: ');
        _d($gender);

    } elseif ((substr($dob, 2, 2).substr($dob, 5,2).substr($dob, 8, 2)) != substr($idNo, 1, 6) ) {
        $errorDisplayStatus = 'block';
        $invalidIdError = 'Please ensure the second through to the seventh digits of your personal identity code are correct.';
    } elseif (idCoefficient($idArray) != $idArray[10]) {
        $errorDisplayStatus = 'block';
        $invalidIdError = 'Please ensure the last digit of your personal identity code is correct.';
    }
    else {
        patronAge($dob);
        create($name, $surname, $gender, $dob, $idNo, $accNo);
        header('Location: '.URL.'private.php'); 
        _d($gender);
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
        <br> Your first name: <input type="text" name="name" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $nameError ?? '' ?></span><br>

        <br> Your last name: <input type="text" name="lastName" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $surnameError ?? '' ?></span><br>

        <br> Your gender: <br><br>
            <input type="radio" id= "male" name="gender" value="male" required>
            <label for="male">Male</label><br>
            <input type="radio" id= "female" name="gender" value="female" required>
            <label for="female">Female</label><br>
        <br>
        
        <br> Your date of birth: <input type="date" name="dateOfBirth" required> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidAgeError ?? '' ?></span><br>
        
        <br> Your personal identity number: <input type="text" name="personalIdentityNumber"> <br><span style="display: <?= $errorDisplayStatus ?? 'none' ?>"><?= $invalidIdError ?? '' ?></span><br>
        
        <br> Reserved account number: <input type="text" name="accountNumber" required readonly value="<?= $iban ?>"> 
        
        <br> <button type="submit">Submit</button>
    </form>
    
</body>
</html>