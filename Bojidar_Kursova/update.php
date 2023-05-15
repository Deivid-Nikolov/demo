<?php
require_once "config.php";
require_once "auth_session.php";
 
$vin = $model = $brand = $reg_num = "";
$vin_err = $model_err = $brand_err = $reg_num_err = "";

 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
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
        $sql = "UPDATE cars SET vin_number=?, model=?, brand=?, reg_num=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $param_vin, $param_model, $param_brand, $param_reg_num, $param_id);
            
            $param_vin = $vin;
            $param_model = $model;
            $param_brand = $brand;
            $param_reg_num = $reg_num;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: dashboard.php");
                exit();
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    } 
    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM cars WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $vin = $row["vin_number"];
                    $model = $row["model"];
                    $brand = $row["brand"];
                    $reg_num = $row["reg_num"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактиране на данни за пилот</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 10px auto;
            background-color: white;
            border-radius: 15px;
            padding: 10px;
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
        html{
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $link = mysqli_connect('localhost','root','','kaloqn_kursova')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($link,"select * from cars where id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на данни: <b><?php echo $row["brand"]; ?></b></h2>
                    <?php } ?>
                    <p>Моля редактирайте полетата, които желаете и натиснете бутона за потвърждение, за да запазите новите данни в датабазата.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    </form>
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
<!-- preg_match() — Изпълнява съответствие на регулярен израз -->
<!-- ctype_digit() — Проверка за числови знаци -->
<!-- mysqli_prepare() — Подготвя SQL израз за изпълнение -->
<!-- mysqli_stmt_bind_param() Използва се за обвързване на променливи към маркерите за параметри на подготвен израз -->
<!-- mysqli_stmt_execute() — Изпълнява подготвен израз -->
<!-- header() - Изпращане на необработена HTTP заявка -->
<!-- exit() — Извеждане на съобщение и прекратяване на текущия скрипт -->
<!-- mysqli_stmt_close() — Затваря подготвен израз -->
<!-- mysqli_close() — Затваря предварително отворена връзка с база данни -->
<!-- mysqli_stmt_get_result() — Получава набор от резултати от подготвен израз като mysqli_result обект -->
<!-- mysqli_num_rows() — Получава броя на редовете в резултатния набор -->
<!-- mysqli_result() - Представлява набора от резултати, получен от заявка към базата данни -->
<!-- mysqli_fetch_array() — Извличане на ред от резултатен набор като асоциативен, числов масив -->
<!-- mysqli_query() — Извършва заявка в базата данни -->
<!-- htmlspecialchars() — Преобразуване на специални знаци в HTML обекти -->
<!-- basename() — Връща завършващия компонент на името на пътя -->