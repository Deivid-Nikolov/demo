<?php
require_once "config.php";
include "auth_session.php";
$name = $parking = $fee = "";
$name_err = $parking_err = $fee_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Моля въведете име.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $name_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $name = $input_name;
    }

    $input_parking = trim($_POST["parking"]);
    if(empty($input_parking)){
        $parking_err = "Моля въведете възрастта на пилота.";
    }elseif(!ctype_digit($input_parking)){
        $parking_err = "Въведете положително число.";
    }else{
        $parking = $input_parking;
    }

    $input_fee = trim($_POST["fee"]);
    if(empty($input_fee)){
        $fee_err = "Моля въведете възрастта на пилота.";
    }elseif(!ctype_digit($input_fee)){
        $fee_err = "Въведете положително число.";
    }elseif($input_age>120){
        $fee_err = "Въведете число не по-голямо от 120.";
    }else{
        $fee = $input_fee;
    }
    
    if(empty($name_err) && empty($parking_err) && empty($fee_err)){
        $sql = "INSERT INTO parking (place, days_parking, fee) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sii", $param_name, $param_parking, $param_fee);
            
            $param_name = $name;
            $param_parking = $parking;
            $param_fee = $fee;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: dashboard.php");
                exit();
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Създаване на нов проект</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 15px auto;
            box-shadow: 0 0 15px 15px burlywood;
            background-color: white;
            padding:10px;
            border-radius:10px;
        }
        
        body{
            background-image: linear-gradient(to right bottom, #28536b, #2f6774, #467b77, #668d7a, #8a9d80, #a2a88b, #b8b399, #cdbfa9, #d9caba, #e4d6cb, #ede3dc, #f6f0ed);
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Създаване на нов проект</h2>
                    <p>Моля попълнете всички полета и натиснете бутона за потвърждение, за да запазите новият проект в датабазата.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Място</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Дни Паркирано</label>
                            <input type="number" name="parking" class="form-control <?php echo (!empty($parking_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $parking; ?>">
                            <span class="invalid-feedback"><?php echo $parking_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Такса в левове</label>
                            <input type="number" name="fee" class="form-control <?php echo (!empty($fee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fee; ?>">
                            <span class="invalid-feedback"><?php echo $fee_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-outline-primary" value="Потвърдете">
                        <a href="dashboard.php" class="btn btn-outline-dark ml-2">Отказ</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


                <!-- БИБЛИОТЕКА -->

<!-- trim() — Премахване на интервали (или други знаци) от началото и края на низ -->
<!-- empty() — Определяне дали дадена променлива е празна -->
<!-- filter_var() — Филтрира променлива с определен филтър -->
<!-- FILTER_VALIDATE_REGEXP проверява стойността спрямо Perl-съвместим регулярен израз -->
<!-- ctype_digit() — Проверка за числови знаци -->
<!-- mysqli_prepare() — Подготвя SQL израз за изпълнение -->
<!-- mysqli_stmt_bind_param() Използва се за обвързване на променливи към маркерите за параметри на подготвен израз -->
<!-- mysqli_stmt_execute() — Изпълнява подготвен израз -->
<!-- header() - Изпращане на необработена HTTP заявка -->
<!-- exit() — Извеждане на съобщение и прекратяване на текущия скрипт -->
<!-- mysqli_stmt_close() — Затваря подготвен израз -->
<!-- mysqli_close() — Затваря предварително отворена връзка с база данни -->
<!-- htmlspecialchars() — Преобразуване на специални знаци в HTML обекти -->