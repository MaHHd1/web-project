<?php
// Include the database configuration
require_once 'C:\xampp\htdocs\projetWeb\config.php';

// Variables for dashboard statistics
$totalProducts = 0;
$topProduct = '-';
$totalRevenue = 0.00;

try {
    $pdo = Config::getConnexion();

    // Query to get total number of products
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM produit");
    $totalProducts = $stmt->fetch()['total'];

    // Query to get the top product based on quantity
    $stmt = $pdo->query("SELECT nomproduit FROM produit ORDER BY quantite DESC LIMIT 1");
    $topProductResult = $stmt->fetch();
    $topProduct = $topProductResult ? $topProductResult['nomproduit'] : '-';

    // Query to calculate total revenue (price * quantity)
    $stmt = $pdo->query("SELECT SUM(prix * quantite) AS revenue FROM produit");
    $revenueResult = $stmt->fetch();
    $totalRevenue = $revenueResult['revenue'] ?? 0.00;
} catch (Exception $e) {
    echo "Error fetching dashboard data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmnet - Admin Dashboard</title>
    <link rel="stylesheet" href="/projetWeb/View/CSS/styles.css">
    <link rel="stylesheet" href="/projetWeb/View/CSS/styleBack.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="/projetWeb/Config/backend.js" defer></script>
</head>
<body>
    <header>
        <h1>Farmnet Admin Dashboard</h1>
        <nav>
            <a href="/View/FrontOffice/index.html" class="active">Home</a>
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="reports.html">Reports</a>
            <a href="settings.html">Settings</a>
        </nav>
        <div class="navbar-lg">
            <a href="/View/FrontOffice/index.html">
                <img src="/images/Farmnet(LOGO).png" alt="Farmnet logo">
            </a>
        </div>
    </header>

    <main>
        <!-- Overview Section -->
        <section id="overview">
            <h2>Dashboard Overview</h2>

            <!-- Tools Section -->
            <section id="tools">
                <h2>Admin Tools</h2>
                <div class="tool-grid">
                    <button onclick="window.location.href='produit.php'">Manage Products</button>
                    <button onclick="exportData()">Export Data</button>
                    <button onclick="window.location.href='reports.html'">View Reports</button>
                    <button onclick="window.location.href='settings.html'">Account Settings</button>
                </div>
            </section>

            <div class="cards">
                <div class="card">
                    <h3>Total Products</h3>
                    <p id="totalProducts"><?php echo htmlspecialchars($totalProducts); ?></p>
                </div>
                <div class="card">
                    <h3>Top Product</h3>
                    <p id="topProduct"><?php echo htmlspecialchars($topProduct); ?></p>
                </div>
                <div class="card">
                    <h3>Revenue ($)</h3>
                    <p id="totalRevenue"><?php echo number_format($totalRevenue, 2); ?></p>
                </div>
            </div>
        </section>

        <!-- Graph Section -->
        <section id="product-graph">
            <h2>Product Statistics</h2>
            <canvas id="productChart" width="400" height="200"></canvas>
        </section>

    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Farmnet | Admin Dashboard</p>
        </div>
    </footer>
    <script href="Controller\backend.js"></script>
    <script href="Controller\script.js"></script>
</body>
</html>
