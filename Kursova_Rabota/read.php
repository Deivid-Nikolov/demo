<?php
require_once "auth_session.php";
// Проверка на съществуването на id параметър преди по-нататъчна обработка
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Включване на конфигурационен файл (връзка с датабазата)
    require_once "config.php";
    
    // Подготвяне на оператор за избор
    $sql = "SELECT * FROM drivers WHERE driver_id = ?";
    
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
                $name = $row["first_name"];
                $middle = $row["middle_name"];
                $last = $row["last_name"];
                $licence = $row["licence"];
                $cit_num = $row["citizen_number"];
                $address = $row["address"];
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
        .wrapper{
            width: 600px;
            margin: 0 auto;
            background-color: whitesmoke;
            padding: 20px;
            border-radius:15px ;
        }
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
            height: 100%;
        }
        html{
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-16">
                    <h1 class="mt-5 mb-3">Преглед на служител: <b><?php echo $row["first_name"]; ?></b></h1>
                    <div class="form-group">
                        <label>Име</label>
                        <p><b><?php echo $name; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Презиме</label>
                        <p><b><?php echo $middle; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Фамилия</label>
                        <p><b><?php echo $last; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Лиценз</label>
                        <p><b><?php echo $licence; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>ЕГН</label>
                        <p><b><?php echo $cit_num; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Адрес</label>
                        <p><b><?php echo $address; ?></b></p>
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