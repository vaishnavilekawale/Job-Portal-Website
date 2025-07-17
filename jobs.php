<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Available Jobs - Job Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background: url('../job-portal-website/images/jobs.avif') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #fff;
      min-height: 100vh;
      padding: 30px 0;
    }

    .top-bar {
      max-width: 1100px;
      margin: 0 auto 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }

    .top-bar a {
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      transition: color 0.3s ease;
    }

    .top-bar a:hover {
      color: #ffffff;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    h2 {
      text-align: center;
      font-size: 36px;
      margin-bottom: 40px;
      color: #ffffff;
      text-shadow: 1px 1px 4px #000;
    }

    .job-card {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      padding: 25px;
      margin-bottom: 25px;
      transition: 0.3s ease;
    }

    .job-card:hover {
      transform: scale(1.015);
      background-color: rgba(255, 255, 255, 0.08);
    }

    .job-card h3 {
      margin-bottom: 14px;
      color: #00d9ff;
      font-size: 24px;
    }

    .job-card p {
      margin: 8px 0;
      color: #f1f1f1;
      font-size: 16px;
    }

    .job-buttons {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .btn {
      padding: 10px 22px;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      font-size: 15px;
    }

    .apply-btn {
      background-color: #28a745;
      color: white;
    }

    .apply-btn:hover {
      background-color: #218838;
      transform: translateY(-2px);
    }

    .save-btn {
      background-color: #007bff;
      color: white;
    }

    .save-btn:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    .no-jobs {
      text-align: center;
      color: #eee;
      font-size: 20px;
      margin-top: 50px;
    }

    @media (max-width: 768px) {
      .top-bar {
        flex-direction: column;
        gap: 10px;
      }
      .container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Top Navigation -->
  <div class="top-bar">
    <a href="applicant_dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    <a href="index.html">Home <i class="fas fa-home"></i></a>
  </div>

  <!-- Job Listings -->
  <div class="container">
    <h2><i class="fas fa-briefcase"></i> Available Jobs</h2>

    <?php
    $sql = "SELECT jobs.*, companies.company_name 
            FROM jobs 
            INNER JOIN companies ON jobs.company_id = companies.company_id 
            ORDER BY jobs.created_at DESC";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($job = mysqli_fetch_assoc($result)) {
            echo "<div class='job-card'>";
            echo "<h3><i class='fas fa-building'></i> " . htmlspecialchars($job['title']) . "</h3>";
            echo "<p><strong>🏢 Company:</strong> " . htmlspecialchars($job['company_name']) . "</p>";
            echo "<p><strong>📍 Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
            echo "<p><strong>📂 Category:</strong> " . htmlspecialchars($job['category']) . "</p>";
            echo "<p><strong>💰 Salary:</strong> " . htmlspecialchars($job['salary_range']) . "</p>";
            echo "<div class='job-buttons'>";
            echo "<a class='btn apply-btn' href='apply_job.php?job_id=" . $job['job_id'] . "'><i class='fas fa-paper-plane'></i> Apply Now</a>";
            echo "<a class='btn save-btn' href='save_job.php?job_id=" . $job['job_id'] . "'><i class='fas fa-bookmark'></i> Save Job</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-jobs'>No jobs posted yet.</p>";
    }
    ?>
  </div>

</body>
</html>
