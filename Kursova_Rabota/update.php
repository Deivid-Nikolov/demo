<?php
// Включване на конфигурационен файл (връзка с датабазата)
require_once "config.php";
 
// Дефиниране на променливи и инициализиране с празни стойности
$name = $address = $middle = $last = $licence = $citizen_number = "";
$name_err = $address_err = $middle_err = $last_err = $licence_err = $citizen_num_err = "";
 
// Обработка на данни от формуляра, когато формулярът е изпратен
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Получаване на скрита входна стойност
    $id = $_POST["id"];
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Потвърждаване на името
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
    
        //Потвърждаване на лиценз
        $input_category = trim($_POST['car']);
        if(empty($input_category)){
            $licence_err = "Изберете валидна опция";
        }else{
            $licence = $input_category;
        }
        
        // Потвърждаване на адреса
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Моля въведете адрес.";     
        } else{
            $address = $input_address;
        }
        
        // Потвърждаване на заплатата
        $input_citizen = trim($_POST["unique_num"]);
        if(empty($input_citizen)){
            $citizen_num_err = "Моля въведете ЕГН.";     
        } elseif(!filter_var($input_citizen, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=> "/^[0-9]{10}$/u")))){
            $citizen_num_err = "Моля въведете положително число, съдържащо 10 цифри от 0 до 9.";
        } else{
            $citizen_number = $input_citizen;
        }
    
    // Проверка на грешките при въвеждане преди вмъкване в базата данни
    if(empty($name_err) && empty($address_err) && empty($citizen_num_err) && empty($middle_err) && empty($last_err) && empty($licence_err)){
        // Подготвяне на изявление за актуализиране
        $sql = "UPDATE drivers SET first_name=?, middle_name=?, last_name=?, licence=?, citizen_number=?, address=? WHERE driver_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Свързване на променливи към подготвения оператор като параметри
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_name, $param_midlle, $param_last, $param_licence, $param_citizen, $param_address, $param_id);
            
            // Задаване на параметри
            $param_name = $name;
            $param_midlle = $middle;
            $param_last = $last;
            $param_licence = $licence;
            $param_citizen = $citizen_number;
            $param_address = $address;
            $param_id = $id;
            
            // Опит за изпълнение на подготвения оператор
            if(mysqli_stmt_execute($stmt)){
                // Записите са актуализирани успешно. Пренасочване към целевата страница
                header("location: dashboard.php");
                exit();
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
         
        // приключване на заявката
        mysqli_stmt_close($stmt);
    }
    } 
    // Затваряне на връзката
    mysqli_close($link);
} else{
   // Проверка на съществуването на id параметър преди по-нататъшна обработка
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Получаване на URL параметър
        $id =  trim($_GET["id"]);
        
        // Подготвяне на оператор за избор
        $sql = "SELECT * FROM drivers WHERE driver_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Свързване на променливи към подготвения оператор като параметри
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Задаване на параметри
            $param_id = $id;
            
            // Опит за изпълнение на подготвения оператор
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Извличане на реда с резултати като асоциативен масив. От набора от резултати
                    съдържа само един ред, не е необходимо да използваме цикъл while */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Извличане на индивидуална стойност на полето
                    $name = $row["first_name"];
                    $middle = $row["middle_name"];
                    $last = $row["last_name"];
                    $licence = $row["licence"];
                    $citizen_number = $row["citizen_number"];
                    $address = $row["address"];
                } else{
                    // URL адресът не съдържа валиден идентификатор. Пренасочване към страницата за грешка
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL адресът не съдържа валиден идентификатор. Пренасочване към страницата за грешка
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
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $con = mysqli_connect('localhost','root','','kursova_rabota')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($con,"select * from drivers where driver_id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на служител: <b><?php echo $row["first_name"]; ?></b></h2>
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
                            <label>Лиценз</label>
                            <select name="car" class="form-control">
                                <option value="" selected disabled>ИЗБЕРЕТЕ ОПЦИЯ</option>
                                <option value="B1" <?php if ($licence === 'B1') { echo ' selected'; } ?>>B1</option>
                                <option value="B" <?php if ($licence === 'B') { echo ' selected'; } ?>>B</option>
                                <option value="C1" <?php if ($licence === 'C1') { echo ' selected'; } ?>>C1</option>
                                <option value="C" <?php if ($licence === 'C') { echo ' selected'; } ?>>C</option>
                                <option value="D1" <?php if ($licence === 'D1') { echo ' selected'; } ?>>D1</option>
                                <option value="D" <?php if ($licence === 'D') { echo ' selected'; } ?>>D</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>ЕГН</label>
                            <input type="text" name="unique_num" class="form-control <?php echo (!empty($citizen_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $citizen_number; ?>">
                            <span class="invalid-feedback"><?php echo $citizen_num_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Адрес</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-outline-primary" value="Потвърди">
                        <a href="index.php" class="btn btn-outline-dark ml-2">Отказ</a>
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