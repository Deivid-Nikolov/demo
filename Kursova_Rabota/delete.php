<?php
// Операция за изтриване на процес след потвърждение
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Включване на конфигурационен файл (връзка с датабазата)
    require_once "config.php";
    
    // Подготвяне на оператор за изтриване
    $sql = "DELETE FROM drivers WHERE driver_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Свързване на променливи към подготвения оператор като параметри
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Задаване на параметри
        $param_id = trim($_POST["id"]);
        
        // Опит за изпълнение на подготвения оператор
        if(mysqli_stmt_execute($stmt)){
            
           // Записите са изтрити успешно. Пренасочване към целевата страница
            header("location: dashboard.php");
            exit();
        } else{
            echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
        }
    }
     
    // приключване на заявката
    mysqli_stmt_close($stmt);
    
    // Пренареждане на ID-тата в базата данни
    $sql = "ALTER TABLE drivers DROP driver_id;
            ALTER TABLE drivers ADD driver_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    mysqli_query($link, $sql);
    
    // Затваряне на връзката
    mysqli_close($link);
} else{
    // Проверка на съществуването на id параметър
    if(empty(trim($_GET["id"]))){
        // URL адресът не съдържа id параметър. Пренасочване към страницата за грешка
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Изтриване на запис</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-image: linear-gradient(to left bottom, #159895, #26a09b, #33a9a2, #3eb1a8, #49baae, #58c2b9, #67cac4, #76d2cf, #8fdbdf, #a8e4ec, #c2ecf7, #daf5ff);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column wrap;
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3" style="color:white;">Изтриване на запис</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <?php
                                $con = mysqli_connect('localhost','root','','kursova_rabota')or die(mysqli_error());
                                $p_id = trim($_GET["id"]);
                                $user_query=mysqli_query($con,"select * from drivers where driver_id='$p_id'")or die(mysqli_error());
                                $row=mysqli_fetch_array($user_query); {
                            ?>
                            <p>Сигурни ли сте, че искате да изтриете служител: <b><?php echo $row["first_name"]; ?></b>?</p>
                            <?php } ?>
                            <p>
                                <input type="submit" value="Да" class="btn btn-outline-danger">
                                <a href="dashboard.php" class="btn btn-outline-dark">Не</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


                <!-- БИБЛИОТЕКА -->

<!-- isset() — Определя дали дадена променлива е декларирана и е различна от нула -->
<!-- trim() — Премахване на интервали (или други знаци) от началото и края на низ -->
<!-- empty() — Определяне дали дадена променлива е празна -->
<!-- mysqli_prepare() — Подготвя SQL израз за изпълнение -->
<!-- mysqli_stmt_bind_param() Използва се за обвързване на променливи към маркерите за параметри на подготвен израз -->
<!-- mysqli_stmt_execute() — Изпълнява подготвен израз -->
<!-- header() - Изпращане на необработена HTTP заявка -->
<!-- exit() — Извеждане на съобщение и прекратяване на текущия скрипт -->
<!-- mysqli_stmt_close() — Затваря подготвен израз -->
<!-- mysqli_query() — Извършва заявка в базата данни -->
<!-- mysqli_close() — Затваря предварително отворена връзка с база данни -->
<!-- htmlspecialchars() — Преобразуване на специални знаци в HTML обекти -->
<!-- mysqli_fetch_array() — Извличане на ред от резултатен набор като асоциативен, числов масив -->