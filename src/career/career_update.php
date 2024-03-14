<?php session_start(); ?>
<?php
include("../db.php");

if (isset($_GET['career_id'])) {
    $career_id = $_GET['career_id'];
    $query = "SELECT * FROM career WHERE career_id = $career_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $name = $row['name'];
    }
}

if (isset($_POST['update'])){
    $career_id = $_GET['career_id'];
    $name = $_POST['name'];

    $query = "UPDATE career SET name='$name' WHERE career_id = $career_id";
    mysqli_query($conn, $query);

    $_SESSION['message'] = 'Carrera editada exitosamente';
    $_SESSION['message_type'] = 'success';
    header("Location: career.php");
}
?>

<?php include("../includes/header.php") ?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="career_update.php?career_id=<?php echo $_GET['career_id']; ?>" method="POST">
                    <div class="form-group m-2">
                        <input type="text" name="name" value="<?php echo $name ?>" class="form-control" placeholder="Actualizar nombre de la Carrera">
                    </div>
                    <button class="btn btn-success btn-block mx-auto d-block" name="update">
                        Editar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>