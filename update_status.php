<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    $update = "UPDATE applications SET status = '$status' WHERE application_id = $application_id";
    if (mysqli_query($conn, $update)) {
        if ($status === 'accepted') {
            $date = $_POST['interview_date'] ?? '';
            $time = $_POST['interview_time'] ?? '';
            $msg  = $_POST['interview_message'] ?? '';
            $address = $_POST['interview_address'] ?? ''; // <-- new line

            $check = mysqli_query($conn, "SELECT * FROM application_updates WHERE application_id = $application_id");
            if (mysqli_num_rows($check) > 0) {
                // Update existing row
                $sql2 = "UPDATE application_updates 
                         SET interview_date='$date', interview_time='$time', message='$msg', address='$address' 
                         WHERE application_id = $application_id";
            } else {
                // Insert new row
                $sql2 = "INSERT INTO application_updates (application_id, interview_date, interview_time, message, address)
                         VALUES ($application_id, '$date', '$time', '$msg', '$address')";
            }
            mysqli_query($conn, $sql2);
        }

        header("Location: view_applications.php?msg=updated");
        exit;
    } else {
        header("Location: view_applications.php?msg=error");
        exit;
    }
}
?>
