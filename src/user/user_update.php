<?php session_start(); ?>
<?php
include("../db.php");
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $query = "SELECT user.user_id, user.email, user.password, user.name, user.career_id, user.role_id, career.name AS career_name, role.name AS role_name FROM user INNER JOIN career ON user.career_id = career.career_id INNER JOIN role ON user.role_id  = role.role_id WHERE user.user_id = $user_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $email = $row['email'];
        $password = $row['password'];
        $name = $row['name'];
        $career_id = $row['career_id'];
        $role_id = $row['role_id'];
        $career_name = $row['career_name'];
        $role_name = $row['role_name'];
    }
}
if (isset($_POST['update'])) {
    $user_id = $_GET['user_id'];
    $email = $_POST['email'];
    //$password = $_POST['password']; In the future it can be edited by an Admin
    $name = $_POST['name'];
    $career_id = $_POST['career_id'];
    $role_id = $_POST['role_id'];
    
    $query = "UPDATE user SET email = '$email', password = '$password', name = '$name', career_id = '$career_id', role_id='$role_id' WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    $_SESSION['message'] = 'Usuario editado satisfactoriamente';
    $_SESSION['message_type'] = 'success';
    header("Location: user.php");
}
?>

<?php include("../includes/header.php") ?>

<style>
    body {
        background-image: url('../img/auth-bg.jpg');
        background-size: cover;
    }


    .form-control:focus {
        border-color: #3aa661;
        box-shadow: none;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        color: white;
        background-color: #3aa661;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
        padding: 7px;
    }

    .btn-success {
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .btn-success:hover {
        background-color: #339a4e;
        border-color: #339a4e;
    }
</style>

<br>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card text-center">
                <div class="card-header">
                    Editar Usuario
                </div>
                <div class="card-body">
                    <form action="user_update.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
                        <div class="form-group m-2">
                            <input type="text" name="email" value="<?php echo $email ?>" class="form-control" placeholder="Actualizar email" required>
                        </div>
                        <div class="form-group m-2">
                            <input type="password" name="password" value="<?php echo $password ?>" class="form-control" placeholder="Actualizar passworrd" disabled>
                        </div>
                        <div class="form-group m-2">
                            <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Actualizar nombre y apellido" required>
                        </div>
                        <?php
                        $query = "SELECT * FROM career";
                        $result_career = mysqli_query($conn, $query);
                        ?>
                        <div class="form-group m-2">
                            <select name="career_id" class="form-control">
                                <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                    <option value="<?php echo $row['career_id']; ?>" <?php if ($row['career_id'] == $career_id) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                        $query = "SELECT * FROM role";
                        $result_role = mysqli_query($conn, $query);
                        ?>
                        <div class="form-group m-2">
                            <select name="role_id" class="form-control">
                                <?php while ($row = mysqli_fetch_assoc($result_role)) { ?>
                                    <option value="<?php echo $row['role_id']; ?>" <?php if ($row['role_id'] == $role_id) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button class="btn btn-success btn-block mx-auto d-block" name="update">
                            Editar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>