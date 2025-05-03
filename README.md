## 🧨 SQLShock

**SQLShock** is an intentionally vulnerable web application designed for **educational** and **training** purposes in SQL Injection. It features **5 progressively challenging levels** to help users understand how SQL injection works, how attackers exploit it, and how to defend against it.

> ⚠️ **Warning:** This application is intentionally insecure. **DO NOT** deploy it on public-facing servers or use it in production environments.

---

## ⚙️ Setup Instructions

1. Install a local web server environment such as **WAMP**, **XAMPP**, or **Laragon** (must support PHP & MySQL).
2. Clone or download this repository into your server’s web directory:

   * For XAMPP: `htdocs/`
   * For WAMP: `www/`
3. Import the `database.sql` file into your MySQL server via **phpMyAdmin** or the **MySQL CLI**.
4. Edit the `config.php` file to match your database credentials.
5. Open your browser and navigate to:
   `http://localhost/SQLShock`

---

## 🧪 Levels Breakdown

* **Level 1:** Basic login bypass
* **Level 2:** String-based injection
* **Level 3:** Numeric-based injection
* **Level 4:** Blind SQL injection (Boolean-based)
* **Level 5:** UNION-based injection

---

## 🎯 Educational Purpose

This tool is designed to help learners:

* Understand **how SQL injection vulnerabilities occur**
* Explore **real-world attack techniques**
* Learn **secure coding practices** and **mitigation strategies**
  (Solutions are available in the `solutions/` directory)

---

## 📜 Legal Disclaimer

> This tool is for **educational use only** in **controlled lab environments**.
> Performing unauthorized testing on websites or systems you do not own is **illegal** and **unethical**.
