<?php
require_once 'config.php';

$search_term = '';
$results = [];
$executed_query = '';

// Check if the form was submitted
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    
    // Vulnerable SQL query with string-based injection
    $sql = "SELECT * FROM products WHERE name LIKE '%$search_term%' OR description LIKE '%$search_term%'";
    
    // Execute query
    $result = mysqli_query($conn, $sql);
    
    // For educational purposes, show the actual SQL query that was executed
    $executed_query = "Executed query: " . $sql;
    
    // Fetch all results
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 2: String-based Injection - SQL Injection Playground</title>
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
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Level 2: String-based Injection</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Product Search</h5>
                    </div>
                    <div class="card-body">
                        <form method="get" action="" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search for products..." value="<?php echo htmlspecialchars($search_term); ?>">
                                <button class="btn btn-success" type="submit">Search</button>
                            </div>
                        </form>
                        
                        <?php if (!empty($results)): ?>
                            <h5>Search Results:</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $product): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                                <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php elseif (isset($_GET['search'])): ?>
                            <div class="alert alert-info">No products found matching your search term.</div>
                        <?php endif; ?>
                        
                        <?php if (!empty($executed_query)): ?>
                            <div class="query-box">
                                <strong>Debug Information:</strong><br>
                                <?php echo htmlspecialchars($executed_query); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Challenge Information</h5>
                    </div>
                    <div class="card-body">
                        <h5>Objective:</h5>
                        <p>Extract information from other tables in the database using string-based SQL injection.</p>
                        
                        <div class="hint-box">
                            <h5>Hint:</h5>
                            <p>The search term is directly inserted into a query. Try using SQL string manipulations and the UNION operator to extract data from other tables.</p>
                            <p>First, you'll need to figure out how many columns are in the current result set to make your UNION query work.</p>
                        </div>
                        
                        <h5>The vulnerable query looks like:</h5>
                        <pre class="bg-light p-2">SELECT * FROM products WHERE name LIKE '%$search_term%' OR description LIKE '%$search_term%'</pre>
                        
                        <h5 class="mt-3">Database Structure:</h5>
                        <p>The database contains multiple tables including:</p>
                        <ul>
                            <li><code>products</code> - the table being queried</li>
                            <li><code>users</code> - contains username, password, and admin status</li>
                            <li><code>secrets</code> - contains sensitive information</li>
                        </ul>
                        
                        <h5 class="mt-3">Sample Search Terms:</h5>
                        <ul>
                            <li><code>laptop</code> - normal search</li>
                            <li><code>electronics</code> - category search</li>
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