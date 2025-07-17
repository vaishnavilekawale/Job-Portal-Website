<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'recruiter') {
    header("Location: user_login.php");
    exit;
}

$msg = "";

// Fetch companies linked to the logged-in recruiter
$recruiter_id = $_SESSION['user_id'];
$company_query = "SELECT * FROM companies WHERE user_id = $recruiter_id";
$company_result = mysqli_query($conn, $company_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_id  = $_POST['company_id'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $category    = $_POST['category'];
    $salary      = $_POST['salary'];

    $sql = "INSERT INTO jobs (company_id, title, description, location, category, salary_range) 
            VALUES ('$company_id', '$title', '$description', '$location', '$category', '$salary')";

    if (mysqli_query($conn, $sql)) {
        $msg = "✅ Job posted successfully!";
    } else {
        $msg = "❌ Error posting job.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Post a Job</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('images/post_job.avif') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 600px;
      color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
      color: #00f7ff;
    }

    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: none;
      font-size: 15px;
      background-color: rgba(255, 255, 255, 0.15);
      color: #fff;
      outline: none;
    }

    select option {
      color: #000;
    }

    textarea {
      resize: vertical;
      height: 120px;
    }

    input::placeholder,
    textarea::placeholder {
      color: #ddd;
    }

    input[type="submit"] {
      width: 100%;
      padding: 14px;
      background: #00d084;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
    }

    input[type="submit"]:hover {
      background: #009e6f;
    }

    .back-btn {
      display: inline-block;
      margin-bottom: 20px;
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
    }

    .back-btn:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
      margin-top: 20px;
      font-weight: bold;
      color: #fff;
    }

    @media (max-width: 600px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <a href="recruiter_dashboard.php" class="back-btn">&larr; Back to Dashboard</a>
    <h2>📄 Post a New Job</h2>
    <form method="POST">
      <select name="company_id" required>
        <option value="">-- Select Company --</option>
        <?php while ($row = mysqli_fetch_assoc($company_result)) : ?>
            <option value="<?= $row['company_id'] ?>"><?= htmlspecialchars($row['company_name']) ?></option>
        <?php endwhile; ?>
      </select>

      <input type="text" name="title" placeholder="Job Title" required>
      <textarea name="description" placeholder="Job Description" required></textarea>
      <input type="text" name="location" placeholder="Location" required>
      <input type="text" name="category" placeholder="Category" required>
      <input type="text" name="salary" placeholder="Salary Range (e.g. ₹25,000 - ₹50,000)" required>
      <input type="submit" value="Post Job">
    </form>
    <?php if ($msg): ?>
      <p><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>
  </div>

</body>
</html>
