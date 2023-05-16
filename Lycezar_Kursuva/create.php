<?php
require_once "config.php";
include "auth_session.php";
$name = $price = $description = $kind = "";
$name_err = $price_err = $description_err = $kind_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Моля въведете име.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $name_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $name = $input_name;
    }

    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Моля въведете възрастта на пилота.";
    }elseif(!ctype_digit($input_price)){
        $price_err = "Въведете положително число.";
    }else{
        $price = $input_price;
    }

    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Моля въведете описание.";
    }elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s-]+$/u")))){
        $description_err = "Въведете валидно описание.";
    }else{
        $description = $input_description;
    }

    $input_kind = trim($_POST['kind']);
    if($input_kind === 'none'){
        $lind_err = "Изберете валидна опция";
    }else{
        $kind = $input_kind;
    }
    
    if(empty($name_err) && empty($price_err) && empty($description_err) && empty($kind_err)){
        $sql = "INSERT INTO services (name, price, description,kind) VALUES (?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "siss", $param_name, $param_price, $param_description, $param_kind);
            
            $param_name = $name;
            $param_price = $price;
            $param_description = $description;
            $param_kind = $kind;
            
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
            background-color: snow;
            padding:10px;
            border-radius:10px;
        }
        
        body{
            background-image: radial-gradient(circle at center center, #928181, #96e978), repeating-radial-gradient(circle at center center, #928181, #928181, 29px, transparent 58px, transparent 29px);
            background-blend-mode: multiply;
            background-color: #96e978;     
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
                            <span class="invalid-descriptiondback"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Цена</label>
                            <input type="number" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-descriptiondback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Лиценз</label>
                            <select name="kind" class="form-control">
                                <option value="none" selected>ИЗБЕРЕТЕ ОПЦИЯ</option>
                                <option value="massage" <?php if ($kind === 'massage') { echo ' selected'; } ?>>Massage</option>
                                <option value="hairstyle" <?php if ($kind === 'hairstyle') { echo ' selected'; } ?>>Hairstyle</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $licence_err;?></span>
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