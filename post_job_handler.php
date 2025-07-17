<?php
session_start();
include('db_connect.php');

$company_id = $_POST['company_id'];
$description = $_POST['description'];
$location = $_POST['location'];
$category = $_POST['category'];
$salary_range = $_POST['salary_range'];

$sql = "INSERT INTO jobs (company_id, description, location, category, salary_range)
        VALUES ('$company_id', '$description', '$location', '$category', '$salary_range')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Job posted successfully!'); window.location.href='dashboard.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
