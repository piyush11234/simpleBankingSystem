<?php
require_once '../includes/auth.php';
redirectIfNotManager();

require_once '../includes/functions.php';

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_order = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'ASC' : 'DESC';

if ($search_query) {
    $accounts = searchAccounts($search_query);
} else {
    $accounts = sortAccountsByBalance($sort_order);
}
?>

<?php include '../includes/header.php'; ?>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Accounts</h1>
            <div class="flex space-x-2">
                <a href="?sort=<?php echo $sort_order === 'DESC' ? 'asc' : 'desc'; ?>" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                    Sort by Balance (<?php echo $sort_order === 'DESC' ? 'High to Low' : 'Low to High'; ?>)
                </a>
                <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Back to Dashboard
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="accounts.php" class="mb-6">
                <div class="flex">
                    <input type="text" name="search" placeholder="Search by name or account number" 
                           class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">
                        Search
                    </button>
                </div>
                <?php if ($search_query): ?>
                    <div class="mt-2">
                        <a href="accounts.php" class="text-blue-500 hover:underline">Clear search</a>
                    </div>
                <?php endif; ?>
            </form>
            
            <?php if (empty($accounts)): ?>
                <p class="text-gray-600">No accounts found.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Account Number</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Account Name</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Balance</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Created At</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo htmlspecialchars($account['acc_no']); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo htmlspecialchars($account['name']); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">$<?php echo number_format($account['balance'], 2); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo date('M j, Y', strtotime($account['created_at'])); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <a href="delete.php?acc_no=<?php echo $account['acc_no']; ?>" 
                                           class="text-red-500 hover:text-red-700 font-bold" 
                                           onclick="return confirm('Are you sure you want to delete this account?');">
                                            Delete
                                        </a>
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