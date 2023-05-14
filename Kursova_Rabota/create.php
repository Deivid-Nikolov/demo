<?php
// Включване на конфигурационен файл (връзка с датабазата)
require_once "config.php";
 
// Дефиниране на променливи и инициализиране с празни стойности
$name = $address = $middle = $last = $licence = $citizen_number = "";
$name_err = $address_err = $middle_err = $last_err = $licence_err = $citizen_num_err = "";
 
// Обработка на данни от формуляра, когато формулярът е изпратен
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
        // Подготвяне на оператор за вмъкване
        $sql = "INSERT INTO drivers (first_name, middle_name, last_name, licence, citizen_number, address) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Свързване на променливи към подготвения оператор като параметри
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_midlle, $param_last, $param_licence, $param_citizen, $param_address);
            
            // Задаване на параметри
            $param_name = $name;
            $param_midlle = $middle;
            $param_last = $last;
            $param_licence = $licence;
            $param_citizen = $citizen_number;
            $param_address = $address;
            
            // Опит за изпълнение на подготвения оператор
            if(mysqli_stmt_execute($stmt)){
                // Записите са създадени успешно. Пренасочване към целевата страница
                header("location: dashboard.php");
                exit();
            } else{
                echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
            }
        }
         
        // приключване на заявката
        mysqli_stmt_close($stmt);
    }
    
    // Затваряне на връзката
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Създаване на нов служител</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 15px auto;
            box-shadow: 0 0 10px 10px black;
            background-color: #daf5ff;
            padding:10px;
            border-radius:10px;
        }
        
        body{
            background-image: linear-gradient(to left bottom, #159895, #26a09b, #33a9a2, #3eb1a8, #49baae, #58c2b9, #67cac4, #76d2cf, #8fdbdf, #a8e4ec, #c2ecf7, #daf5ff);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column wrap;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Създаване на нов служител</h2>
                    <p>Моля попълнете всички полета и натиснете бутона за потвърждение, за да запазите новият работник в датабазата.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-outline-primary" value="Потвърдете">
                        <a href="index.php" class="btn btn-outline-dark ml-2">Отказ</a>
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