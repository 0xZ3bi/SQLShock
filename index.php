<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Playground</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .challenge-card {
            transition: transform 0.3s;
        }
        .challenge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid #e7e7e7;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="display-4 text-center">SQL Injection Playground</h1>
            <p class="lead text-center text-muted">An educational tool to learn about SQL injection vulnerabilities</p>
            <div class="alert alert-danger text-center" role="alert">
                <strong>Warning:</strong> This application is intentionally vulnerable. For educational purposes only!
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Level 1 -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Level 1: Login Bypass</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">A simple login form vulnerable to basic SQL injection. Can you bypass the authentication?</p>
                        <p class="card-text"><strong>Difficulty:</strong> Easy</p>
                    </div>
                    <div class="card-footer">
                        <a href="level1.php" class="btn btn-primary w-100">Start Challenge</a>
                    </div>
                </div>
            </div>

            <!-- Level 2 -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Level 2: String-based Injection</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Search functionality with string-based SQL injection vulnerability. Extract hidden information!</p>
                        <p class="card-text"><strong>Difficulty:</strong> Medium</p>
                    </div>
                    <div class="card-footer">
                        <a href="level2.php" class="btn btn-success w-100">Start Challenge</a>
                    </div>
                </div>
            </div>

            <!-- Level 3 -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">Level 3: Numeric Injection</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">A product page with numeric parameter vulnerability. Extract data using numeric SQL injection.</p>
                        <p class="card-text"><strong>Difficulty:</strong> Medium</p>
                    </div>
                    <div class="card-footer">
                        <a href="level3.php" class="btn btn-warning w-100">Start Challenge</a>
                    </div>
                </div>
            </div>

            <!-- Level 4 -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">Level 4: Blind SQL Injection</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Practice blind SQL injection techniques where you don't see the query results directly.</p>
                        <p class="card-text"><strong>Difficulty:</strong> Hard</p>
                    </div>
                    <div class="card-footer">
                        <a href="level4.php" class="btn btn-info w-100">Start Challenge</a>
                    </div>
                </div>
            </div>

            <!-- Level 5 -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">Level 5: UNION-based Injection</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Advanced SQL injection using UNION operator to combine results from different tables.</p>
                        <p class="card-text"><strong>Difficulty:</strong> Very Hard</p>
                    </div>
                    <div class="card-footer">
                        <a href="level5.php" class="btn btn-danger w-100">Start Challenge</a>
                    </div>
                </div>
            </div>

            <!-- Resources -->
            <div class="col-md-4 mb-4">
                <div class="card challenge-card h-100">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">Resources & Solutions</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Learn how SQL injections work, prevention techniques, and solutions to the challenges.</p>
                    </div>
                    <div class="card-footer">
                        <a href="resources.php" class="btn btn-secondary w-100">View Resources</a>
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