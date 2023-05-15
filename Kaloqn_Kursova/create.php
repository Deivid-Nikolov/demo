<?php
require_once "config.php";
include "auth_session.php";
$vin = $model = $brand = $reg_num = "";
$vin_err = $model_err = $brand_err = $reg_num_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_vin = trim($_POST["vin"]);
    if(empty($input_vin)){
        $vin_err = "Моля въведете VIN.";
    } elseif(!filter_var($input_vin, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[A-HJ-NPR-Z0-9]{17}$/")))){
        $vin_err = "Моля въведете валиден VIN.";
    } else{
        $vin = $input_vin;
    }

    // Потвърждаване на Презиме
    $input_brand = trim($_POST["brand"]);
    if(empty($input_brand)){
        $brand_err = "Моля въведете име.";
    } elseif(!filter_var($input_brand, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $brand_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $brand = $input_brand;
    }

    // Потвърждаване на Фамилия
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = "Моля въведете модел.";
    } elseif(!filter_var($input_model, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $model_err = "Моля въведете валидно име.";
    } else{
        $model = $input_model;
    }

    $input_reg = trim($_POST["reg_num"]);
    if(empty($input_reg)){
        $reg_num_err = "Моля въведете регистрационен номер.";
    } elseif(!filter_var($input_reg, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[A-Z]{2}\d{4}[A-Z]{2}$/")))){
        $reg_num_err = "Моля въведете валидно име.";
    } else{
        $reg_num = $input_reg;
    }
    
    if(empty($vin_err) && empty($model_err) && empty($brand_err) && empty($reg_num_err)){
        $sql = "INSERT INTO cars (vin_number, model, brand, reg_num) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_vin, $param_model, $param_brand, $param_reg_num);
            
            $param_vin = $vin;
            $param_model = $model;
            $param_brand = $brand;
            $param_reg_num = $reg_num;
            
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
            background: repeating-linear-gradient(transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), repeating-linear-gradient(90deg, transparent, transparent 7.25px, #d95f5f 7.25px, #d95f5f 10.875px, transparent 10.875px, transparent 14.5px, #d95f5f 10.875px, #d95f5f 29px, transparent 29px, transparent 32.625px, #d95f5f 32.625px, #d95f5f 36.25px, transparent 36.25px, transparent 58px), #ebffe4;
            background-blend-mode: multiply;
            background-color: #ebffe4;
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
                            <label>VIN</label>
                            <input type="text" name="vin" class="form-control <?php echo (!empty($vin_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vin; ?>">
                            <span class="invalid-feedback"><?php echo $vin_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Модел</label>
                            <input type="text" name="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $model; ?>">
                            <span class="invalid-feedback"><?php echo $model_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Марка</label>
                            <input type="text" name="brand" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $brand; ?>">
                            <span class="invalid-feedback"><?php echo $brand_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Регистрационен номер</label>
                            <input type="text" name="reg_num" class="form-control <?php echo (!empty($reg_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reg_num; ?>">
                            <span class="invalid-feedback"><?php echo $reg_num_err;?></span>
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