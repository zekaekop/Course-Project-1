<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $query =  $pdo->prepare ("SELECT * FROM course_project.users where name = ?;");
    $query -> execute([$name]);
    $user = $query-> fetch();

    if($name == $user['name'] && $password == $user['password']){ 
        $_SESSION['user'] = $user;
        header("location: index.php");
    }

    }

include "base.php";

?>

<h1 class="text-center">Login</h1>
<small  class="text-center">into an existing account</small>




<div class="d-flex justify-content-center">
    <form action="post">
        <div class="card">
            <ul >
                <li><h4>Username</h4><input type="text" name="name" id=""></li>
                <li><h4>Email</h4><input type="text" name="email" id=""></li>
                <li><h4>Password</h4><input type="passwordz" name="password" id=""></li>
            </ul>
            <small  class="text-center ms-auto">Don't have an account?</small>
        </div>
    </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>