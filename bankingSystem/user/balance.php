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
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-4">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Account Balances</h1>
                </div>
                
                <?php if (empty($accounts)): ?>
                    <p class="text-gray-600">You don't have any accounts yet. <a href="create_account.php" class="text-blue-500 hover:underline">Create one now</a>.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($accounts as $account): ?>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($account['name']); ?></h3>
                                <p class="text-gray-600">Account: <?php echo htmlspecialchars($account['acc_no']); ?></p>
                                <p class="text-2xl font-bold mt-2">$<?php echo number_format($account['balance'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="mt-6 text-center">
                    <a href="dashboard.php" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>