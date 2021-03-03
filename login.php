<?php 

require __DIR__.'/bootstrap.php';

//Log out scenario:
if(isset($_GET['logout'])) {
    session_destroy();
    
    // alternatively:
    // unset($_SESSION['user']);
    // $_SESSION['login'] = 0;

    header('Location: '.URL.'login.php');
    exit;

    
}

// User logged-on scenario:
if(isset($_SESSION['login']) && 1 == $_SESSION['login']) {
    header('Location: '.URL.'private.php');
    exit;
}

// POST method login scenario:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = file_get_contents(__DIR__.'/users.json');
    $users = json_decode($users, 1); 

    $postName = $_POST['name'] ?? '';
    $postPassword = $_POST['password'] ?? '';
    
    foreach ($users as $user) {
        if ($postName == $user['name']) { //user validation against the file on server
            if(password_verify($postPassword, $user['password'])) { // password validation against the hashes stored on the server
                $_SESSION['login'] = 1; // set it to 1 for status logged in, 0 for logged out
                $_SESSION['user'] = $user;
                header('Location: '.URL.'private.php');
                exit;
            } 
        }
    }
    $_SESSION['error_message'] = 'Username or password supplied was incorrect.';
    header('Location: '.URL.'login.php');
    exit;
}

//Login form display scenario:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Welcome, please enter your credentials to log in to your Second Bank account.</h1>
    <?php
    //checking for a message stored on the session array:
    if(isset($_SESSION['error_message'])) { 
    //message is displayed:
    ?>
        <h3 style="color: crimson"> <?= $_SESSION['error_message']?> </h3>
        <?php
        unset($_SESSION['error_message']); //message was displayed to the user, it can now be deleted
    }    
    ?>
    <form action="<?=URL?>login.php" method="post">
        Username:<input type="text" name="name">
        Password:<input type="password" name="password">
        <button type="submit"> Login </button>
    </form>
</body>
</html>
