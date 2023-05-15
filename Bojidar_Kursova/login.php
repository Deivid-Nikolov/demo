<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Вход</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        body{
            background: repeating-linear-gradient(transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), repeating-linear-gradient(90deg, transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), #ebffe4;
            background-blend-mode: multiply;
            background-color: #ebffe4;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form{
            border-radius: 15px;
            background-color: aliceblue;
            box-shadow: 0 0 10px 10px black;
        }
        .form > h1,h3,a,p{
            color:black !important;
        }
    </style>
</head>
<body>
<?php
    require('config.php');
    session_start();
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($link, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($link, $password);

        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($link, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;

            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Невалидно потребителско име или парола.</h3><br/>
                  <p class='link'>Натиснете тук за <a href='login.php'>вход</a> отново.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Вход</h1>
        <input type="text" class="login-input" name="username" placeholder="Потребителско име" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Парола"/>
        <input type="submit" value="Вход" name="submit" class="login-button"/>
        <p class="link">Нямате акаунт? <a href="registration.php">Регистрирайте се сега!</a></p>
  </form>
<?php
    }
?>
</body>
</html>
