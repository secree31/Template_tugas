<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['TbLogin'])) {
    $errors = [];

    // Ambil input dan bersihkan
    $TxtUserID = trim($_POST['TxtUserID'] ?? '');
    $TxtPassID = trim($_POST['TxtPassID'] ?? '');

    // Validasi
    if (empty($TxtUserID)) $errors[] = "Username kosong";
    if (empty($TxtPassID)) $errors[] = "Password kosong";

    // Autentikasi
    if (empty($errors)) {
        $validUsername = 'admin';
        $validPassword = 'admin'; // Simulasi password

        if ($TxtUserID === $validUsername && $TxtPassID === $validPassword) {
            session_regenerate_id(true);
            $_SESSION['SES_USERPLG'] = $TxtUserID;

            echo "<b>Login berhasil. Redirect ke menu admin...</b>";
            header("refresh:2;url=admin.php"); // Redirect setelah 2 detik
            exit;
        } else {
            $errors[] = "Username atau Password salah";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background-color: #f0f4ff; padding: 40px; }
        table { background-color: #dfe9ff; padding: 20px; border-radius: 10px; }
        td { padding: 8px; }
        input[type="text"], input[type="password"] { padding: 5px; width: 200px; }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Login Form</h2>

<?php
if (!empty($errors)) {
    echo "<div class='error'><b>Error:</b><br>";
    foreach ($errors as $error) echo "- $error<br>";
    echo "</div>";
}
?>

<form method="post" action="">
    <table>
        <tr>
            <td><label for="TxtUserID">User</label></td>
            <td>: <input type="text" name="TxtUserID" id="TxtUserID" maxlength="30" required></td>
        </tr>
        <tr>
            <td><label for="TxtPassID">Password</label></td>
            <td>: <input type="password" name="TxtPassID" id="TxtPassID" maxlength="30" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="TbLogin" value="Login"></td>
        </tr>
    </table>
</form>

</body>
</html>

<?php
session_start();

if (!isset($_SESSION['SES_USERPLG'])) {
    echo "Akses ditolak. Silakan <a href='index.php'>login</a> terlebih dahulu.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
</head>
<body>
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['SES_USERPLG']) ?>!</h2>
    <p>Ini adalah halaman admin.</p>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
