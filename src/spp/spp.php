<?php session_start(); ?>
<?php include("../db.php") ?>
<?php include("../includes/header.php");
$message = ''
?>
<br>
<div class="container p-4 bg-light rounded" style="font-family: 'Arial', sans-serif;">
    <h1 class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
            <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z" />
            <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5" />
        </svg>
        Nueva Solicitud de PPS
    </h1>
    <br>
    <h4>Recuerde que para poder realizar las PPS debe</h4>
    <p>
        Tener regulares todas y cada una de las siguientes asignaturas: <strong>Administración de Recursos, Ingeniería de Software, Legislación, Redes de Información.</strong>
        Tener aprobadas todas y cada una de las siguientes asignaturas: <strong>Comunicaciones, Diseño de Sistemas, Economía, Gestión de Datos, Ingeniería y Sociedad, Inglés ll, Probabilidades y Estadísticas, Sistemas de Representación, Sistemas Operativos.</strong>
    </p>
    <form action="spp_create.php" method="POST">
        <h3>Datos de la Entidad/Organización/Institución</h3>

        <div class="row">
            <div class="col-md-6 p-2">
                <input type="text" id="organization_name" name="organization_name" class="form-control" placeholder="Nombre de la Organización" required>
            </div>
            <div class="col-md-6 p-2">
                <input type="text" id="organization_address" name="organization_address" class="form-control" placeholder="Dirección" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-2">
                <input type="text" id="organization_city" name="organization_city" class="form-control" placeholder="Localidad" required>
            </div>
            <div class="col-md-6 p-2">
                <input type="text" id="organization_state" name="organization_state" class="form-control" placeholder="Provincia" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-2">
                <input type="number" id="organization_zip" name="organization_zip" class="form-control" placeholder="Código Postal" required>
            </div>
            <div class="col-md-6 p-2">
                <input type="number" id="organization_phone" name="organization_phone" class="form-control" placeholder="Teléfono" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-2">
                <input type="email" id="organization_email" name="organization_email" class="form-control" placeholder="Email de la Organización" required>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-md" name="pps_create">Enviar Solicitud</button>
            </div>
        </div>
        <br>
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php session_unset(); ?>
        <script>
            setTimeout(function() {
                window.location.href = '../index.php';
            }, 4000);
        </script>
        <?php } ?>
        <br>
    </form>
</div>
<br>
<br>
<?php include("../includes/footer.php") ?>