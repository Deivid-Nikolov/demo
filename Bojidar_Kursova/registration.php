<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Регистрация</title>
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
    if (isset($_REQUEST['username'])) {

        $username = stripslashes($_REQUEST['username']);

        $username = mysqli_real_escape_string($link, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($link, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($link, $password);
        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($link, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Вие се регистрирахте успешно.</h3><br/>
                  <p class='link'>Натиснете тук за <a href='login.php'>вход</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Някои от задължителните полета са празни.</h3><br/>
                  <p class='link'>Натиснете тук за <a href='registration.php'>регистрация</a> отново.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Регистрация</h1>
        <input type="text" class="login-input" name="username" placeholder="Потребителско име" required />
        <input type="text" class="login-input" name="email" placeholder="Имейл">
        <input type="password" class="login-input" name="password" placeholder="Парола">
        <input type="submit" name="submit" value="Регистрация" class="login-button">
        <p class="link">Вече имате акаунт? <a href="login.php">Вход към системата!</a></p>
    </form>
<?php
    }
?>
</body>
</html>
