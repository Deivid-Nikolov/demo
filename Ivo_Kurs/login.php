<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Вход</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        body{
            background-image: url(agenda-analysis-business-990818-1.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form{
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 0 10px 10px cornsilk;
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
