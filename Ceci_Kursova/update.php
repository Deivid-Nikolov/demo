<?php
require_once "config.php";
require_once "auth_session.php";
 
$name = $middle = $last = $age = "";
$name_err = $middle_err = $last_err = $age_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
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
        $sql = "UPDATE pilots SET first_name=?, second_name=?, last_name=?, age=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssii", $param_name, $param_middle, $param_surname, $param_age, $param_id);
            
            $param_name = $name;
            $param_middle = $middle;
            $param_surname = $last;
            $param_age = $age;
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
        
        $sql = "SELECT * FROM pilots WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $name = $row["first_name"];
                    $middle = $row["second_name"];
                    $last = $row["last_name"];
                    $age = $row["age"];
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
            background-image: repeating-linear-gradient(45deg, transparent, transparent 32px, #ffffff 32px, #ffffff 64px);
            background-color: #b4d6e0;
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
                        $link = mysqli_connect('localhost','root','','ceci_kursova')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($link,"select * from pilots where id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на данни: <b><?php echo $row["first_name"]; ?></b></h2>
                    <?php } ?>
                    <p>Моля редактирайте полетата, които желаете и натиснете бутона за потвърждение, за да запазите новите данни в датабазата.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <input type="number" name="age" min="0" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
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