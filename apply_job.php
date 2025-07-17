<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null;

$message = "";

if ($job_id) {
    // Check if user already applied
    $check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND user_id = '$user_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "⚠️ You have already applied for this job.";
    } else {
        // Insert new application
        $sql = "INSERT INTO applications (job_id, user_id) VALUES ('$job_id', '$user_id')";
        if (mysqli_query($conn, $sql)) {
            $message = "✅ Application submitted successfully!";
        } else {
            $message = "❌ An error occurred while submitting your application.";
        }
    }
} else {
    $message = "❌ Invalid job ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Apply for Job</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/apply_job.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .box {
      background: rgba(0, 0, 0, 0.7);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
      max-width: 420px;
      text-align: center;
    }

    .box h2 {
      margin-top: 0;
      font-size: 28px;
      color: #00d4ff;
      letter-spacing: 1px;
    }

    .message {
      font-size: 18px;
      margin: 25px 0;
      color: #f1f1f1;
    }

    a {
      display: inline-block;
      background-color: #00d084;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    a:hover {
      background-color: #009e6f;
    }
  </style>
</head>
<body>

  <div class="box">
    <h2>Job Application</h2>
    <p class="message"><?= $message ?></p>
    <a href="jobs.php">⬅ Back to Job Listings</a>
  </div>

</body>
</html>
