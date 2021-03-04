<?php
require __DIR__.'/bootstrap.php';

//POST scenario:

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'] ?? 0;
    $id = (int) $id;
    deleteAccount($id); 
    header('Location: '.URL.'/private.php');
    exit;
}

header('Location: '.URL.'/private.php');
die;
