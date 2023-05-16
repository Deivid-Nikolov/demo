<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css"/>

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
                  <h3 style='color:black'>Вие се регистрирахте успешно.</h3><br/>
                  <p class='link' style='color:black'>Натиснете тук за <a href='login.php'>вход</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Някои от задължителните полета са празни.</h3><br/>
                  <p class='link' style='color:black'>Натиснете тук за <a href='registration.php'>регистрация</a> отново.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Регистрация</h1>
        <input type="text" class="login-input" name="username" placeholder="Потребителско име" required />
        <input type="email" class="login-input" name="email" placeholder="Имейл">
        <input type="password" class="login-input" name="password" placeholder="Парола">
        <input type="submit" name="submit" value="Регистрация" class="login-button">
        <p class="link" style="color:black;">Вече имате акаунт? <a href="login.php">Вход към системата!</a></p>
    </form>
<?php
    }
?>
</body>
</html>
