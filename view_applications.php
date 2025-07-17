<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Applications</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: url('../job-portal-website/images/view_applications.avif') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .back-link {
      position: absolute;
      top: 20px;
      left: 30px;
      color: #fff;
      font-weight: bold;
      text-decoration: none;
      background-color: #ff4081;
      padding: 10px 20px;
      border-radius: 30px;
      transition: background 0.3s;
    }
    .back-link:hover { background-color: #d81b60; }

    .container {
      max-width: 900px;
      margin: 100px auto;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }

    h2 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 32px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .app-card {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.2);
      padding: 25px;
      border-radius: 15px;
      margin-bottom: 25px;
    }

    .status {
      padding: 5px 15px;
      border-radius: 20px;
      font-weight: bold;
      color: #000;
      display: inline-block;
    }
    .applied { background: #17a2b8; }
    .accepted { background: #28a745; }
    .rejected { background: #dc3545; }

    .msg {
      text-align: center;
      font-weight: bold;
      margin: 20px 0;
      color: #00ff99;
      font-size: 18px;
    }
    .msg.error { color: #ff4d4d; }

    .form-inline {
      margin-top: 15px;
    }

    .form-inline input,
    .form-inline textarea,
    .form-inline select {
      margin: 8px 0;
      width: 100%;
      padding: 10px 14px;
      border-radius: 12px;
      border: none;
      font-size: 15px;
      background: rgba(255,255,255,0.2);
      color: #000;
    }

    .form-inline select option {
      color: #000;
    }

    .form-inline button {
      margin-top: 12px;
      width: 100%;
      background: #ff9800;
      padding: 10px 0;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      transition: background 0.3s;
    }

    .form-inline button:hover { background: #e67e00; }

    .no-apps {
      text-align: center;
      font-size: 20px;
      color: #eee;
    }

    /* .resume-link a {
      color: #00f;
      text-decoration: underline;
    } */

      .resume-box {
            display: inline-block;
            padding: 6px 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 8px;
          }

          .resume-box a {
            color: #00f7ff;
            text-decoration: none;
          }

          .resume-box a:hover {
            text-decoration: underline;
          }


  </style>
</head>
<body>

<?php if ($role === 'applicant'): ?>
  <a href="applicant_dashboard.php" class="back-link">&larr; Dashboard</a>
<?php else: ?>
  <a href="recruiter_dashboard.php" class="back-link">&larr; Dashboard</a>
<?php endif; ?>

<div class="container">
  <h2>Applications</h2>

  <?php if (isset($_GET['msg'])): ?>
    <div class="msg <?php echo ($_GET['msg'] === 'error') ? 'error' : ''; ?>">
      <?php echo $_GET['msg'] === 'updated' ? "✅ Status updated successfully!" : "❌ Failed to update status!"; ?>
    </div>
  <?php endif; ?>

  <?php
  if ($role === 'applicant') {
      $sql = "SELECT a.application_id, j.title, j.location, a.applied_at, a.status,
                     au.interview_date, au.interview_time, au.message, au.address,
                     c.company_name
              FROM applications a
              JOIN jobs j ON a.job_id = j.job_id
              JOIN companies c ON j.company_id = c.company_id
              LEFT JOIN application_updates au ON a.application_id = au.application_id
              WHERE a.user_id = '$user_id'
              ORDER BY a.applied_at DESC";
  } else {
      $sql = "SELECT a.application_id, u.name, j.title, a.applied_at, a.status,
                     au.interview_date, au.interview_time, au.message, au.address,
                     c.company_name, up.resume
              FROM applications a
              JOIN users u ON a.user_id = u.user_id
              JOIN jobs j ON a.job_id = j.job_id
              JOIN companies c ON j.company_id = c.company_id
              LEFT JOIN user_profiles up ON u.user_id = up.user_id
              LEFT JOIN application_updates au ON a.application_id = au.application_id
              WHERE c.user_id = '$user_id'
              ORDER BY a.applied_at DESC";
  }

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $status = $row['status'];
          echo "<div class='app-card'>";

          if ($role === 'applicant') {
              echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
              echo "<p><strong>Job:</strong> " . htmlspecialchars($row['title']) . "</p>";
              echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
              echo "<p><strong>Applied on:</strong> " . $row['applied_at'] . "</p>";
              echo "<p><strong>Status:</strong> <span class='status $status'>" . ucfirst($status) . "</span></p>";

              if ($status === 'accepted' && $row['interview_date']) {
                  $formattedTime = date("h:i A", strtotime($row['interview_time']));
                  echo "<p><strong>📅 Interview Date:</strong> " . $row['interview_date'] . "</p>";
                  echo "<p><strong>⏰ Time:</strong> " . $formattedTime . "</p>";
                  echo "<p><strong>📝 Message:</strong> " . htmlspecialchars($row['message']) . "</p>";
                  echo "<p><strong>📍 Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
              }
          } else {
              echo "<p><strong>Applicant:</strong> " . htmlspecialchars($row['name']) . "</p>";
              echo "<p><strong>Company:</strong> " . htmlspecialchars($row['company_name']) . "</p>";
              echo "<p><strong>Job:</strong> " . htmlspecialchars($row['title']) . "</p>";
              echo "<p><strong>Date:</strong> " . $row['applied_at'] . "</p>";

              // Resume
              if (!empty($row['resume'])) {
                  echo "<div class='resume-box'>
                          <a href='" . htmlspecialchars($row['resume']) . "' target='_blank'>Resume</a>
                        </div>";
              } else {
                  echo "<div class='resume-box'>Resume not uploaded</div>";
              }
              echo "<form class='form-inline' method='post' action='update_status.php'>
                      <input type='hidden' name='application_id' value='" . $row['application_id'] . "'>
                      <select name='status' required>
                          <option value='applied' " . ($status === 'applied' ? 'selected' : '') . ">Applied</option>
                          <option value='accepted' " . ($status === 'accepted' ? 'selected' : '') . ">Accepted</option>
                          <option value='rejected' " . ($status === 'rejected' ? 'selected' : '') . ">Rejected</option>
                      </select>";

              echo "<div id='interviewFields{$row['application_id']}' style='display:" . ($status === 'accepted' ? 'block' : 'none') . ";'>
                      <input type='date' name='interview_date' placeholder='Interview Date'>
                      <input type='time' name='interview_time' placeholder='Interview Time'>
                      <textarea name='interview_message' placeholder='Message to applicant'></textarea>
                      <input type='text' name='interview_address' placeholder='Interview Address'>
                    </div>";

              echo "<button type='submit'>Update</button>
                    </form>";

              echo "<script>
                      document.querySelectorAll('select[name=\"status\"]').forEach(select => {
                        select.addEventListener('change', function() {
                          const formId = 'interviewFields' + this.parentElement.querySelector('input[name=\"application_id\"]').value;
                          if (this.value === 'accepted') {
                            document.getElementById(formId).style.display = 'block';
                          } else {
                            document.getElementById(formId).style.display = 'none';
                          }
                        });
                      });
                    </script>";
          }

          echo "</div>";
      }
  } else {
      echo "<p class='no-apps'>No applications found.</p>";
  }
  ?>
</div>
</body>
</html>
