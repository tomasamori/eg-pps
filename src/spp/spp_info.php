<?php session_start();
include("../includes/header.php"); ?>

<style>

    body {
        background-image: url("../img/auth-bg.jpg");
    }

    h1 {
        color: #3aa661;
        text-align: center;
    }

    .document-section {
        margin-bottom: 20px;
    }

    .document-section h2 {
        color: #ffffff;
        background-color: #3aa661;
        padding: 10px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        margin: 0;
    }

    .document-section p {
        padding: 10px;
        background-color: #f1f3f9;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .green-btn {
        color: white;
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .green-btn:hover {
        background-color: #49AD6D;
        border-color: #49AD6D;
    }
</style>

<div class="container" style="max-width: 800px; margin: 50px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h1 class="mb-4">Documentos que Debes Cargar</h1>

    <div class="document-section">
        <h2>Plan de Trabajo</h2>
        <p>Este documento debe detallar las tareas que se realizarán durante los próximos 30 días. Es importante que el plan cubra un total de 200 horas de trabajo, distribuidas en 5 días de 4 horas por semana. El Plan de Trabajo servirá como guía para mantener el enfoque y la organización durante el período de evaluación.</p>
    </div>

    <div class="document-section">
        <h2>Informe Semanal</h2>
        <p>Cada semana, deberás cargar un informe que documente cualquier desviación del plan de trabajo previsto y otras cuestiones relevantes. Estos informes semanales te ayudarán a reflexionar sobre tu progreso y a realizar los ajustes necesarios para mantener el rumbo.</p>
    </div>

    <div class="document-section">
        <h2>Informe Final</h2>
        <p>Al finalizar el período, deberás entregar un informe final que resuma tu experiencia completa. Este documento es fundamental, ya que servirá como una reflexión final sobre los logros alcanzados, los desafíos enfrentados y las conclusiones que puedas extraer de la experiencia.</p>
    </div>

    <!-- Go back centered button -->
    <div class="text-center">
        <a href="spp.php" class="btn btn-secondary green-btn">Volver</a>
    </div>
</div>

<?php include("../includes/footer.php"); ?>