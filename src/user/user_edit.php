<?php 
session_start(); 
include("../db.php");


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT user.user_id, user.email, user.password, user.name, user.career_id, career.name AS career_name FROM user INNER JOIN career ON user.career_id = career.career_id WHERE user.user_id = $user_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $email = $row['email'];
        $password = $row['password'];
        $name = $row['name'];
        $career_id = $row['career_id'];
        $career_name = $row['career_name'];
    }
}

if (isset($_POST['edit'])) {
    $user_id = $_GET['user_id'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $email;
    //$password = $_POST['password'];
    $name = !empty($_POST['name']) ? $_POST['name'] : $name;
    $career_id = !empty($_POST['career_id']) ? $_POST['career_id'] : $career_id;
    $query = "UPDATE user SET email = '$email', password = '$password', name = '$name', career_id = '$career_id' WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    $_SESSION['message'] = 'Usuario editado satisfactoriamente';
    header("Location: ../index.php");
}

include("../includes/header.php");
$message = '' ?>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;" style="font-family: 'Arial', sans-serif;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body text-center shadow-lg">
                <form action="user_edit.php?user_id=<?php echo $user_id; ?>" method="POST">
                    <h2 style="font-family: 'Arial', sans-serif;">
                        Editar Perfil
                    </h2>
                    <br>
                    <div class="form-group m-3">
                        <img src="../img/userNL.png" class="img-fluid" alt="Perfil de Usuario">
                    </div>
                    <div class="form-group m-2">
                        <input type="email" name="email" class="form-control" placeholder="Actualizar email" autofocus required value="<?php echo $email ?>" disabled>
                    </div>
                    <div class="form-group m-2">
                        <input type="password" name="password" value="<?php echo $password ?>" class="form-control" placeholder="Actualizar password" disabled>
                    </div>
                    <div class="form-group m-2">
                        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Actualizar nombre y apellido">
                    </div>
                    <?php
                    $query = "SELECT * FROM career";
                    $result_career = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group m-2">
                        <select name="career_id" class="form-control" disabled>
                            <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                <option value="<?php echo $row['career_id']; ?>" <?php if ($row['career_id'] == $career_id) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="edit">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>