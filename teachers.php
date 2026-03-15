<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo -> prepare("SELECT * FROM teachers WHERE 
                                                teacher_name LIKE ? OR 
                                                profesion LIKE ?");
    
    $query -> execute(["%$search%", "%$search%"]);
    $teachers = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM teachers");
    $teachers = $query -> fetchAll();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    # deleting a teacher
    if(isset($_POST['delete_submit'])){
        
        _auth_user();

        $teacher_id = $_POST['teacher_id'];

        $query = $pdo->prepare("DELETE FROM teachers WHERE teacher_id LIKE ?");
        $result = $query->execute([$teacher_id]);

        header("location: teachers.php");
    }

    # editing teachers
    if(isset($_POST['update_submit'])){

        _auth_user();
        
        $teacher_id = $_POST['teacher_id'];

        $teacher_name = $_POST['teacher_name'];
        $profesion = $_POST['profesion'];
        
        $query = $pdo->prepare("UPDATE teachers SET teacher_name = ?, profesion = ? WHERE teacher_id = ?");
        $result = $query->execute([$teacher_name, $profesion, $teacher_id]);
        
        header("Location: teachers.php");
    }

    # creating a teacher
    if(isset($_POST['createteacher_submit'])){

        _auth_user();

        $teacher_name = $_POST['teacher_name'];
        $profesion = $_POST['profesion'];

        $query = $pdo->prepare("INSERT INTO teachers (teacher_name, profesion) VALUES (?,?)");
        $result = $query->execute([$teacher_name, $profesion]);

        header("Location: teachers.php");
    }
}

// check if user is logged in
function _auth_user(){
    if (!isset($_SESSION['user'])) {
        header("Location: logout.php");
    }
}


?>

<div class="container mt-5">
    <h1 class="text-center">Current Teachers</h1>

        <!-- this should only be visiable to teachers and admins -->
         <?php if($user['role'] == "teacher" || $user['role'] == "admin"): ?>
            <form method="POST">
                <div class="card w-100 mt-3">
                        <input class="w-100" type="text" name="teacher_name" placeholder="Teacher Name Ex. Ryan Smith ..." id="" required>
                        <input class="w-100" type="text" name="profesion" placeholder="Teacher Profesion Ex. Programming ..." id="" required>
                </div>

                <button class="card p-3 mt-3 text-white w-100" style="border-radius: 0.5rem;" type="submit" name="createteacher_submit">Create course</button>

            </form>
        <?php endif ?>

        <hr>

        <?php include('search.php'); ?>

        <div class="card w-100 mt-3">
            <h3 class="text-center">Available Teachers</h3>

            <table class="text-center w-100">
                <thead>
                    <tr>
                        <th>Teacher Name</th>
                        <th>Profesion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            <?php foreach($teachers as $teacher): ?>
                <tr>
                    <td><?= $teacher['teacher_name'] ?></td>
                    <td><?= $teacher['profesion'] ?></td>

                    <td>
                        <?php if($user['role'] == "teacher" || $user['role'] == "admin"): ?>
                            <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#deletemodal<?= $teacher['teacher_id'] ?>">Delete</button>
                            <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#editmodal<?= $teacher['teacher_id'] ?>">Edit</button>
                        <?php endif ?>
                    </td>

                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>

<!-- This is the old modal from the music project -->
<!-- https://getbootstrap.com/docs/5.3/components/modal/ -->
<!-- Modal -->
<?php foreach($teachers as $teacher): ?>
    <div class="modal fade" id="editmodal<?= $teacher['teacher_id']?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit teacher</h5>
                        <button type="button" class="btn-close"  style="background-color: white;"  data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="teacher_id" value="<?= $teacher['teacher_id'] ?>" required>
                        <input type="text" class="form-control" name="teacher_name" value="<?= $teacher['teacher_name'] ?>" required>
                        <input type="text" class="form-control" name="profesion" value="<?= $teacher['profesion'] ?>" required>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary w-100" type="submit" name="update_submit">Update</button>
                        <button class="btn btn-primary w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletemodal<?=$teacher['teacher_id']?>" tabindex="-1" aria-labelledby="deletemodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deletemodallabel">Confirm Delete</h1>
                <button type="button" class="btn-close" style="background-color: white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this?
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST">
                    <input type="hidden" name="teacher_id" id="" value=<?=$teacher['teacher_id']?>>
                    <button class="btn btn-primary"  type="submit" name="delete_submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>