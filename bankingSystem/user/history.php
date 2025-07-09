<?php
require_once '../includes/auth.php';
redirectIfNotLoggedIn();

if (isManager()) {
    header("Location: ../manager/dashboard.php");
    exit();
}

require_once '../includes/functions.php';

if (!isset($_GET['acc_no'])) {
    header("Location: dashboard.php");
    exit();
}

$acc_no = $_GET['acc_no'];
$account = getAccountByNumber($acc_no);

// Verify the account belongs to the user
$userAccounts = getUserAccounts($_SESSION['user_id']);
$accountBelongsToUser = false;
foreach ($userAccounts as $acc) {
    if ($acc['acc_no'] === $acc_no) {
        $accountBelongsToUser = true;
        break;
    }
}

if (!$accountBelongsToUser) {
    header("Location: dashboard.php");
    exit();
}

$transactions = getAccountTransactions($acc_no);
?>

<?php include '../includes/header.php'; ?>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Transaction History</h1>
            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">
                Account: <?php echo htmlspecialchars($account['acc_no']); ?> - <?php echo htmlspecialchars($account['name']); ?>
            </h2>
            <p class="text-lg mb-6">Current Balance: <span class="font-bold">$<?php echo number_format($account['balance'], 2); ?></span></p>
            
            <?php if (empty($transactions)): ?>
                <p class="text-gray-600">No transactions found for this account.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Type</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo date('M j, Y H:i', strtotime($transaction['date'])); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <span class="inline-block px-2 py-1 rounded 
                                            <?php echo $transaction['type'] === 'deposit' || $transaction['type'] === 'account_opening' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $transaction['type'])); ?>
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 
                                        <?php echo $transaction['type'] === 'deposit' || $transaction['type'] === 'account_opening' ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo ($transaction['type'] === 'deposit' || $transaction['type'] === 'account_opening' ? '+' : '-') . '$' . number_format($transaction['amount'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>