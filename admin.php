<?php
include("connection.php");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$admin_email = $_SESSION['admin'];
$log_time = date("Y-m-d H:i:s");
$log_message = "[$log_time] Admin login accessed by: $admin_email\n";
file_put_contents("admin_log.txt", $log_message, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="user-page">
        <h2>Welcome to Admin page!</h2>
        <p>Admin: <span><?php echo htmlspecialchars($_SESSION['admin']); ?></span></p>
        <a href="logout.php"><button class="btn font-weight-bold">Logout</button></a>
    </div>
</body>
</html>
