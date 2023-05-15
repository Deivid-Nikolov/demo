<?php
require_once "config.php";
require_once "auth_session.php";
 
$name = $manager = "";
$name_err = $manager_err = "";

 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

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
        $sql = "UPDATE department SET name=?, manager=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_manager, $param_id);
            
            $param_name = $name;
            $param_manager = $manager;
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
    mysqli_close($link);
}else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM department WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $name = $row["name"];
                    $manager = $row["manager"];
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
            background-image: radial-gradient(circle, #051937, #004d7a, #008793, #00bf72, #a8eb12);
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
                        $link = mysqli_connect('localhost','root','','bojidar_kursova')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($link,"select * from department where id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на данни: <b><?php echo $row["name"]; ?></b></h2>
                    <?php } ?>
                    <p>Моля редактирайте полетата, които желаете и натиснете бутона за потвърждение, за да запазите новите данни в датабазата.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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