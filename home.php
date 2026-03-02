<?php
session_start();
include "db.php";

include "base.php";

?>

<div class="mt-5">
    <h1 class="text-center">Home Page</h1>
    <h5  class="text-center">into an existing account</h5>

    <div class="d-flex justify-content-center">
        <form action="post">
            <div class="card">
                
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