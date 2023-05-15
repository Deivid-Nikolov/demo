<?php
require_once "config.php";
include "auth_session.php";
$name = $middle = $last = $age = "";
$name_err = $middle_err = $last_err = $age_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Моля въведете име.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $name_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $name = $input_name;
    }

    // Потвърждаване на Презиме
    $input_mname = trim($_POST["mname"]);
    if(empty($input_mname)){
        $middle_err = "Моля въведете име.";
    } elseif(!filter_var($input_mname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $middle_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $middle = $input_mname;
    }

    // Потвърждаване на Фамилия
    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $last_err = "Моля въведете име.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $last_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $last = $input_lname;
    }

    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Моля въведете възрастта на пилота.";
    }elseif(!ctype_digit($input_age)){
        $age_err = "Въведете положително число.";
    }elseif($input_age>120){
        $age_err = "Въведете число не по-голямо от 120.";
    }else{
        $age = $input_age;
    }
    
    if(empty($name_err) && empty($middle_err) && empty($last_err) && empty($age_err)){
        $sql = "INSERT INTO pilots (first_name, second_name, last_name, age) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_middle, $param_surname, $param_age);
            
            $param_name = $name;
            $param_middle = $middle;
            $param_surname = $last;
            $param_age = $age;
            
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
            box-shadow: 0 0 10px 10px black;
            background-color: white;
            padding:10px;
            border-radius:10px;
        }
        
        body{
            background-image: repeating-linear-gradient(45deg, transparent, transparent 32px, #ffffff 32px, #ffffff 64px);
            background-color: #b4d6e0;
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
                            <label>Име</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Презиме</label>
                            <input type="text" name="mname" class="form-control <?php echo (!empty($middle_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middle; ?>">
                            <span class="invalid-feedback"><?php echo $middle_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Фамилия</label>
                            <input type="text" name="lname" class="form-control <?php echo (!empty($last_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last; ?>">
                            <span class="invalid-feedback"><?php echo $last_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Възраст</label>
                            <input type="number" name="age" min="0" max="120" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
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