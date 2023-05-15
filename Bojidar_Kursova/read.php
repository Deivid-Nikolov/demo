<?php
require_once "auth_session.php";
// Проверка на съществуването на id параметър преди по-нататъчна обработка
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Включване на конфигурационен файл (връзка с датабазата)
    require_once "config.php";
    
    // Подготвяне на оператор за избор
    $sql = "SELECT * FROM cars WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Свързване на променливи към подготвения оператор като параметри
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Задаване на параметри
        $param_id = trim($_GET["id"]);
        
        // Опит за изпълнение на подготвения оператор
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Извличане на реда с резултати като асоциативен масив. От набора от резултати
                съдържа само един ред, не е необходимо да използваме цикъл while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Извличане на индивидуална стойност на полето
                $vin = $row["vin_number"];
                $model = $row["model"];
                $brand = $row["brand"];
                $reg = $row["reg_num"];
            } else{
                // URL адресът не съдържа валиден id параметър. Пренасочване към страницата за грешка
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
        }
    }
     
    // приключване на заявката
    mysqli_stmt_close($stmt);
    
    // Затваряне на връзката
    mysqli_close($link);
} else{
    // URL адресът не съдържа id параметър. Пренасочване към страницата за грешка
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Преглед на служител</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html{
            height:100%;
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
            background-color: whitesmoke;
            padding: 20px;
            border-radius:15px;
        }
        body{
            background: repeating-linear-gradient(transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), repeating-linear-gradient(90deg, transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), #ebffe4;
            background-blend-mode: multiply;
            background-color: #ebffe4;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height:100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-16">
                    <h1 class="mt-5 mb-3">Преглед на кола: <b><?php echo $row["model"]; ?></b></h1>
                    <div class="form-group">
                        <label>VIN</label>
                        <p><b><?php echo $vin; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Модел</label>
                        <p><b><?php echo $model; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Марка</label>
                        <p><b><?php echo $brand; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Регистрационен номер</label>
                        <p><b><?php echo $reg; ?></b></p>
                    </div>
                    <p><a href="dashboard.php" class="btn btn-outline-dark">Назад</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


                <!-- БИБЛИОТЕКА -->

<!-- isset() — Определя дали дадена променлива е декларирана и е различна от нула -->
<!-- empty() — Определяне дали дадена променлива е празна -->
<!-- trim() — Премахване на интервали (или други знаци) от началото и края на низ -->
<!-- mysqli_prepare() — Подготвя SQL израз за изпълнение -->
<!-- mysqli_stmt_bind_param() Използва се за обвързване на променливи към маркерите за параметри на подготвен израз -->
<!-- mysqli_stmt_execute() — Изпълнява подготвен израз -->
<!-- mysqli_stmt_get_result() — Получава набор от резултати от подготвен израз като mysqli_result обект -->
<!-- mysqli_result() - Представлява набора от резултати, получен от заявка към базата данни -->
<!-- mysqli_num_rows() — Получава броя на редовете в резултатния набор -->
<!-- mysqli_fetch_array() — Извличане на ред от резултатен набор като асоциативен, числов масив -->
<!-- header() - Изпращане на необработена HTTP заявка -->
<!-- exit() — Извеждане на съобщение и прекратяване на текущия скрипт -->
<!-- mysqli_stmt_close() — Затваря подготвен израз -->
<!-- mysqli_close() — Затваря предварително отворена връзка с база данни -->