<?php

function readData() : array {
    if(!file_exists(DIR.'resources/data/accounts.json')) {
        $data = json_encode([]);
        file_put_contents(DIR.'resources/data/accounts.json', $data);
    }
    $data = file_get_contents(DIR.'resources/data/accounts.json');
    return json_decode($data, 1);
}

function writeData(array $data) : void {
    $data = json_encode($data);
    file_put_contents(DIR. 'resources/data/accounts.json', $data);
}

// Each time this function is run, $index['id'] is increased by 1 and the new value is returned
function getNextId() : int {
    if(!file_exists(DIR.'resources/data/indexes.json')){
        $index = json_encode(['id' => 1]);
        file_put_contents(DIR.'resources/data/indexes.json', $index);
    }
    $index = file_get_contents(DIR.'resources/data/indexes.json');
    $index = json_decode($index, 1);
    $id = (int) $index['id'];
    $index['id'] = $id + 1;
    $index = json_encode($index);
    file_put_contents(DIR.'resources/data/indexes.json', $index);
    return $id;
}


// Account create scenario:
function create(string $name, string $surname, string $dob, string $idNo, string $accNo, float $balance = 0) : void {
    $accounts = readData();
    // $today = new DateTime('now');
    // $patronAge = $today - $dob;
    // if($patronAge < 18) {
    //     $_SESSION['error_message'] = 'Second Bank follows the national regulation in not permitting minors to open and operate bank accounts. If you still wish to open an account, please call our client service at +370 666 70417 to discuss your options.';
    //     header('Location'.URL.'private.php');
    //     exit;
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
    $id = getNextId();
    $account = [
        'id' => $id,
        'name' => $name,
        'lastName' => $surname,
        'dateOfBirth' => $dob,
        'personalIdentityNumber' => $idNo,
        'accountNumber' => $accNo,
        'balance' => $balance
    ];
    $accounts[] = $account;
    writeData($accounts);
}

function selectAccount(int $id) : ?array {
    foreach(readData() as $account) {
        if ($account['id'] == $id) {
            return $account;
        }
    }
    return null;
}

// account update scenario
function deposit(int $id, $amount) : void {
    $accounts = readData(); // all accounts on file.
    $account = selectAccount($id);
    if(!$account) {
        return;
    }
    $account['balance'] += $amount;
    deleteAccount($id);
    $accounts = readData(); // accounts on file, without the one selected, which was deleted, in order to be replaced with the updated one.
    $accounts[] = $account;
    writeData($accounts);
}

function withdraw(int $id, $amount) : void {
    $accounts = readData(); // all accounts on file.
    $account = selectAccount($id);
    if(!$account) {
        return;
    }
    $account['balance'] -= $amount;
    deleteAccount($id);
    $accounts = readData(); // accounts on file, without the one selected, which was deleted, in order to be replaced with the updated one.
    $accounts[] = $account;
    writeData($accounts);
}

// account delete scenario
function deleteAccount(int $id) : void {
    $accounts = readData();
    foreach($accounts as $key => $account){
        if ($account ['id'] == $id) {
            _d($accounts[$key]);
            unset($accounts[$key]);
            writeData($accounts);
            return;
        }
    }
}

