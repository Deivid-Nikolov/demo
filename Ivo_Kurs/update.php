<?php
require_once "config.php";
 
$name = $type = $description = $financement = "";
$name_err = $description_err = $type_err = $financement_err= "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
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
        $sql = "UPDATE projects SET name=?, type=?, description=?, financement=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $param_name, $param_type, $param_desc, $param_finance, $param_id);
            
            $param_name = $name;
            $param_type = $type;
            $param_desc = $description;
            $param_finance = $financement;
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
        
        $sql = "SELECT * FROM projects WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $name = $row["name"];
                    $type = $row["type"];
                    $description = $row["description"];
                    $financement = $row["financement"];
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
    <title>Редактиране на служител</title>
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
            background-image: url(agenda-analysis-business-990818-1.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
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
                        $link = mysqli_connect('localhost','root','','ivo_kursova')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($link,"select * from projects where id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на проект: <b><?php echo $row["name"]; ?></b></h2>
                    <?php } ?>
                    <p>Моля редактирайте полетата, които желаете и натиснете бутона за потвърждение, за да запазите новите данни в датабазата.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-outline-primary" value="Потвърди">
                        <a href="dashboard.php" class="btn btn-outline-dark ml-2">Отказ</a>
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