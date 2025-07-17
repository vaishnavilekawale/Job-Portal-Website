<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resume"])) {
    if (!empty($_FILES["resume"]["name"])) {
        $targetDir = "uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES["resume"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePath)) {
            $check = mysqli_query($conn, "SELECT * FROM user_profiles WHERE user_id = '$user_id'");
            if (mysqli_num_rows($check) > 0) {
                $sql = "UPDATE user_profiles SET resume = '$targetFilePath' WHERE user_id = '$user_id'";
            } else {
                $sql = "INSERT INTO user_profiles (user_id, resume) VALUES ('$user_id', '$targetFilePath')";
            }

            $msg = mysqli_query($conn, $sql)
                ? "<span style='color: #00ff99;'>✅ Resume uploaded successfully!</span>"
                : "<span style='color: #ff4d4d;'>❌ Database error.</span>";
        } else {
            $msg = "<span style='color: #ff4d4d;'>❌ File upload failed.</span>";
        }
    } else {
        $msg = "<span style='color: orange;'>⚠️ Please select a file.</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Upload Resume</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: url('../job-portal-website/images/upload_resume.avif') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .back-link {
      position: absolute;
      top: 20px;
      left: 30px;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      background-color: #ff4081;
      padding: 10px 20px;
      border-radius: 30px;
      transition: background 0.3s ease;
    }

    .back-link:hover {
      background-color: #c2185b;
    }

    .container {
      max-width: 450px;
      margin: 120px auto;
      padding: 40px;
      background: rgba(0, 0, 0, 0.6);
      /* background: rgba(255, 255, 255, 0.1); */
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      margin-bottom: 20px;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #00bcd4;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #0097a7;
    }

    p {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      font-size: 16px;
    }

    ::file-selector-button {
      background-color: #6200ea;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 6px 12px;
      cursor: pointer;
    }

    ::file-selector-button:hover {
      background-color: #3700b3;
    }
  </style>
</head>
<body>

  <a href="applicant_dashboard.php" class="back-link">&larr; Back to Dashboard</a>

  <div class="container">
    <h2>Upload Your Resume</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="resume" required><br>
      <input type="submit" value="Upload Resume">
    </form>
    <p><?php echo $msg; ?></p>
  </div>
</body>
</html>
