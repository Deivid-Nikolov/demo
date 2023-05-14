<?php

include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Контролен панел</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        html{
            height:100%;
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
            height: 100%;
        }
        .wrapper{
            margin: 0 auto;
            margin-bottom: 20px;
            width: 90%;
            background-color: aliceblue;
            border-radius: 15px;
            box-shadow: 0 0 10px 10px whitesmoke;

        }

        .row table, .row th,.row td{
            border: 5px solid #159895;
            border-radius: 5px;
            border-collapse: ;        
        }

        .center{
            text-align: center;
            margin:0 auto;
            width:80%;
            background-color: aliceblue;
            border-radius: 10px;
            font-size: larger;
            position: fixed;
            top:0;
            padding: 10px;
            display: flex;
            flex-flow: row wrap;
            justify-content: space-around;
            align-items: center;
        }

        button a{
            padding: 5px;
            text-decoration: none;
            color: green;
        }
        button a:hover{
            text-decoration: none;
            color:white
        }
        .customized{
            color: #159895;
            font-size: 2rem;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="center">
        <p>Здравей, <span class="customized"><?php echo $_SESSION['username']; ?></span>!</p>
        <p>Вие се намирате във вашият контролен панел.</p>
        <button class="btn btn-outline-success"><a href="logout.php">Изход</a></button>
    </div>
    <body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Подробности за служителите</h2>
                        <a href="create.php" class="btn btn-outline-success pull-right"><i class="fa fa-plus"></i> Добави нов служител</a>
                    </div>
                    <?php
                    // Включване на конфигурационен файл (връзка с датабазата)
                    require_once "config.php";
                    
                    // Опит за изпълнение на заявка за избор на служители
                    $sql = "SELECT * FROM drivers";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Име</th>";
                                        echo "<th>Презиме</th>";
                                        echo "<th>Фамилия</th>";
                                        echo "<th>Лиценз</th>";
                                        echo "<th>ЕГН</th>";
                                        echo "<th>Адрес</th>";
                                        echo "<th>Прочети/Поднови/Изтрии</th>";

                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['driver_id'] . "</td>";
                                        echo "<td>" . $row['first_name'] . "</td>";
                                        echo "<td>" . $row['middle_name'] . "</td>";
                                        echo "<td>" . $row['last_name'] . "</td>";
                                        echo "<td>" . $row['licence'] . "</td>";
                                        echo "<td>" . $row['citizen_number'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";

                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['driver_id'] .'" class="mr-3" title="Преглед" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['driver_id'] .'" class="mr-3" title="Редактиране" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['driver_id'] .'" title="Изтриване" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Краен резултат от резултати
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Няма намерени служители.</em></div>';
                        }
                    } else{
                        echo "Опа! Нещо се обърка. Моля опитайте по-късно.";
                    }
 
                    // Затваряне на връзката
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
