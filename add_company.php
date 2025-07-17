<?php
session_start();
include 'config.php';

$msg = '';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['company_name'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for duplicate email
    $checkQuery = "SELECT * FROM companies WHERE email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        $msg = "⚠️ Company with this email already exists!";
    } else {
        // Insert new company
        $sql = "INSERT INTO companies (user_id, company_name, location, email, password) 
                VALUES ('$user_id', '$name', '$location', '$email', '$password')";

        if (mysqli_query($conn, $sql)) {
            $msg = "✅ Company added successfully!";
        } else {
            $msg = "❌ Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Company</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/add_company.jpeg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 600px;
      color: #fff;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      color: #00f7ff;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: none;
      font-size: 15px;
      background-color: rgba(255, 255, 255, 0.15);
      color: #fff;
      outline: none;
    }

    input::placeholder {
      color: #ddd;
    }

    button {
      width: 100%;
      padding: 14px;
      background: #00d084;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background: #009e6f;
    }

    p {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      color: #fff;
    }

    .back-btn {
      display: inline-block;
      margin-bottom: 20px;
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
    }

    .back-btn:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <a href="recruiter_dashboard.php" class="back-btn">&larr; Back to Dashboard</a>
    <h2>🏢 Add Company Details</h2>
    <form method="POST">
      <input type="text" name="company_name" placeholder="Company Name" required>
      <input type="text" name="location" placeholder="Company Location" required>
      <input type="email" name="email" placeholder="Company Email" required>
      <input type="password" name="password" placeholder="Company Password" required>
      <button type="submit">Add Company</button>
    </form>
    <?php if ($msg): ?>
      <p><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>
  </div>

</body>
</html>
