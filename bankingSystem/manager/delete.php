<?php
require_once '../includes/auth.php';
redirectIfNotManager();

require_once '../includes/functions.php';

if (!isset($_GET['acc_no'])) {
    header("Location: accounts.php");
    exit();
}

$acc_no = $_GET['acc_no'];

// Verify account exists
$account = getAccountByNumber($acc_no);
if (!$account) {
    header("Location: accounts.php");
    exit();
}

// Delete account
$stmt = $pdo->prepare("DELETE FROM accounts WHERE acc_no = ?");
$stmt->execute([$acc_no]);

// Delete related transactions
$stmt = $pdo->prepare("DELETE FROM transactions WHERE acc_no = ?");
$stmt->execute([$acc_no]);

header("Location: accounts.php?success=Account+deleted+successfully");
exit();
?>