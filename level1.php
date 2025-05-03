<?php
require_once 'config.php';

$error = '';
$success = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Vulnerable SQL query - no input sanitization
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    // Execute query
    $result = mysqli_query($conn, $sql);
    
    // For educational purposes, show the actual SQL query that was executed
    $executed_query = "Executed query: " . $sql;
    
    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $success = "Login successful! Welcome, " . htmlspecialchars($user['username']) . "!";
        
        if ($user['is_admin']) {
            $success .= " <strong>(Admin access granted)</strong>";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 1: Login Bypass - SQL Injection Playground</title>
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
                <h1>Level 1: Login Bypass</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Login Form</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        
                        <?php if (isset($executed_query)): ?>
                            <div class="query-box mt-3">
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
                        <p>Bypass the login authentication and login as the admin user without knowing the password.</p>
                        
                        <div class="hint-box">
                            <h5>Hint:</h5>
                            <p>The application directly inserts your input into an SQL query without sanitization. What happens if you input special characters that have meaning in SQL syntax?</p>
                            <p>Try common SQL injection techniques for login forms.</p>
                        </div>
                        
                        <h5>The vulnerable query looks like:</h5>
                        <pre class="bg-light p-2">SELECT * FROM users WHERE username = '$username' AND password = '$password'</pre>
                        
                        <h5 class="mt-3">Sample User Accounts:</h5>
                        <ul>
                            <li>Username: john, Password: password123</li>
                            <li>Username: test, Password: test123</li>
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