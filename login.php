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
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Job Portal</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('../job-portal-website/images/login.avif') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px 35px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 420px;
    }

    h2 {
      text-align: center;
      color: #2a2a2a;
      margin-bottom: 25px;
      font-weight: 600;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 14px 12px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .btn {
      background: linear-gradient(to right, #007bff, #0056b3);
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background: linear-gradient(to right, #0056b3, #003d80);
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 12px;
      font-weight: 500;
    }

    .link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #007BFF;
      font-weight: 500;
      text-decoration: none;
    }

    .link:hover {
      text-decoration: underline;
    }

    .top-link {
      display: block;
      text-align: left;
      margin-bottom: 10px;
      color: #007BFF;
      text-decoration: none;
      font-weight: bold;
    }

    .top-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-box">
    <a class="top-link" href="index.html">&larr; Back to Home</a>
    <h2>Login to Your Account</h2>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login" class="btn">
    </form>

    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>

    <a class="link" href="reset_password.php">Forgot Password?</a>
    <a class="link" href="register.php">New user? Register here</a>
  </div>

</body>
</html>
