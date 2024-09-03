<?php
session_start();
include("../db.php");

$message = '';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT user.user_id, user.email, user.password, user.name, user.photo, user.career_id, career.name AS career_name FROM user INNER JOIN career ON user.career_id = career.career_id WHERE user.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $password = $row['password'];
        $name = $row['name'];
        $photo = $row['photo'];
        $career_id = $row['career_id'];
        $career_name = $row['career_name'];
    }
} else {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {
        $photo_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_path = "../img/profiles/{$user_id}.{$photo_ext}";

        if ($_FILES['photo']['size'] <= 300 * 1024 && in_array($photo_ext, ['jpeg', 'jpg', 'png'])) {
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);

            $stmt = $conn->prepare("UPDATE user SET photo = ? WHERE user_id = ?");
            $stmt->bind_param("si", $photo_path, $user_id);
            $stmt->execute();
            $message = 'Foto de perfil actualizada con éxito.';
        } elseif ($_FILES['photo']['size'] > 300 * 1024 && in_array($photo_ext, ['jpeg', 'jpg', 'png'])) {
            $message = 'El tamaño de la foto de perfil debe ser menor o igual a 300 KB.';
        } elseif (!in_array($photo_ext, ['jpeg', 'jpg', 'png'])) {
            $message = 'La foto de perfil debe ser un archivo JPEG, JPG o PNG.';
        } else {
            $message = 'Ocurrió un error al subir la foto de perfil.';
        }
    }

    if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        if (password_verify($current_password, $password)) {
            if (strlen($new_password) < 8 || !preg_match('/[a-zA-Z]/', $new_password) || !preg_match('/\d/', $new_password)) {
                $message = 'La nueva contraseña debe tener al menos 8 caracteres y contener al menos 1 letra y 1 número.';
            } elseif ($new_password === $confirm_new_password) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE user SET password = ? WHERE user_id = ?");
                $stmt->bind_param("si", $hashed_password, $user_id);
                $stmt->execute();
                $message = 'Contraseña actualizada con éxito.';
            } else {
                $message = 'Las nuevas contraseñas no coinciden.';
            }
        } else {
            $message = 'Contraseña actual incorrecta.';
        }
    }

    $_SESSION['message'] = $message;
    header("Location: user_edit.php");
    exit();
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

include("../includes/header.php");
?>

<div class="container-fluid" style="background-image: url('../img/auth-bg.jpg'); background-size: cover;">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-6 col-lg-4">
            <div class="card card-user-edit card-body text-center shadow-lg">
                <h2 class="mb-4">Editar Perfil</h2>
                <form action="user_edit.php?user_id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
                    <div class="form-group mb-2">
                        <a href="#" class="user-edit rounded-circle rounded-circle-user-edit" width="150" height="150" data-bs-toggle="modal" data-bs-target="#changePhotoModal"><img src="<?php echo htmlspecialchars($photo); ?>" class="rounded-circle rounded-circle-user-edit" width="150" height="150" alt="Foto de Perfil del Usuario"></a>
                        <div class="pt-2 text-center fs-5 fw-bold">
                            <?php echo htmlspecialchars($name); ?>
                        </div>
                        <div class="text-center">
                            <?php echo htmlspecialchars($career_name); ?>
                        </div>
                        <div class="text-left fst-italic">
                            <?php echo htmlspecialchars($email); ?>
                        </div>
                    </div>
                    <?php if ($message === 'Foto de perfil actualizada con éxito.' || $message === 'Contraseña actualizada con éxito.') : ?>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-8">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $message ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif (!empty($message)): ?>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-8">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?= $message ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button type="button" class="btn btn-primary green-btn mt-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePhotoModal" tabindex="-1" role="dialog" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-user-edit">
            <div class="modal-header modal-header-user-edit">
                <h5 class="modal-title modal-title-user-edit" id="changePhotoModalLabel">Cambiar Foto de Perfil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-user-edit">
                <form action="user_edit.php?user_id=<?php echo htmlspecialchars($user_id); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="mb-2" for="photo">Seleccionar nueva foto de perfil (máx. 300 KB)</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept=".jpeg,.jpg,.png" required>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-primary green-btn" name="edit">Actualizar Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-user-edit">
            <div class="modal-header modal-header-user-edit">
                <h5 class="modal-title modal-title-user-edit" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-user-edit">
                <form action="user_edit.php?user_id=<?php echo htmlspecialchars($user_id); ?>" method="POST">
                    <div class="form-group m-3 mt-2 position-relative">
                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Contraseña Actual" required>
                        <button type="button" id="toggleCurrentPassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle rounded-circle-user-edit" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group m-3 mt-2 position-relative">
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Nueva Contraseña" required>
                        <button type="button" id="toggleNewPassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle rounded-circle-user-edit" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group m-3 mt-2 position-relative">
                        <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Repetir Nueva Contraseña" required>
                        <button type="button" id="toggleConfirmPassword" class="btn btn-sm btn-outline-secondary position-absolute border-0 rounded-circle rounded-circle-user-edit" style="right: 10px; top: 50%; transform: translateY(-50%);">
                            <i id="toggleIcon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary green-btn mt-3">Actualizar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
    const currentPassword = document.getElementById('current_password');
    const toggleCurrentPasswordIcon = document.getElementById('toggleCurrentPasswordIcon');

    toggleCurrentPassword.addEventListener('click', function() {
        const type = currentPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        currentPassword.setAttribute('type', type);

        if (type === 'password') {
            toggleCurrentPasswordIcon.classList.remove("fa-eye-slash");
            toggleCurrentPasswordIcon.classList.add("fa-eye");
        } else {
            toggleCurrentPasswordIcon.classList.remove("fa-eye");
            toggleCurrentPasswordIcon.classList.add("fa-eye-slash");
        }
    });

    const toggleNewPassword = document.getElementById('toggleNewPassword');
    const newPassword = document.getElementById('new_password');
    const toggleNewPasswordIcon = document.getElementById('toggleNewPasswordIcon');

    toggleNewPassword.addEventListener('click', function() {
        const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        newPassword.setAttribute('type', type);

        if (type === 'password') {
            toggleNewPasswordIcon.classList.remove("fa-eye-slash");
            toggleNewPasswordIcon.classList.add("fa-eye");
        } else {
            toggleNewPasswordIcon.classList.remove("fa-eye");
            toggleNewPasswordIcon.classList.add("fa-eye-slash");
        }
    });

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('confirm_new_password');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);

        if (type === 'password') {
            toggleConfirmIcon.classList.remove("fa-eye-slash");
            toggleConfirmIcon.classList.add("fa-eye");
        } else {
            toggleConfirmIcon.classList.remove("fa-eye");
            toggleConfirmIcon.classList.add("fa-eye-slash");
        }
    });
</script>

<?php include("../includes/footer.php") ?>