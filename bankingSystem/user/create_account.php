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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $initial_balance = trim($_POST['initial_balance']);
    
    if (empty($name) || empty($initial_balance)) {
        $error = 'Please fill in all fields';
    } elseif (!is_numeric($initial_balance) || $initial_balance < 0) {
        $error = 'Initial balance must be a positive number';
    } else {
        $acc_no = generateAccountNumber();
        $stmt = $pdo->prepare("INSERT INTO accounts (acc_no, name, balance, user_id) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$acc_no, $name, $initial_balance, $_SESSION['user_id']])) {
            // Record the account opening transaction
            $stmt = $pdo->prepare("INSERT INTO transactions (acc_no, type, amount) VALUES (?, 'account_opening', ?)");
            $stmt->execute([$acc_no, $initial_balance]);
            
            $success = "Account created successfully! Your account number is: $acc_no";
        } else {
            $error = 'Failed to create account. Please try again.';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
        <div class="md:flex">
            <div class="w-full p-4">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Create New Bank Account</h1>
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
                
                <form method="POST" action="create_account.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Account Name</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="name" name="name" type="text" placeholder="Account Name" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="initial_balance">Initial Deposit ($)</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               id="initial_balance" name="initial_balance" type="number" step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                                type="submit">
                            Create Account
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