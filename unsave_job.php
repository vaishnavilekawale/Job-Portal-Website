<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? null;

if ($job_id) {
    $sql = "DELETE FROM saved_jobs WHERE user_id = '$user_id' AND job_id = '$job_id'";
    mysqli_query($conn, $sql);
}

header("Location: saved_jobs.php?message=" . urlencode("✅ Job unsaved successfully."));
exit;
