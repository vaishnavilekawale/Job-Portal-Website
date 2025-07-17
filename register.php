<?php
session_start();
include "config.php";

$name = $email = $password = $role = "";
$msg = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "This email is already registered. Try logging in.";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Registered successfully. You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Job Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('../job-portal-website/images/register.avif');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-box {
      background: rgba(255, 255, 255, 0.97);
      padding: 40px 35px;
      border-radius: 12px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    input, select {
      width: 100%;
      padding: 12px 14px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
      transition: border 0.3s ease;
    }

    input:focus, select:focus {
      outline: none;
      border-color: #007BFF;
    }

    .btn {
      background-color: #007BFF;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 8px;
      margin-top: 10px;
      transition: background-color 0.3s ease;
      width: 100%;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    .back-link {
      display: block;
      margin-bottom: 15px;
      text-align: left;
      color: #007BFF;
      font-weight: bold;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .msg {
      color: green;
      text-align: center;
      margin-top: 10px;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }

    @media (max-width: 480px) {
      .form-box {
        margin: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="form-box">
    <a class="back-link" href="index.html"><i class="fas fa-arrow-left"></i> Back to Home</a>

    <h2>Register</h2>

    <form method="POST" action="">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>

      <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="applicant">Applicant</option>
        <option value="recruiter">Recruiter</option>
      </select>

      <input type="submit" value="Register" class="btn">
    </form>

    <?php if ($msg): ?><p class="msg"><?php echo $msg; ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
  </div>

</body>
</html>
