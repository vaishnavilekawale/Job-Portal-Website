<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null;

if ($job_id) {
    $check = mysqli_query($conn, "SELECT * FROM saved_jobs WHERE job_id='$job_id' AND user_id='$user_id'");
    
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO saved_jobs (job_id, user_id) VALUES ('$job_id', '$user_id')";
        if (mysqli_query($conn, $sql)) {
            $msg = "✅ Job saved successfully!";
            $msg_class = "success";
        } else {
            $msg = "❌ Something went wrong.";
            $msg_class = "error";
        }
    } else {
        $msg = "⚠️ You have already saved this job.";
        $msg_class = "warning";
    }
} else {
    $msg = "❌ Invalid job ID.";
    $msg_class = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Save Job</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      background: url('../job-portal-website/images/save_job.avif') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .container {
      background: rgba(0, 0, 0, 0.7);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
      text-align: center;
      max-width: 500px;
      width: 90%;
      backdrop-filter: blur(10px);
    }

    h2 {
      font-size: 28px;
      color: #00d4ff;
    }

    .success {
      color: #00ff99;
      font-weight: bold;
      margin: 20px 0;
    }

    .error {
      color: #ff4c4c;
      font-weight: bold;
      margin: 20px 0;
    }

    .warning {
      color: #ffc107;
      font-weight: bold;
      margin: 20px 0;
    }

    a {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background: #00bcd4;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    a:hover {
      background: #0097a7;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Save Job Status</h2>
    <p class="<?= $msg_class ?>"><?= $msg ?></p>
    <a href="jobs.php">⬅ Back to Jobs</a>
  </div>
</body>
</html>
