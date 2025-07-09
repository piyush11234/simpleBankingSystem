<?php
require_once '../includes/auth.php';
redirectIfNotManager();

require_once '../includes/functions.php';
?>

<?php include '../includes/header.php'; ?>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">Manager Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="accounts.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">View All Accounts</h2>
                <p class="text-gray-600">Manage customer accounts</p>
            </a>
            
            <a href="transactions.php" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">View All Transactions</h2>
                <p class="text-gray-600">Monitor all transactions</p>
            </a>
            
            <a href="../logout.php" class="bg-red-500 text-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold mb-2">Logout</h2>
                <p class="text-white opacity-90">Sign out of the system</p>
            </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Quick Stats</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php
                // Total accounts
                $stmt = $pdo->query("SELECT COUNT(*) as total_accounts FROM accounts");
                $total_accounts = $stmt->fetch(PDO::FETCH_ASSOC)['total_accounts'];
                
                // Total balance
                $stmt = $pdo->query("SELECT SUM(balance) as total_balance FROM accounts");
                $total_balance = $stmt->fetch(PDO::FETCH_ASSOC)['total_balance'];
                
                // Total transactions
                $stmt = $pdo->query("SELECT COUNT(*) as total_transactions FROM transactions");
                $total_transactions = $stmt->fetch(PDO::FETCH_ASSOC)['total_transactions'];
                ?>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-800">Total Accounts</h3>
                    <p class="text-2xl font-bold text-blue-600"><?php echo $total_accounts; ?></p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-green-800">Total Balance</h3>
                    <p class="text-2xl font-bold text-green-600">$<?php echo number_format($total_balance, 2); ?></p>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-purple-800">Total Transactions</h3>
                    <p class="text-2xl font-bold text-purple-600"><?php echo $total_transactions; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>