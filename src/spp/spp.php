<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_SESSION['role_name']) || ($_SESSION['role_name'] === 'Profesor' || $_SESSION['role_name'] === 'Responsable' || $_SESSION['role_name'] === 'Administrador')) {
    header("Location: ../spp/spp_list.php");
    exit();
}

include("../db.php");

$message = '';

$user_id = $_SESSION['user_id'];

$query = "SELECT spp.spp_id FROM spp 
          INNER JOIN spp_user ON spp.spp_id = spp_user.spp_id 
          WHERE spp_user.student_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        header('Location: ../spp/spp_main.php');
        exit;
    }
} else {
    echo "Error al ejecutar la consulta: " . mysqli_error($conn);
}

include("../includes/header.php");
?>

<div class="container my-5">
    <div class="bg-light p-5 rounded shadow-sm">
        <h1 class="text-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
                <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5" />
            </svg>
            Nueva Solicitud de PPS
        </h1>
        <div class="alert text-center" style="background-color: #b8e0c0; color: #2f4f4f;">
            <h5>Requisitos para realizar las Prácticas Profesionales Supervisadas:</h5>
            <p class="mb-0">Debe tener regulares las siguientes materias: <strong>Administración de Recursos, Ingeniería de Software, Legislación, Redes de Información.</strong></p>
            <p>Debe tener aprobadas las siguientes materias: <strong>Comunicaciones, Diseño de Sistemas, Economía, Gestión de Datos, Ingeniería y Sociedad, Inglés II, Probabilidades y Estadísticas, Sistemas de Representación, Sistemas Operativos.</strong></p>
        </div>
        <form action="spp_create.php" method="POST">
            <h3 class="text-center mb-4">Datos de la Entidad/Organización/Institución</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="organization_name" name="organization_name" class="form-control" placeholder="Nombre de la Organización" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="organization_address" name="organization_address" class="form-control" placeholder="Dirección" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="organization_city" name="organization_city" class="form-control" placeholder="Localidad" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="organization_state" name="organization_state" class="form-control" placeholder="Provincia" required>
                </div>
                <div class="col-md-6">
                    <input type="number" id="organization_zip" name="organization_zip" class="form-control" placeholder="Código Postal" required>
                </div>
                <div class="col-md-6">
                    <input type="number" id="organization_phone" name="organization_phone" class="form-control" placeholder="Teléfono" required>
                </div>
                <div class="col-md-6">
                    <input type="email" id="organization_email" name="organization_email" class="form-control" placeholder="Email de la Organización" required>
                </div>
                <div class="col-md-6">
                    <input type="text" id="organization_contact" name="organization_contact" class="form-control" placeholder="Persona de Contacto" required>
                </div>
            </div>
            <?php if (!isset($_SESSION['message'])) { ?>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-md green-btn" name="spp_create">Enviar Solicitud</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<?php include("../includes/footer.php"); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form');
        var submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitButton.disabled = true;
        });
    });
</script>