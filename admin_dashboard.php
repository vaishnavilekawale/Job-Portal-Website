<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_dashboard.avif') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .dashboard {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 480px;
      width: 90%;
    }

    h2 {
      font-size: 28px;
      color: #007BFF;
      margin-bottom: 30px;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 20px 0;
    }

    a {
      display: inline-block;
      width: 100%;
      padding: 14px;
      background-color: #007BFF;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    a:hover {
      background-color: #0056b3;
    }

    @media (max-width: 600px) {
      .dashboard {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h2>Welcome, Admin</h2>
    <ul>
      <li><a href="admin_users.php">👤 Manage Users</a></li>
      <li><a href="admin_jobs.php">💼 Manage Jobs</a></li>
      <li><a href="admin_applications.php">📄 View Applications</a></li>
      <li><a href="admin_logout.php">🚪 Logout</a></li>
    </ul>
  </div>

</body>
</html>
