<?php
require_once "config.php";
include "auth_session.php";
$name = $manager = "";
$name_err = $manager_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Моля въведете име.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $name_err = "Моля въведете валидно име, съдържащо поне една дума.";
    } else{
        $name = $input_name;
    }

    $input_manager = trim($_POST["manager"]);
    if(empty($input_manager)){
        $manager_err = "Моля въведете модел.";
    } elseif(!filter_var($input_manager, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $manager_err = "Моля въведете валидно име.";
    } else{
        $manager = $input_manager;
    }

    
    
    if(empty($name_err) && empty($manager_err)){
        $sql = "INSERT INTO department (name, manager) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_manager);
            
            $param_name = $name;
            $param_manager = $manager;
            
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
        html{
            height:100%;
        }
        .wrapper{
            width: 600px;
            margin: 15px auto;
            box-shadow: 0 0 10px 10px black;
            background-color: white;
            padding:10px;
            border-radius:10px;
        }
        
        body{
            background-image: radial-gradient(circle, #051937, #004d7a, #008793, #00bf72, #a8eb12);
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Добавяне на нова кола</h2>
                    <p>Моля попълнете всички полета и натиснете бутона за потвърждение, за да добавиде новата кола в датабазата.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Отдел</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Мениджър</label>
                            <input type="text" name="manager" class="form-control <?php echo (!empty($manager_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $manager; ?>">
                            <span class="invalid-feedback"><?php echo $manager_err;?></span>
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