<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT jobs.* FROM saved_jobs 
        JOIN jobs ON saved_jobs.job_id = jobs.job_id 
        WHERE saved_jobs.user_id = '$user_id' 
        ORDER BY saved_jobs.saved_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Saved Jobs</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/saved_jobs.avif') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .container {
      max-width: 900px;
      margin: 80px auto;
      padding: 40px;
      background: rgba(0, 0, 0, 0.6);
      /* background: rgba(255, 255, 255, 0.1); */
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    a.back-link {
      display: inline-block;
      margin-bottom: 20px;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      background-color: #ff4081;
      padding: 10px 20px;
      border-radius: 30px;
      transition: background 0.3s ease;
    }

    a.back-link:hover {
      background-color: #c2185b;
    }

    h2 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 32px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .message {
      text-align: center;
      color: #00ff99;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .job-card {
      background: rgba(255,255,255,0.08);
      padding: 25px;
      border-radius: 16px;
      margin-bottom: 25px;
      border-left: 5px solid #00bcd4;
      transition: transform 0.2s ease;
    }

    .job-card:hover {
      transform: scale(1.01);
    }

    .job-card h3 {
      margin: 0 0 10px;
      color: #00bcd4;
    }

    .job-card p {
      margin: 5px 0;
      color: #eee;
    }

    .job-actions {
      display: flex;
      justify-content: flex-start;
      gap: 15px;
      margin-top: 15px;
    }

    .apply-btn,
    .unsave-btn {
      text-decoration: none;
      padding: 10px 18px;
      border-radius: 30px;
      font-weight: bold;
      font-size: 14px;
      transition: background 0.3s ease;
      display: inline-block;
    }

    .apply-btn {
      background-color: #28a745;
      color: white;
    }

    .apply-btn:hover {
      background-color: #218838;
    }

    .unsave-btn {
      background-color: #dc3545;
      color: white;
    }

    .unsave-btn:hover {
      background-color: #c82333;
    }

    .no-jobs {
      text-align: center;
      font-size: 18px;
      margin-top: 50px;
      color: #eee;
    }

    @media screen and (max-width: 600px) {
      .job-actions {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <a href="applicant_dashboard.php" class="back-link">&larr; Back to Dashboard</a>
    <h2>My Saved Jobs</h2>

    <?php if (isset($_GET['message'])): ?>
      <p class="message"><?= htmlspecialchars($_GET['message']) ?></p>
    <?php endif; ?>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($job = mysqli_fetch_assoc($result)) {
            echo "<div class='job-card'>";
            echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
            echo "<p><strong>Location:</strong> " . htmlspecialchars($job['location']) . "</p>";
            echo "<p><strong>Category:</strong> " . htmlspecialchars($job['category']) . "</p>";
            echo "<p><strong>Salary:</strong> " . htmlspecialchars($job['salary_range']) . "</p>";
            echo "<div class='job-actions'>";
            echo "<a class='apply-btn' href='apply_job.php?job_id=" . $job['job_id'] . "'>Apply Now</a>";
            echo "<a class='unsave-btn' href='unsave_job.php?job_id=" . $job['job_id'] . "' onclick=\"return confirm('Unsave this job?')\">Unsave</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-jobs'>You haven’t saved any jobs yet.</p>";
    }
    ?>
  </div>
</body>
</html>
