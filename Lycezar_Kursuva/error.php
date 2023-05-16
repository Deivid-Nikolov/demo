<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-image: radial-gradient(circle at center center, #928181, #96e978), repeating-radial-gradient(circle at center center, #928181, #928181, 29px, transparent 58px, transparent 29px);
            background-blend-mode: multiply;
            background-color: #96e978;                 
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-flow: column wrap;
        }
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
                    <h2 class="mt-5 mb-3" style="color:white;">Невалидна заявка</h2>
                    <div class="alert alert-danger">Съжаляваме, направихте невалидна заявка. Моля <a href="dashboard.php" class="alert-link">вернете се обратно</a> и опитайте отново.</div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>