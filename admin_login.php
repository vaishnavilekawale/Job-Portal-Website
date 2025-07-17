<?php
session_start();
include "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $email;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_login.avif') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-box {
      background: rgba(0, 0, 0, 0.75);
      /* background: rgba(255, 255, 255, 0.08); */
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      color: #fff;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      color: #fff;
      text-shadow: 1px 1px 4px #000;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      background-color: rgba(255, 255, 255, 0.15);
      color: #fff;
    }

    .login-box input::placeholder {
      color: #eee;
    }

    .login-box input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #007BFF;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }

    .login-box input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .error {
      text-align: center;
      color: #ff4d4d;
      margin-top: 15px;
      font-weight: bold;
    }

    .top-link {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .top-link a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 8px 14px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .top-link a:hover {
      background-color: rgba(0, 0, 0, 0.6);
    }
  </style>
</head>
<body>

  <div class="top-link">
    <a href="index.html">&larr; Back to Home</a>
  </div>

  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
    </form>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
  </div>

</body>
</html>
