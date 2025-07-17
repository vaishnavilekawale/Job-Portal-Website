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
        $error = "Email already registered. Try logging in.";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Registration successful! <a href='user_login.php'>Login here</a>";
        } else {
            $error = "Something went wrong.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Register</title>
  <style>
    body { font-family: Arial; background: #eee; padding: 40px; }
    .form-box { width: 400px; margin: auto; background: white; padding: 30px;
      border-radius: 10px; box-shadow: 0 0 10px #ccc; }
    input, select { width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; }
    .btn { background: #28a745; color: white; border: none; padding: 10px; width: 100%; }
    .msg, .error { text-align: center; margin-top: 10px; }
    .msg { color: green; } .error { color: red; }
  </style>
</head>
<body>
<div class="form-box">
  <h2>Register</h2>
  <form method="POST">
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
  <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
</div>
</body>
</html>
