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

function patronAge(string $dob) {
    $today = new DateTime('now');
    $dob = date_create_from_format('!Y-m-d', $dob);
    $dateDifference = date_diff($today, $dob);
    $patronAge = ($dateDifference -> format('%y'));
    return $patronAge;
}


// Account create scenario:
function ibanGenerator() : string {
    $iban[] = "L";
    $iban[] = "T";
    for ($i = 0; $i < 18; $i++){
        $iban[] = rand(0, 9);
    }
    $iban = implode('', $iban);
    return $iban;
}


function create(string $name, string $surname, string $gender, string $dob, string $idNo, string $accNo, float $balance = 0) : void {
    $accounts = readData();
    $id = getNextId();
    $account = [
        'id' => $id,
        'name' => $name,
        'lastName' => $surname,
        'gender' => $gender,
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
            unset($accounts[$key]);
            writeData($accounts);
            return;
        }
    }
}

//validations:
function checkName(string $stringInput) {
    return preg_match("/^[[\p{L}]+[\p{L}\'\-\]{0,26}+]$/", $stringInput) ? true : false;
}

function idNoFormat(string $idNo) {
    return preg_match("/^\p{N}{0,11}+$/", $idNo) ? true : false;
}

function idCoefficient(array $idArray) : int {
    $multiplier = 1;
    $idDigitSum = 0;
    foreach ($idArray as $key => $value) {
        if ($key == sizeof($idArray)) {
            if ($idDigitSum % 11 != 10) {
                $controlNo = ceil($idDigitSum % 11);
                return $controlNo;
            } else {
                $idDigitSum = 0;
                $multiplier = 3;
                foreach($idArray as $key => $value) {
                    if ($key == sizeof($idArray)) {
                        if ($idDigitSum % 11 != 10) {
                            $controlNo = ceil($idDigitSum % 11);
                            return $controlNo;
                        } else {
                            $controlNo = 0;
                        }
                    }
                    if ($key == sizeof($idArray-3)) {
                        $multiplier = 1;
                    }
                    $idDigitSum += $value * $multiplier;
                    $multiplier ++;
                }
            }
        }
        if ($key == sizeof($idArray-1)) {
            $multiplier = 1;
        }
        $idDigitSum += $value * $multiplier;
        $multiplier ++;
}}
// 3  8  9 0  7  2  5 1  6 3 
// 3+16+27+0+35+12+35+8+54+3 = 193
// 193 % 11 = 17.54545454545455
