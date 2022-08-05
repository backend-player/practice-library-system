<?php
include 'connection.php';

if(isset($_POST["login"])) {
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

if(empty($username)) {
    $pesan_error = "anda belum mengisi username";
} else if(empty($password)) {
    $pesan_error =  "anda belum mengisi password";
} else {
    $sql = "SELECT * FROM admin WHERE username = '$username ' && password = '$password' ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION["username"] = $username;
        header("Location:admin-home.php");
    } else {
        $pesan_error = "Username / password salah";
    }
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kotak-login">
        <form action="" method="POST">

            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-login">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-login">

            <p style="color: red; text-align: center;"><?php if (isset($pesan_error)) echo $pesan_error ?></p>

            <div class="tombol-login">
                <button type="submit" name="login">Login</button>
            </div>
            
        </form>
    </div>
</body>
</html>