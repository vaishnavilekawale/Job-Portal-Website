<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Applicant Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background-image: url('../job-portal-website/images/applicant_dashboard.avif');
      font-family: 'Segoe UI', sans-serif;
      /* background: linear-gradient(to right, #6dd5ed, #2193b0); */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .dashboard {
      background: white;
      padding: 40px 50px;
      border-radius: 15px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      text-align: center;
      width: 100%;
      max-width: 450px;
      position: relative;
    }

    .dashboard h2 {
      margin-bottom: 25px;
      color: #333;
    }

    .dashboard ul {
      list-style: none;
      padding: 0;
    }

    .dashboard li {
      margin: 15px 0;
    }

    .btn-link {
      display: block;
      background: linear-gradient(to right, #007bff, #0056b3);
      color: white;
      padding: 14px;
      text-decoration: none;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .btn-link:hover {
      background: linear-gradient(to right, #0056b3, #004080);
      transform: translateY(-2px);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 14px;
      text-decoration: none;
      color: #555;
      background-color: #e2e6ea;
      padding: 6px 12px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .back-home:hover {
      background-color: #d6d8db;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <a href="index.html" class="back-home"><i class="fas fa-home"></i> Home</a>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h2>
    <ul>
      <li><a class="btn-link" href="jobs.php"><i class="fas fa-briefcase"></i> View Jobs</a></li>
      <li><a class="btn-link" href="view_applications.php"><i class="fas fa-list-alt"></i> My Applications</a></li>
      <li><a class="btn-link" href="upload_resume.php"><i class="fas fa-file-upload"></i> Upload Resume</a></li>
      <li><a class="btn-link" href="saved_jobs.php"><i class="fas fa-bookmark"></i> My Saved Jobs</a></li>
      <li><a class="btn-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>
</body>
</html>
