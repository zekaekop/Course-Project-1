<?php


session_start();
include "db.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $query =  $pdo->prepare ("SELECT * FROM course_project.Users where name = ? OR mail = ?;");
    $query -> execute([$name, $email]);
    $user = $query-> fetch();

    if($name == $user['name'] && 
        $password == $user['password'] &&
        $email == $user['mail']){ 

        $_SESSION['user'] = $user;
        header("location: home.php");
    }
    else{
        $error = "Something went wrong :p";
    }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Project</title>
   <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

</head>
<body>


<div class="mt-5">
    <h1 class="text-center">Login</h1>
    <h5  class="text-center">into an existing account</h5>

    <div class="d-flex justify-content-center">
        <form method="POST" action="">
            <div class="card">
                
                <?php if ($error): ?>         <!--  display login error if something goes wrong -->
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?> 
                

                <ul class="p-0">
                    <li><h4>Username</h4><input type="text" name="name" id=""></li>
                    <li><h4>Email</h4><input type="text" name="email" id=""></li>
                    <li><h4>Password</h4><input type="password" name="password" id=""></li>
                </ul>

                <button class="btn btn-primary w-100" type="submit">
                    Enter
                </button>

                <div class="d-flex justify-content-end">
                    <a href="/register.php">
                        <small  class="text-center">Don't have an account?</small>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>