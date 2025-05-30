<?php
include("connection.php");
session_start();

if (isset($_SESSION['user'])) {
    header('Location: user.php');
    exit();
} elseif (isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit();
}

$msg = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowl = $result->fetch_assoc();
        if ($rowl['user_type'] == 'user') {
            $_SESSION['user'] = $rowl['email'];
            $_SESSION['id'] = $rowl['id'];
            header('Location: user.php');
            exit();
        } elseif ($rowl['user_type'] == 'admin') {
            $_SESSION['admin'] = $rowl['email'];
            $_SESSION['id'] = $rowl['id'];
            header('Location: admin.php');
            exit();
        }
    } else {
        $msg = "Incorrect email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h2>Login</h2>
            <p class="msg"><?php echo htmlspecialchars($msg); ?></p>
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
            </div>
            <button class="btn font-weight-bold" name="submit">Login Now</button>
            <p>Don't have an Account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
</body>
</html>
