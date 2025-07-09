<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeVault: A Simple Banking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-black text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="../index.php" class="text-2xl font-bold">SafeVault</a>
            <div class="flex items-center space-x-4">
                <?php if (isLoggedIn()): ?>
                    <span class="font-medium">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <?php if (isManager()): ?>
                        <a href="../manager/dashboard.php" class="hover:bg-blue-700 px-3 py-2 rounded">Manager Dashboard</a>
                    <?php else: ?>
                        <a href="../user/dashboard.php" class="hover:bg-blue-700 px-3 py-2 rounded">User Dashboard</a>
                    <?php endif; ?>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="hover:bg-blue-700 px-3 py-2 rounded">Login</a>
                    <a href="register.php" class="bg-blue-500 hover:bg-blue-700 px-3 py-2 rounded">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-6">