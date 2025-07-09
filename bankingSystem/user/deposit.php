<?php
require_once '../includes/auth.php';
redirectIfNotLoggedIn();

if (isManager()) {
    header("Location: ../manager/dashboard.php");
    exit();
}

require_once '../includes/functions.php';

$error = '';
$success = '';
$accounts = getUserAccounts($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acc_no = trim($_POST['acc_no']);
    $amount = trim($_POST['amount']);
    
    if (empty($acc_no) || empty($amount)) {
        $error = 'Please fill in all fields';
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $error = 'Amount must be a positive number';
    } else {
        // Verify the account belongs to the user
        $accountExists = false;
        foreach ($accounts as $account) {
            if ($account['acc_no'] === $acc_no) {
                $accountExists = true;
                break;
            }
        }
        
        if (!$accountExists) {
            $error = 'Invalid account number';
        } else {
            // Update account balance
            $stmt = $pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE acc_no = ?");
            if ($stmt->execute([$amount, $acc_no])) {
                // Record the transaction
                $stmt = $pdo->prepare("INSERT INTO transactions (acc_no, type, amount) VALUES (?, 'deposit', ?)");
                $stmt->execute([$acc_no, $amount]);
                
                $success = "Successfully deposited $" . number_format($amount, 2) . " to account $acc_no";
            } else {
                $error = 'Failed to process deposit. Please try again.';
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-4">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Deposit Money</h1>
                </div>
                
                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="deposit.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="acc_no">Account Number</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                id="acc_no" name="acc_no" required>
                            <option value="">Select Account</option>
                            <?php foreach ($accounts as $account): ?>
                                <option value="<?php echo htmlspecialchars($account['acc_no']); ?>">
                                    <?php echo htmlspecialchars($account['acc_no']); ?> - <?php echo htmlspecialchars($account['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">Amount ($)</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="amount" name="amount" type="number" step="0.01" min="0.01" placeholder="0.00" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                                type="submit">
                            Deposit
                        </button>
                        <a href="dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>