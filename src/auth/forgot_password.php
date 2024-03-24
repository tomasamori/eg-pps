<?php include("../includes/header.php") ?>

<h1>Recuperar contraseña</h1>

<form action="send_password_reset.php" method="post">
    <div class="form-group">
        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su Email">
    </div>
    <button type="submit" class="btn btn-primary">Recuperar contraseña</button>
</form>

<?php include("../includes/footer.php") ?>