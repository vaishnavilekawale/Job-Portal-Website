<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Recruiter Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('../job-portal-website/images/recruiter_dashboard.avif') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .dashboard {
      background: rgba(0, 0, 0, 0.7);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.4);
      max-width: 480px;
      width: 90%;
      text-align: center;
    }

    .dashboard h2 {
      font-size: 26px;
      margin-bottom: 30px;
      color: #00d4ff;
      text-shadow: 1px 1px 4px #000;
    }

    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 14px;
      text-decoration: none;
      background-color: #6c757d;
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
    }

    .back-home:hover {
      background-color: #5a6268;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 20px 0;
    }

    a.btn-link {
      display: inline-block;
      width: 100%;
      padding: 14px;
      background: #00b894;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      transition: background 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    a.btn-link:hover {
      background: #00a67d;
    }

    @media (max-width: 600px) {
      .dashboard {
        padding: 25px;
      }

      .dashboard h2 {
        font-size: 22px;
      }

      a.btn-link {
        font-size: 15px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>

  <a href="index.html" class="back-home">&larr; Home</a>

  <div class="dashboard">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (Recruiter)</h2>
    <ul>
      <li><a class="btn-link" href="add_company.php">🏢 Add/Update Company</a></li>
      <li><a class="btn-link" href="view_company.php">🏢 View My Company</a></li>
      <li><a class="btn-link" href="post_job.php">📝 Post New Job</a></li>
      <li><a class="btn-link" href="view_applications.php">📄 View Applications</a></li>
      <li><a class="btn-link" href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>

</body>
</html>
