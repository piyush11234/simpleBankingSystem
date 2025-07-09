<?php
require_once __DIR__ . '/../config/database.php';

function generateAccountNumber() {
    return 'AC' . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
}

function getUserAccounts($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAccountByNumber($accNo) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE acc_no = ?");
    $stmt->execute([$accNo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAccountTransactions($accNo) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE acc_no = ? ORDER BY date DESC");
    $stmt->execute([$accNo]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllAccounts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM accounts ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransactions() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM transactions ORDER BY date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchAccounts($query) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE name LIKE ? OR acc_no LIKE ?");
    $stmt->execute(["%$query%", "%$query%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sortAccountsByBalance($order = 'DESC') {
    global $pdo;
    $order = $order === 'ASC' ? 'ASC' : 'DESC';
    $stmt = $pdo->prepare("SELECT * FROM accounts ORDER BY balance $order");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>