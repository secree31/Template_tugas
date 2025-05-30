<?php
include("connection.php");
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$user_email = $_SESSION['user'];
$log_time = date("Y-m-d H:i:s");
$log_message = "[$log_time] User login accessed by: $user_email\n";
file_put_contents("user_log.txt", $log_message, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="user-page">
        <h2>Welcome to User page!</h2>
        <p>User: <span><?php echo htmlspecialchars($_SESSION['user']); ?></span></p>
        <a href="logout.php"><button class="btn font-weight-bold">Logout</button></a>
    </div>
</body>
</html>
