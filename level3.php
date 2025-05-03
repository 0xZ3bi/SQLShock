<?php
require_once 'config.php';

$product = null;
$error = '';
$executed_query = '';

// Check if product ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Vulnerable SQL query with numeric-based injection
    // Notice there are no quotes around $id because it's expected to be a number
    $sql = "SELECT * FROM products WHERE id = $id";
    
    // For educational purposes, show the actual SQL query that was executed
    $executed_query = "Executed query: " . $sql;
    
    // Execute query
    $result = mysqli_query($conn, $sql);
    
    // Check if query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        $error = "Product not found or invalid input. " . mysqli_error($conn);
    }
} else {
    $error = "Please provide a product ID.";
}

// Get all products for the sidebar
$all_products = [];
$product_sql = "SELECT id, name FROM products ORDER BY id";
$product_result = mysqli_query($conn, $product_sql);

if ($product_result) {
    while ($row = mysqli_fetch_assoc($product_result)) {
        $all_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 3: Numeric Injection - SQL Injection Playground</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid #e7e7e7;
        }
        .hint-box {
            background-color: #fffdf0;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
        }
        .query-box {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            font-family: monospace;
            overflow-x: auto;
        }
        .product-detail {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Level 3: Numeric Injection</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Sidebar with product list -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Product List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($all_products as $p): ?>
                                <a href="?id=<?php echo $p['id']; ?>" class="list-group-item list-group-item-action <?php echo (isset($_GET['id']) && $_GET['id'] == $p['id']) ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($p['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Custom ID</h5>
                    </div>
                    <div class="card-body">
                        <form method="get" action="">
                            <div class="mb-3">
                                <label for="id" class="form-label">Product ID:</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" placeholder="Enter product ID">
                            </div>
                            <button type="submit" class="btn btn-warning">View Product</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9">
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($product): ?>
                    <div class="product-detail">
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p class="text-muted">Product ID: <?php echo htmlspecialchars($product['id']); ?></p>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Description</h4>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                
                                <h4>Category</h4>
                                <p><?php echo htmlspecialchars($product['category']); ?></p>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title text-center text-success">$<?php echo htmlspecialchars($product['price']); ?></h3>
                                        <button class="btn btn-success w-100">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif (!$error): ?>
                    <div class="alert alert-info">
                        Please select a product from the list or enter a product ID.
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($executed_query)): ?>
                    <div class="query-box">
                        <strong>Debug Information:</strong><br>
                        <?php echo htmlspecialchars($executed_query); ?>
                    </div>
                <?php endif; ?>
                
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Challenge Information</h5>
                    </div>
                    <div class="card-body">
                        <h5>Objective:</h5>
                        <p>Exploit the numeric-based SQL injection vulnerability to extract data from other tables.</p>
                        
                        <div class="hint-box">
                            <h5>Hint:</h5>
                            <p>Notice how the ID parameter is not wrapped in quotes in the SQL query. This makes it vulnerable to numeric-based SQL injection.</p>
                            <p>Try using SQL logic operators like AND and OR, as well as more advanced techniques like UNION.</p>
                        </div>
                        
                        <h5>The vulnerable query looks like:</h5>
                        <pre class="bg-light p-2">SELECT * FROM products WHERE id = $id</pre>
                        
                        <h5 class="mt-3">Database Structure:</h5>
                        <p>The database contains multiple tables including:</p>
                        <ul>
                            <li><code>products</code> - the table being queried</li>
                            <li><code>customers</code> - contains customer data including credit card information</li>
                            <li><code>secrets</code> - contains sensitive information</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-3 bg-light">
        <div class="container text-center">
            <p class="text-muted mb-0">Created for educational purposes only. Do not use these techniques on real websites without permission.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 