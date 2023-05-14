<?php
require_once "config.php";
include "auth_session.php";
$name = $type = $description = $financement = "";
$name_err = $description_err = $type_err = $financement_err= "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Моля въведете име.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\p{M}\s\-\_\.,;:]+$/u")))){
        $name_err = "Моля въведете валидно име, съдържащо поне дума, съдържаща букви или други знаци.";
    } else{
        $name = $input_name;
    }

    $input_type = trim($_POST['type']);
    if(empty($input_type) || $input_type===''){
        $type_err = "Моля въведете валидна опция.";
    } else{
        $type = $input_type;
    }

    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Моля въведете име.";
    } elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\d\s\-_[:punct:]]{0,1000}$/u")))){
        $description_err = "Превишили сте максималното количество знаци или сте вавели невалиден знак.";
    } else{
        $description = $input_description;
    }

    $input_financement = trim($_POST['financement']);
    if(empty($input_financement)){
        $financement_err = "Изберете валидна опция";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[\p{L}\p{M}\s\-\_\.,;:]+$/u")))){
        $financement_err = "Моля въведете валидно име, съдържащо поне дума, съдържаща букви или други знаци.";
    }else{
        $financement = $input_financement;
    }
    
    if(empty($name_err) && empty($description_err) && empty($type_err) && empty($financement_err)){
        $sql = "INSERT INTO projects (name, type, description, financement) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_type, $param_desc, $param_finance);
            
            $param_name = $name;
            $param_type = $type;
            $param_desc = $description;
            $param_finance = $financement;
            
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
            background-image: url(agenda-analysis-business-990818-1.jpg);
            background-repeat: no-repeat;
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
                            <label>Тип</label>
                            <select name="type" class="form-control">
                                <option value="" selected disabled>ИЗБЕРЕТЕ ОПЦИЯ</option>
                                <option value="fundraising" <?php if ($type === 'fundraising') { echo ' selected'; } ?>>Fundraising</option>
                                <option value="non-profit" <?php if ($type === 'non-profit') { echo ' selected'; } ?>>Non-profit</option>
                                <option value="charity" <?php if ($type === 'charity') { echo ' selected'; } ?>>Charity</option>
                                <option value="civil-league" <?php if ($type === 'civil-league') { echo ' selected'; } ?>>Civil leagues</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $type_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Източник на финансиране</label>
                            <input type="text" name="financement" class="form-control <?php echo (!empty($financement_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $financement; ?>">
                            <span class="invalid-feedback"><?php echo $financement_err;?></span>
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