<?php
require_once 'config.php';

$message = '';
$executed_query = '';

// Function to check if username exists - vulnerable to blind SQL injection
function check_username($username) {
    global $conn, $executed_query;
    
    // Vulnerable SQL query - no input sanitization
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $executed_query = "Executed query: " . $sql;
    
    $result = mysqli_query($conn, $sql);
    
    // Return true if username exists, false otherwise
    return ($result && mysqli_num_rows($result) > 0);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = $_POST['username'];
    
    // Call the function to check if username exists
    $exists = check_username($username);
    
    if ($exists) {
        $message = "Username <strong>$username</strong> exists in our system.";
    } else {
        $message = "Username <strong>$username</strong> does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 4: Blind SQL Injection - SQL Injection Playground</title>
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
        .instruction-box {
            background-color: #f0f9ff;
            border-left: 4px solid #0dcaf0;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Level 4: Blind SQL Injection</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Username Checker</h5>
                    </div>
                    <div class="card-body">
                        <p>Enter a username to check if it exists in our database.</p>
                        
                        <?php if ($message): ?>
                            <div class="alert <?php echo strpos($message, 'does not exist') !== false ? 'alert-warning' : 'alert-success'; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                            </div>
                            <button type="submit" class="btn btn-info">Check Username</button>
                        </form>
                        
                        <?php if (isset($executed_query)): ?>
                            <div class="query-box mt-4">
                                <strong>Debug Information:</strong><br>
                                <?php echo htmlspecialchars($executed_query); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Sample Usernames</h5>
                    </div>
                    <div class="card-body">
                        <p>Try these usernames to see if they exist:</p>
                        <ul>
                            <li><code>admin</code></li>
                            <li><code>john</code></li>
                            <li><code>jane</code></li>
                            <li><code>nonexistent</code></li>
                        </ul>
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
                        <p>Extract sensitive information from the database using blind SQL injection techniques.</p>
                        
                        <div class="hint-box">
                            <h5>Hint:</h5>
                            <p>In blind SQL injection, you don't see the query results directly. Instead, you have to infer information from the application's behavior (whether it returns true or false).</p>
                            <p>Try using SQL boolean conditions with string operations to extract data character by character.</p>
                        </div>
                        
                        <div class="instruction-box mt-3">
                            <h5>How Blind SQL Injection Works:</h5>
                            <p>Since the application only tells you if a username exists or not, you can use this to ask "yes/no" questions to the database:</p>
                            <ol>
                                <li>Use SQL boolean operators like AND and OR</li>
                                <li>Use SQL functions like SUBSTRING(), ASCII(), and CHAR()</li>
                                <li>Ask one question at a time to extract information bit by bit</li>
                            </ol>
                        </div>
                        
                        <h5>The vulnerable query looks like:</h5>
                        <pre class="bg-light p-2">SELECT * FROM users WHERE username = '$username'</pre>
                        
                        <h5 class="mt-3">Challenge:</h5>
                        <p>Extract the password of the admin user using blind SQL injection techniques.</p>
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