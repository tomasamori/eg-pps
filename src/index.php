<?php session_start(); ?>
<?php include("includes/header.php") ?>

<style>
    
    body {
        background-color: #f3f5fc;
    }

    .banner {
        background-color: #f8f9fa;
        background: rgb(9, 121, 35);
        background: linear-gradient(90deg, rgba(9, 121, 35, 0.5998774509803921) 0%, rgba(0, 212, 255, 1) 100%);
    }

    .banner img {
        max-width: 100%;
        height: auto;
    }

    .banner-text {
        padding-left: 10%;
    }

    @media (max-width: 768px) {
        .banner img {
            display: none;
        }

        .banner-text {
            padding-left: 0;
            text-align: center;
        }

        .banner {
            padding: 10%;
        }
    }

    .bellow-btn a {
        color: white;
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .bellow-btn a:hover {
        background-color: #49AD6D;
        border-color: #49AD6D;
    }

</style>

<div class="container banner rounded-5 mt-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 banner-text">
                <h1 class="display-6 fw-bold">Prácticas Profesionales Supervisadas</h1>
                <p class="lead">Tu espacio para seguir y documentar tus Prácticas Profesionales Supervisadas.</p>
                <a href="./auth/signup.php" class="btn btn-dark btn-lg">Iniciar PPS</a>
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
        <div class="bellow-btn">
            <a href="./auth/signup.php" class="btn btn-dark btn-lg">Comienza tu Solicitud</a>
        </div>
    </div>
</div>




<!--

<div class="container-fluid">
    <div class="row">
        <div class="fs">
            <div class="row align-items-center">
                <div class="col-md-6 mr-6">
                    <div class="p-4">
                        <h2>SISTEMA DE PPS - UTN FACULTAD REGIONAL ROSARIO</h2>
                        <p style="text-align: justify;">
                            En este espacio, tendrás la oportunidad de gestionar tus prácticas profesionalizantes supervisadas de manera eficiente y organizada. Nuestro sistema te brinda las herramientas necesarias para coordinar tus actividades, realizar seguimientos detallados y mantener un registro preciso de tu progreso académico.
                            Con nuestra plataforma, podrás acceder a información relevante sobre tus prácticas, como fechas importantes, detalles de la empresa o institución donde realizarás la práctica, y los objetivos específicos que deberás alcanzar. Además, contarás con la posibilidad de comunicarte con tus tutores y supervisores de manera rápida y sencilla, facilitando así la coordinación y el intercambio de información.
                            Estamos comprometidos a brindarte una experiencia fluida y satisfactoria en la gestión de tus prácticas profesionalizantes supervisadas. ¡Explora nuestras funcionalidades y comienza a aprovechar al máximo esta herramienta diseñada para tu crecimiento académico y profesional!</p>
                        <a href="auth/login.php" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <img src="img/home.png" alt="Imagen" class="img-fluid w-100">
                </div>
            </div>
        </div>
    </div>
</div>
-->

<?php include("includes/footer.php") ?>