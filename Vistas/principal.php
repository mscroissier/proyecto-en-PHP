<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">

    <title>examen</title>
</head>
<style>
    a {
        text-decoration: none;
        color: black;
    }
</style>
<body>
<?php
include('../Controllers/incidenceController.php');
session_start();

// instanciamos controller
$incidenceController = new IncidenceController();
// $fp = fopen("usuarios.txt", "r");

if (($_POST['text']="Fernando" || $_POST['text']="Matias"  || $_POST['text']="Soldado")) {
    $_SESSION['persona'] = $_POST['nombre'];



?>



    <div class="text-center">
        <h1>Perfil Administrador: <?= $_SESSION['persona']?></h1>
    </div>

    <!-- para ADMIN -->
    <?php
    // UPDATE (reparada)
    if (isset($_POST['incidence-id-to-update']) && isset($_POST['admin'])) { //si llega la variable de sesion con un admin cogemos este y lo insertamos en la bd como reparador

        //  Realizar una conexion a base de datos mediante usando PDO
        $conexion = new PDO("mysql:host=localhost;dbname=fruteria", "root", ""); //los campos vacios son usuario y contraseña respectivamente
        $id = $_POST['incidence-id-to-update'];
        $admin = $_SESSION(['']);

        $incidencias = new incidence(null, null, null, null, null, $admin);
        $incidenceController->update($id, $incidencias);
        $conexion = null;
    }
    // DELETE 
    if (isset($_GET['incidence-id-to-delete'])) {
        $id = $_GET['incidence-id-to-delete'];
        $incidenceController->delete($id);
        $conexion = null;
    }

    ?>

    <div class="container">
        <table class="table">
            <tr>
                <td>Descripción</td>
                <td>Profesor</td>
                <td>Fecha</td>
                <td>Estado</td>
                <td>Reparador</td>
                <td></td>
                <td></td>
            </tr>

            <?php
            // Llamar al controlador para que nos devuelva un array de incidencias
            $arrayIncidencias = $incidenceController->getAll();
            foreach ($arrayIncidencias as $incidencia) {
            ?>
                <tr>
                    <td><?= $incidencia->getDescripcion() ?></td>
                    <td><?= $incidencia->getProfesor() ?></td>
                    <td><?= $incidencia->getFecha() ?></td>
                    <td><?= $incidencia->getEstado() ?></td>
                    <td><?= $incidencia->getAdmin() ?></td>


                    <?php
                    $urlEliminarIncidencia =  "principal.php?incidence-id-to-delete=" . $incidencia->getId();
                    $urlEditarIncidencia =  "principal.php?&incidence-id-to-update=" . $incidencia->getId();
                    ?>
                    <td><button class="btn-danger"><a href="<?= $urlEliminarIncidencia ?>">Eliminar</a> </button></td>
                    <td><button class="btn-warning"><a href="<?= $urlEditarIncidencia ?>">Reparada</a></button></td>
                </tr>

            <?php   } ?>
        </table>
        <hr>

    </div>

    <?php   } ?>

    <!-- para USUARIOS -->



    <?php
    if (isset($_POST['descripcion']) && isset($_POST['fecha']) && isset($_POST['nombre'])) {

        //  Realizar una conexion a base de datos mediante usando PDO
        $conexion = new PDO("mysql:host=localhost;dbname=mantenimiento", "root", ""); //los campos vacios son usuario y contraseña respectivamente
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha'];
        $profesor = $_POST['nombre'];

        $incidencia = new incidence(null, $description, $fecha, $profesor, null, null);
        $incidenceController->insert($incidencia);
        $conexion = null;
    }

    ?>




    <!-- pasar por una variable sesion el nombre del usuario y meterlo enel array nombre -->

    <form action="principal.php" method="get">
        <input type="hidden" name="id" value="<?php echo $nombre ?>">
        fecha: <input type="date" name="fecha" id="fecha"> </br>
        <p>Nueva Incidencia</p>
        <textarea name="nuevaIndicencia" id="nuevaIncidencia" cols="30" rows="10"></textarea>
        </br>
        <input type="submit" value="REGISTRAR">
    </form>
    <hr>
    <table class="table">
        <tr>
            <td>Descripción</td>
            <td>Profesor</td>
            <td>Fecha</td>

        </tr>
        <?php
        // Llamar al controlador para que nos devuelva un array de incidencias
        $arrayIncidencias = $incidenceController->getAll();
        foreach ($arrayIncidencias as $incidencia) {
        ?>
            <tr>
                <td><?= $incidencia->getDescripcion() ?></td>
                <td><?= $incidencia->getProfesor() ?></td>
                <td><?= $incidencia->getFecha() ?></td>

            </tr>

        <?php   } ?>
    </table>
    <hr>



</body>

</html>