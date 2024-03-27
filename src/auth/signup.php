<?php
session_start();

if (isset ($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require '../db.php';

$message = '';

$emailValue = isset ($_POST['email']) ? $_POST['email'] : '';
$passwordValue = isset ($_POST['password']) ? $_POST['password'] : '';
$confirmPasswordValue = isset ($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$nameValue = isset ($_POST['name']) ? $_POST['name'] : '';
$careerIdValue = isset ($_POST['career_id']) ? $_POST['career_id'] : '';

if (!empty ($_POST['email']) && !empty ($_POST['password']) && !empty ($_POST['confirm_password'])) {
    $query = "SELECT email FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $message = 'El correo electrónico ya está registrado';
    } else {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $message = 'Las contraseñas no coinciden';
        } elseif (strlen($_POST['password']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['password']) || !preg_match('/\d/', $_POST['password'])) {
            $message = 'La contraseña debe tener al menos 8 caracteres y contener al menos 1 letra y 1 número';
        } else {
            $query = "SELECT role_id FROM role WHERE name = 'Alumno'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $role_id = $row['role_id'];

                $sql = "INSERT INTO user (email, password, name, career_id, role_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $stmt->bind_param('ssssi', $_POST['email'], $hashed_password, $_POST['name'], $_POST['career_id'], $role_id);

                if ($stmt->execute()) {
                    $message = 'Usuario creado exitosamente. Redirigiendo...';
                } else {
                    $message = 'Hubo un problema al crear tu cuenta';
                }
            } else {
                $message = 'No se encontró el rol "Alumno"';
            }
        }
    }
}

include ('../includes/header.php'); ?>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-3">
            <div class="card card-body text-center shadow-lg">
                <form action="signup.php" method="POST">
                    <img src="../img/utn-logo.png" alt="Logo UTN" class="navbar-brand-img mt-4 mb-4 img-fluid"
                        style="max-height: 70px;">
                    <div class="form-group m-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required
                            value="<?php echo $emailValue; ?>">
                    </div>
                    <div class="form-group m-2">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required
                            value="<?php echo $passwordValue; ?>">
                    </div>
                    <div class="form-group m-2">
                        <input type="password" name="confirm_password" class="form-control"
                            placeholder="Confirme su Contraseña" required value="<?php echo $confirmPasswordValue; ?>">
                    </div>
                    <div class="form-group m-2">
                        <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required
                            value="<?php echo $nameValue; ?>">
                    </div>
                    <?php
                    $query = "SELECT * FROM career";
                    $result_career = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group m-2">
                        <select name="career_id" class="form-control" required>
                            <option value="">Seleccione una carrera</option>
                            <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                <option value="<?php echo $row['career_id']; ?>" <?php if ($row['career_id'] == $careerIdValue)
                                       echo 'selected'; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if (!empty ($message)): ?>
                        <br>
                        <?php if ($message === 'Usuario creado exitosamente. Redirigiendo...'): ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-10">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= $message ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($message === 'Usuario creado exitosamente. Redirigiendo...'): ?>
                        <script>
                            setTimeout(function () {
                                window.location.href = 'login.php';
                            }, 4000);
                        </script>
                    <?php endif; ?>
                    <br>
                    <input type="submit" class="btn btn-success btn-block mx-auto d-block" name="signup"
                        value="Registrarse">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include ('../includes/footer.php'); ?>