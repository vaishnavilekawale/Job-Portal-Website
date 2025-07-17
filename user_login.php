<?php
session_start();
include "config.php";

$email = $password = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] == 'applicant') {
                header("Location: applicant_dashboard.php");
            } elseif ($user['role'] == 'recruiter') {
                header("Location: recruiter_dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: url('../job-portal-website/images/user_login.avif') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-box {
      /* background: rgba(255, 255, 255, 0.1); */
      background: rgba(0, 0, 0, 0.6);
      padding: 40px;
      border-radius: 16px;
      backdrop-filter: blur(8px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 400px;
      color: #fff;
      text-align: center;
    }

    h2 {
      margin-bottom: 25px;
      font-size: 28px;
      color: #ffda6b;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px;
      margin-bottom: 15px;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      font-size: 15px;
    }

    input[type="email"]::placeholder,
    input[type="password"]::placeholder {
      color: #ddd;
    }

    .btn {
      background-color: #00c896;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      width: 100%;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #00a87a;
    }

    .error {
      margin-top: 10px;
      color: #ff6b6b;
      font-weight: bold;
    }

    .back-link {
      display: block;
      margin-bottom: 20px;
      color: #ffffff;
      text-decoration: none;
      font-weight: bold;
    }

    .back-link:hover {
      text-decoration: underline;
      color: #ffd700;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <a class="back-link" href="index.html">&larr; Back to Home</a>
    <h2>User Login</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login" class="btn">
    </form>
    <?php if ($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
