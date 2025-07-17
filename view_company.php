<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$company = null;
$msg = '';

// Fetch company based on logged-in user
$sql = "SELECT * FROM companies WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $company = mysqli_fetch_assoc($result);
} else {
    $msg = "❌ You haven't added your company details yet!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Company Info</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/view_company.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      padding: 40px;
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

    .info {
      font-size: 18px;
      line-height: 1.8;
    }

    .info strong {
      color: #00ff9d;
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

    .message {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      color: #ffdddd;
    }

    @media (max-width: 600px) {
      .container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <a href="recruiter_dashboard.php" class="back-btn">&larr; Back to Dashboard</a>
  <h2>🏢 My Company Details</h2>

  <?php if ($company): ?>
    <div class="info">
      <p><strong>Company Name:</strong> <?= htmlspecialchars($company['company_name']) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($company['location']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($company['email']) ?></p>
      <p><strong>Registered On:</strong> <?= date("d M Y, h:i A", strtotime($company['created_at'])) ?></p>
    </div>
  <?php else: ?>
    <p class="message"><?= $msg ?></p>
  <?php endif; ?>
</div>

</body>
</html>
