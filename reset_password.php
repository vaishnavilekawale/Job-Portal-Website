<?php
include "config.php";

$msg = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) == 1) {
        $update = mysqli_query($conn, "UPDATE users SET password = '$new_pass' WHERE email = '$email'");
        if ($update) {
            $msg = "✅ Password reset successfully. <a href='login.php'>Login now</a>";
        } else {
            $error = "❌ Failed to update password.";
        }
    } else {
        $error = "❌ Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('../job-portal-website/images/reset_password.avif') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-box {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      padding: 40px 35px;
      border-radius: 12px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: border 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #007BFF;
    }

    .btn {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 8px;
      margin-top: 10px;
      width: 100%;
    }

    .btn:hover {
      background-color: #218838;
    }

    .msg {
      color: green;
      text-align: center;
      margin-top: 12px;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 12px;
    }

    .link {
      display: block;
      text-align: center;
      margin-bottom: 15px;
      color: #007BFF;
      text-decoration: none;
      font-weight: bold;
    }

    .link:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .form-box {
        margin: 20px;
        padding: 30px 25px;
      }
    }
  </style>
</head>
<body>

  <div class="form-box">
    <a class="link" href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>

    <h2>Reset Password</h2>

    <form method="POST">
      <input type="email" name="email" placeholder="Your Registered Email" required>
      <input type="password" name="new_password" placeholder="New Password" required>
      <input type="submit" value="Reset Password" class="btn">
    </form>

    <?php if ($msg): ?><p class="msg"><?php echo $msg; ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
  </div>

</body>
</html>
