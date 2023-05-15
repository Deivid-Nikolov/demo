<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Вход</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        body{
            background-image: linear-gradient(to right bottom, #28536b, #2f6774, #467b77, #668d7a, #8a9d80, #a2a88b, #b8b399, #cdbfa9, #d9caba, #e4d6cb, #ede3dc, #f6f0ed);
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        html{
            height: 100%;
            box-sizing: border-box;
        }
        .form{
            background-color: beige;
            box-shadow: 0 0 10px 10px skyblue;
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
