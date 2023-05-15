<?php
// Включване на конфигурационен файл (връзка с датабазата)
require_once "config.php";
require_once "auth_session.php";

 
// Дефиниране на променливи и инициализиране с празни стойности
$name = $address = $middle = $last = $family = $citizen_number = $email = $number = $yearly_income = "";
$name_err = $address_err = $middle_err = $last_err = $family_err = $citizen_num_err = $email_err = $number_err = $yearly_err = "";
 
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

    $input_mname = trim($_POST["mname"]);
    if(empty($input_mname)){
        $middle_err = "Моля въведете име.";
    } elseif(!filter_var($input_mname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $middle_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $middle = $input_mname;
    }

    $input_lname = trim($_POST["lname"]);
    if(empty($input_lname)){
        $last_err = "Моля въведете име.";
    } elseif(!filter_var($input_lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я]+$/u")))){
        $last_err = "Моля въведете валидно име, съдържащо една дума, само с букви.";
    } else{
        $last = $input_lname;
    }
    
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Моля въведете адрес.";     
    } else{
        $address = $input_address;
    }
    
    $input_family = trim($_POST['family_situation']);
    if($input_family === 'none'){
        $family_err = "Изберете валидна опция";
    }else{
        $family = $input_family;
    }

    $input_citizen = trim($_POST["egn"]);
    if(empty($input_citizen)){
        $citizen_num_err = "Моля въведете ЕГН.";     
    } elseif(!filter_var($input_citizen, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=> "/^[0-9]{10}$/u")))){
        $citizen_num_err = "Моля въведете положително число, съдържащо 10 цифри от 0 до 9.";
    } else{
        $citizen_number = $input_citizen;
    }

    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Моля въведете имейл";
    }elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=> "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/")))){
        $email_err = "ВАЛИДЕН ИМЕЙЛ";
    }else{
        $email = $input_email;
    }

    $input_yearly = trim($_POST["yearly"]);
    if(empty($input_yearly)){
        $yearly_err = "Моля въведете заплата.";
    }elseif(!ctype_digit($input_yearly)){
        $yearly_err = "Въведете положително число.";
    }else{
        $yearly_income = $input_yearly;
    }

    $input_number = trim($_POST["number"]);
    if(empty($input_number)){
        $number_err = "Въведете число.";
    }elseif(!filter_var($input_number, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[\d\s-]+$/")))){
        $number_err = "Въведете валиден номер без интервали";
    }else{
        $number = $input_number;
    }
    
    // Проверка на грешките при въвеждане преди вмъкване в базата данни
    if(empty($name_err) && empty($address_err) && empty($citizen_num_err) && empty($middle_err) && empty($last_err) && empty($family_err) && empty($email_err) && empty($number_err) && empty($yearly_err)){
        // Подготвяне на изявление за актуализиране
        $sql = "UPDATE owners SET first_name=?, middle_name=?, last_name=?, egn=?, email=?, number=?, address=?, yearly_income=?, has_family = ? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Свързване на променливи към подготвения оператор като параметри
            mysqli_stmt_bind_param($stmt, "sssssssisi",$param_name, $param_midlle, $param_last,$param_egn, $param_email, $param_number,  $param_address, $param_yearly, $param_family, $param_id);
            
            // Задаване на параметри
            $param_name = $name;
            $param_midlle = $middle;
            $param_last = $last;
            $param_family = $family;
            $param_egn = $citizen_number;
            $param_address = $address;
            $param_number = $number;
            $param_email = $email;
            $param_yearly = $yearly_income;
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
        $sql = "SELECT * FROM owners WHERE id = ?";
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
                    $citizen_number = $row["egn"];
                    $email = $row["email"];
                    $number = $row["number"];
                    $address = $row["address"];
                    $yearly_income = $row["yearly_income"];
                    $family = $row["has_family"];
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
            margin: 10px auto;
            background-color: white;
            border-radius: 15px;
            padding: 10px;
        }
        body{
            background-color: brown;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: row wrap;
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
                        $link = mysqli_connect('localhost','root','','angelos_kursova')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($link,"select * from owners where id='$p_id'")or die(mysqli_error());
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
                            <label>ЕГН</label>
                            <input type="text" name="egn" class="form-control <?php echo (!empty($citizen_num_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $citizen_number; ?>">
                            <span class="invalid-feedback"><?php echo $citizen_num_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Имейл</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="text" name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>">
                            <span class="invalid-feedback"><?php echo $number_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Адрес</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label>Семеен</label>
                            <select name="family_situation" class="form-control">
                                <option value="none" selected>ИЗБЕРЕТЕ ОПЦИЯ</option>
                                <option value="YES" <?php if ($family === 'YES') { echo ' selected'; } ?>>Yes</option>
                                <option value="NO" <?php if ($family === 'NO') { echo ' selected'; } ?>>No</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $family_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Доход</label>
                            <input type="number" name="yearly" min="0" class="form-control <?php echo (!empty($yearly_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $yearly_income; ?>">
                            <span class="invalid-feedback"><?php echo $yearly_err;?></span>
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