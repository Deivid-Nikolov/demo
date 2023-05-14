<?php
// Включване на конфигурационен файл (връзка с датабазата)
require_once "config.php";
 
// Дефиниране на променливи и инициализиране с празни стойности
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Обработка на данни от формуляра, когато формулярът е изпратен
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Получаване на скрита входна стойност
    $id = $_POST["id"];
    
// Потвърждаване на името
$input_name = trim($_POST["name"]);
if(empty($input_name)){
    $name_err = "Моля въведете име.";
} elseif(!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $input_name)){
    $name_err = "Моля въведете валидно име, съдържащо поне две думи, само с букви и интервали на кирилица или латиница.";
} else{
    $name = $input_name;
}

// Потвърждаване на адреса
$input_address = trim($_POST["address"]);
if(empty($input_address)){
    $address_err = "Моля въведете адрес.";     
} else{
    $address = $input_address;
}

// Потвърждаване на заплатата
$input_salary = trim($_POST["salary"]);
if(empty($input_salary)){
    $salary_err = "Моля въведете заплата.";     
} elseif(!ctype_digit($input_salary)){
    $salary_err = "Моля въведете положително число.";
} else{
    $salary = $input_salary;
}
    
    // Проверка на грешките при въвеждане преди вмъкване в базата данни
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Подготвяне на изявление за актуализиране
        $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Свързване на променливи към подготвения оператор като параметри
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Задаване на параметри
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Опит за изпълнение на подготвения оператор
            if(mysqli_stmt_execute($stmt)){
                // Записите са актуализирани успешно. Пренасочване към целевата страница
                header("location: index.php");
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
} else{
   // Проверка на съществуването на id параметър преди по-нататъшна обработка
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Получаване на URL параметър
        $id =  trim($_GET["id"]);
        
        // Подготвяне на оператор за избор
        $sql = "SELECT * FROM employees WHERE id = ?";
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
                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];
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
                        $con = mysqli_connect('localhost','root','','web_design')or die(mysqli_error());
                        $p_id = trim($_GET["id"]);
                        $user_query=mysqli_query($con,"select * from employees where id='$p_id'")or die(mysqli_error());
                        $row=mysqli_fetch_array($user_query); {
                    ?>
                    <h2 class="mt-5">Редактиране на служител: <b><?php echo $row["name"]; ?></b></h2>
                    <?php } ?>
                    <p>Моля редактирайте полетата, които желаете и натиснете бутона за потвърждение, за да запазите новите данни в датабазата.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Име</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Адрес</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Заплата</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
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