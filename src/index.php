<?php session_start(); ?>
<?php include("includes/header.php") ?>

<div class="container banner rounded-5 mt-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 banner-text">
                <h1 class="display-6 fw-bold">Prácticas Profesionales Supervisadas</h1>
                <p class="lead">Tu espacio para seguir y documentar tus Prácticas Profesionales Supervisadas.</p>
                <?php if (isset($_SESSION["user_id"])) { ?>
                    <a href="./spp/spp_main.php" class="btn btn-dark btn-lg">Iniciar PPS</a>
                <?php } else { ?>
                    <a href="./auth/login.php" class="btn btn-dark btn-lg">Iniciar PPS</a>
                <?php } ?>

            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="./img/student.png" alt="Estudiante sosteniendo una carpeta">
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-stretch">
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-light h-100">
                <img src="./img/register_card.jpg" class="card-img-top" alt="Imagen de Registro de PPS">
                <div class="card-body">
                    <h5 class="card-title">Registro de Inicio de PPS</h5>
                    <p class="card-text">Inicia el proceso de tus Prácticas Profesionales Supervisadas registrando tu solicitud en la plataforma. Completa los datos necesarios para comenzar tu PPS.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-light h-100">
                <img src="./img/monitoring_card.jpg" class="card-img-top" alt="Imagen de Seguimiento y Tutoría">
                <div class="card-body">
                    <h5 class="card-title">Seguimiento y Tutoría</h5>
                    <p class="card-text">Permite a los responsables y tutores seguir de cerca tu progreso. Recibe feedback y asegúrate de cumplir con los requisitos necesarios a lo largo del proceso.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-light h-100">
                <img src="./img/documentation_card.jpg" class="card-img-top" alt="Imagen de Documentación y Aprobación">
                <div class="card-body">
                    <h5 class="card-title">Documentación y Aprobación</h5>
                    <p class="card-text">Sube tus informes, planes de trabajo y seguimientos semanales para su revisión. El sistema facilitará la aprobación y la comunicación entre todos los involucrados.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <?php if (isset($_SESSION["user_id"])) { ?>
            <a href="./spp/spp_main.php" class="btn btn-dark btn-lg green-btn">Comienza tu Solicitud</a>
        <?php } else { ?>
            <a href="./auth/login.php" class="btn btn-dark btn-lg green-btn">Comienza tu Solicitud</a>
        <?php } ?>
    </div>
</div>

<?php include("includes/footer.php") ?>