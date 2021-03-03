<?php

session_start();

define('URL', 'http://localhost/second_bank/'); 
define('DIR',__DIR__.'/');

require DIR. 'resources/app/functions.php';

_d($_SESSION, 'Session -->');