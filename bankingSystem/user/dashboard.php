<?php
require_once '../includes/auth.php';
redirectIfNotLoggedIn();

if (isManager()) {
    header("Location: ../manager/dashboard.php");
    exit();
}

require_once '../includes/functions.php';
$accounts = getUserAccounts($_SESSION['user_id']);
?>

<?php include '../includes/header.php'; ?>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">User Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="create_account.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">Create New Account</h2>
                <p class="text-gray-600">Open a new bank account</p>
            </a>
            
            <a href="deposit.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">Deposit Money</h2>
                <p class="text-gray-600">Add funds to your account</p>
            </a>
            
            <a href="withdraw.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">Withdraw Money</h2>
                <p class="text-gray-600">Withdraw from your account</p>
            </a>
            
            <a href="balance.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">Check Balance</h2>
                <p class="text-gray-600">View your account balance</p>
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Your Accounts</h2>
            
            <?php if (empty($accounts)): ?>
                <p class="text-gray-600">You don't have any accounts yet. <a href="create_account.php" class="text-blue-500 hover:underline">Create one now</a>.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Account Number</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Account Name</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Balance</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo htmlspecialchars($account['acc_no']); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo htmlspecialchars($account['name']); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">$<?php echo number_format($account['balance'], 2); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <a href="history.php?acc_no=<?php echo $account['acc_no']; ?>" class="text-blue-500 hover:underline">View History</a>
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