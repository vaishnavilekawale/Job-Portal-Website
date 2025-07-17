<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT 
    users.name AS applicant, 
    jobs.title AS job, 
    applications.applied_at, 
    applications.status,
    au.interview_date,
    au.interview_time,
    au.message,
    au.address,
    companies.company_name AS company_name
FROM applications
JOIN users ON applications.user_id = users.user_id
JOIN jobs ON applications.job_id = jobs.job_id
JOIN companies ON jobs.company_id = companies.company_id
LEFT JOIN application_updates au ON applications.application_id = au.application_id
ORDER BY applications.applied_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Applications</title>
  <style>
    * { box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('../job-portal-website/images/admin_applications.avif') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 40px 10px;
        color: #fff;
    }

    .container {
        max-width: 1400px;
        margin: auto;
        background: rgba(0, 0, 0, 0.8);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        overflow-x: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 34px;
        color: #00d4ff;
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

    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(4px);
        margin-top: 10px;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 14px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        text-align: center;
        color: #f0f0f0;
        font-size: 14px;
    }

    th {
        background-color: #007BFF;
        color: #fff;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .status {
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-block;
    }
    .status.applied {
        background-color: #6c757d;
        color: #fff;
    }
    .status.accepted {
        background-color: #28a745;
        color: #fff;
    }
    .status.rejected {
        background-color: #dc3545;
        color: #fff;
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
    <h2>All Job Applications</h2>
    <table>
      <thead>
        <tr>
          <th>Applicant</th>
          <th>Job Title</th>
          <th>Company</th>
          <th>Applied On</th>
          <th>Status</th>
          <th>Interview Date</th>
          <th>Interview Time</th>
          <th>Message</th>
          <th>Address</th>
        </tr>
      </thead>
      <tbody>
      <?php while($row = mysqli_fetch_assoc($result)): 
        $statusClass = strtolower($row['status']); // applied / accepted / rejected
      ?>
      <tr>
        <td data-label="Applicant"><?= htmlspecialchars($row['applicant']) ?></td>
        <td data-label="Job Title"><?= htmlspecialchars($row['job']) ?></td>
        <td data-label="Company"><?= htmlspecialchars($row['company_name']) ?></td>
        <td data-label="Applied On"><?= date("d M Y, h:i A", strtotime($row['applied_at'])) ?></td>
        <td data-label="Status">
          <span class="status <?= $statusClass ?>"><?= ucfirst($row['status']) ?></span>
        </td>
        <td data-label="Interview Date"><?= $row['interview_date'] ?? '-' ?></td>
        <td data-label="Interview Time"><?= $row['interview_time'] ? date("h:i A", strtotime($row['interview_time'])) : '-' ?></td>
        <td data-label="Message"><?= htmlspecialchars($row['message'] ?? '-') ?></td>
        <td data-label="Address"><?= htmlspecialchars($row['address'] ?? '-') ?></td>
      </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
