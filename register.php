<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $password = trim($_POST["password"]);

    $password_retry = trim($_POST["password_retry"]);

    $query =  $pdo->prepare ("SELECT * FROM course_project.users where name = ?;");
    $query -> execute([$name]);
    $user = $query-> fetch();

    if($name == $user['name'] && $password == $user['password'] && $password_retry == $password){ 
        $_SESSION['user'] = $user;
        header("location: index.php");
    }
    else{
        $failed_message = "Wrong username or password";
    }
    }

include "base.php";

?>

<h1>Register</h1>
<small>a account</small>


<small>Have an account?</small>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>