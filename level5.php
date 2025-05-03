<?php
require_once 'config.php';

$category = '';
$results = [];
$executed_query = '';
$error = '';

// Get all categories for dropdown
$categories = [];
$category_sql = "SELECT DISTINCT category FROM products ORDER BY category";
$category_result = mysqli_query($conn, $category_sql);

if ($category_result) {
    while ($row = mysqli_fetch_assoc($category_result)) {
        $categories[] = $row['category'];
    }
}

// Check if a category is selected
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    
    // Vulnerable query - direct user input in SQL
    $sql = "SELECT id, name, description, price, category FROM products WHERE category = '$category' ORDER BY name";
    
    // For educational purposes, show the actual SQL query that was executed
    $executed_query = "Executed query: " . $sql;
    
    // Execute query
    $result = mysqli_query($conn, $sql);
    
    // Check if query successful
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }
    } else {
        $error = "Error executing query: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 5: UNION-based Injection - SQL Injection Playground</title>
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
        .advanced-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Level 5: UNION-based Injection</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Product Category Browser</h5>
                    </div>
                    <div class="card-body">
                        <form method="get" action="" class="mb-4">
                            <div class="input-group">
                                <select class="form-select" name="category" id="category">
                                    <option value="" disabled selected>Select a category...</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($category === $cat) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-danger" type="submit">Browse</button>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Or enter a custom category name:</small>
                                <input type="text" class="form-control mt-1" name="custom_category" placeholder="Enter custom category...">
                                <button class="btn btn-outline-danger btn-sm mt-2" type="submit" onclick="submitCustom(); return false;">Submit Custom Category</button>
                            </div>
                        </form>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($results)): ?>
                            <h5>Products in category: <?php echo htmlspecialchars($category); ?></h5>
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
                        <?php elseif (isset($_GET['category'])): ?>
                            <div class="alert alert-info">
                                No products found in the selected category.
                            </div>
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
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Challenge Information</h5>
                    </div>
                    <div class="card-body">
                        <h5>Objective:</h5>
                        <p>Use UNION-based SQL injection to extract data from other tables in the database.</p>
                        
                        <div class="hint-box">
                            <h5>Hint:</h5>
                            <p>The UNION operator combines the results of two or more SELECT statements. For UNION to work, each SELECT statement must:</p>
                            <ul>
                                <li>Have the same number of columns</li>
                                <li>Have compatible data types in corresponding columns</li>
                            </ul>
                        </div>
                        
                        <div class="advanced-box mt-3">
                            <h5>Advanced Challenges:</h5>
                            <ol>
                                <li>Extract all usernames and passwords from the users table</li>
                                <li>Get the database version information</li>
                                <li>List all tables in the database</li>
                                <li>Retrieve data from the secrets table</li>
                            </ol>
                        </div>
                        
                        <h5>The vulnerable query looks like:</h5>
                        <pre class="bg-light p-2">SELECT id, name, description, price, category FROM products WHERE category = '$category' ORDER BY name</pre>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Schema Information</h5>
                    </div>
                    <div class="card-body">
                        <p>These tables exist in the database:</p>
                        <ul>
                            <li><strong>products</strong> - Product information</li>
                            <li><strong>users</strong> - User accounts</li>
                            <li><strong>customers</strong> - Customer data</li>
                            <li><strong>secrets</strong> - Sensitive information</li>
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

    <script>
        function submitCustom() {
            const customValue = document.querySelector('input[name="custom_category"]').value;
            if (customValue) {
                document.querySelector('select[name="category"]').value = '';
                document.querySelector('form').submit();
            }
        }
        
        // Set the category field based on custom input if provided
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const customValue = document.querySelector('input[name="custom_category"]').value;
                if (customValue) {
                    document.querySelector('select[name="category"]').disabled = true;
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'category';
                    hiddenInput.value = customValue;
                    form.appendChild(hiddenInput);
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 