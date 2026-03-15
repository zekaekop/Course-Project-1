<?php

// very important, apperantly this allows debuging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);

    $role = "student"; // default as a student when registering

    // to be a teacher, ask a admin to make you one

    // to be admin, you must have access to the db and be superuser

    $password_retry = trim($_POST["password_retry"]);

    $query =  $pdo->prepare ("SELECT * FROM course_project.users where name = ?;");
    $query -> execute([$name]);

    $existing_user = $query-> fetch();

    if($password_retry == $password){ 

        if ($existing_user){ 
            $failed_message = "This account already exists";
        }else{
            // create the user
            $query = $pdo->prepare("INSERT INTO course_project.users (name,password,role,mail) VALUES(?,?,?,?)");
            $query -> execute([$name , $password, $role, $email]);

            $query = $pdo->prepare("SELECT * FROM course_project.users WHERE name = ?");
            $query->execute([$name]);
            $new_user = $query->fetch();

            $_SESSION['user'] = $new_user;
            header("Location:home.php");
            exit;
        }
    }
    else{
        $error = "Passwords dont match!";
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

    <div class="d-flex justify-content-center">
        <form method="POST" action="">
            <div class="card">

                <h1 class="text-center text-white"><b>Register</b></h1>
                <h5  class="text-center text-white">an account</h5>

                <hr>
                
                <?php if ($error): ?>         <!--  display login error if something goes wrong -->
                    <div class="alert alert-danger text-white"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?> 
                

                <ul class="p-0">
                    <li><h4 class="text-white"><b>Username</b></h4><input type="text" name="name" placeholder="Username ... " id="" required></li>
                    <li><h4 class="text-white"><b>Email</b></h4><input type="text" name="email" placeholder="Email ... "   id="" required></li>
                    <li><h4 class="text-white"><b>Password</b></h4><input type="password" name="password"  placeholder="Password ... " id="" required></li>
                    <li><h4 class="text-white"><b>Repeat Password</b></h4><input type="password" placeholder="Repeat Password ... "  name="password_retry" id="" required></li>
                </ul>

                <button class="btn btn-primary w-100" type="submit">
                    Enter
                </button>

                <hr>

                <div class="d-flex justify-content-end">
                    <a href="login.php">
                        <small  class="text-center">Have an account?</small>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>