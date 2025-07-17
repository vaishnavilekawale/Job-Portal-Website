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

    // Delete related records in child tables first
    mysqli_query($conn, "DELETE FROM applications WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM saved_jobs WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM user_profiles WHERE user_id = '$id'");
    mysqli_query($conn, "DELETE FROM companies WHERE user_id = '$id'");

    // Finally delete user
    if (mysqli_query($conn, "DELETE FROM users WHERE user_id = '$id'")) {
        $success = "✅ User deleted successfully.";
    } else {
        $success = "❌ Error deleting user: " . mysqli_error($conn);
    }
}

$result = mysqli_query($conn, "SELECT * FROM users ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Registered Users</title>
  <style>
    * { box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/admin_users.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 40px 20px;
      color: #fff;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: rgba(0, 0, 0, 0.75);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 32px;
      color: #00eaff;
      letter-spacing: 1px;
    }

    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      color: #00ffaa;
      font-weight: bold;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .success {
      background-color: rgba(0, 128, 0, 0.2);
      color: #c2ffc2;
      font-weight: bold;
      text-align: center;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(4px);
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.15);
      text-align: center;
      color: #f0f0f0;
    }

    th {
      background-color: #007BFF;
      color: #fff;
      text-transform: uppercase;
      font-size: 14px;
    }

    a.delete-btn {
      color: #ff4d4d;
      text-decoration: none;
      font-weight: bold;
    }

    a.delete-btn:hover {
      text-decoration: underline;
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        text-align: right;
        padding-left: 50%;
        position: relative;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        font-weight: bold;
        color: #ccc;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <a class="back-link" href="admin_dashboard.php">&larr; Back to Admin Dashboard</a>
    <h2>All Registered Users</h2>

    <?php if (!empty($success)): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 1; while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td data-label="No."><?= $count++ ?></td>
            <td data-label="Name"><?= htmlspecialchars($row['name']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
            <td data-label="Role"><?= ucfirst($row['role']) ?></td>
            <td data-label="Action">
              <a class="delete-btn" href="?delete=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
