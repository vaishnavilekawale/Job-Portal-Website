<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$success = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Step 1: Delete dependent records first
    mysqli_query($conn, "DELETE FROM applications WHERE job_id = '$id'");
    mysqli_query($conn, "DELETE FROM saved_jobs WHERE job_id = '$id'");

    // Step 2: Delete the job itself
    if (mysqli_query($conn, "DELETE FROM jobs WHERE job_id = '$id'")) {
        $success = "✅ Job deleted successfully.";
    } else {
        $success = "❌ Failed to delete job: " . mysqli_error($conn);
    }
}

// Fetch jobs
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Jobs</title>
  <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('../job-portal-website/images/admin_jobs.avif') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
        min-height: 100vh;
        padding: 40px 20px;
    }

    .container {
        max-width: 1100px;
        margin: auto;
        background: rgba(0, 0, 0, 0.6);
        padding: 40px;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    h2 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 30px;
        color: #00d4ff;
    }

    .back-home {
        display: inline-block;
        margin-bottom: 20px;
        color: #00d084;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }

    .back-home:hover {
        text-decoration: underline;
        color: #00ffaa;
    }

    .success {
        text-align: center;
        color: #00ffb3;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(4px);
    }

    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
        color: #fff;
    }

    th {
        background-color: #007BFF;
        color: #fff;
        text-transform: uppercase;
        font-size: 15px;
    }

    tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    a.delete-btn {
        color: #ff4d4d;
        font-weight: bold;
        text-decoration: none;
    }

    a.delete-btn:hover {
        text-decoration: underline;
        color: #ff1a1a;
    }

    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }

        th {
            display: none;
        }

        td {
            padding: 10px;
            text-align: right;
            position: relative;
        }

        td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            font-weight: bold;
            color: #ccc;
            text-align: left;
        }
    }
  </style>
</head>
<body>
  <div class="container">
    <a class="back-home" href="admin_dashboard.php">&larr; Back to Admin Dashboard</a>
    <h2>All Job Listings</h2>

    <?php if (!empty($success)): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <table>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Location</th>
        <th>Salary</th>
        <th>Action</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td data-label="ID"><?= $row['job_id'] ?></td>
        <td data-label="Title"><?= $row['title'] ?></td>
        <td data-label="Category"><?= $row['category'] ?></td>
        <td data-label="Location"><?= $row['location'] ?></td>
        <td data-label="Salary"><?= $row['salary_range'] ?></td>
        <td data-label="Action">
          <a class="delete-btn" href="?delete=<?= $row['job_id'] ?>" onclick="return confirm('Delete this job?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
