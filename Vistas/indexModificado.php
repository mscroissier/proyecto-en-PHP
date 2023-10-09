<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">

    <title>Gestisimal</title>
</head>
<style>
    a {
        text-decoration: none;
        color: black;
    }
</style>

<?php
include('../Controllers/ProductController.php');

// instanciamos controller
$productController = new ProductController();
// Si me llega por $_POST  cada uno de los atributos del nuevo producto y no me llega id, recogerlos y realizar una inserccion en base datos.

if (!isset($_POST['id']) && isset($_POST['code']) && isset($_POST['description']) && isset($_POST['buy_price']) && isset($_POST['sell_price']) && isset($_POST['stock'])) {

    //  Realizar una conexion a base de datos mediante usando PDO
    $conexion = new PDO("mysql:host=localhost;dbname=fruteria", "root", ""); //los campos vacios son usuario y contraseña respectivamente
    $code = $_POST['code'];
    $description = $_POST['description'];
    $buy = $_POST['buy_price'];
    $sell = $_POST['sell_price'];
    $stock = $_POST['stock'];

    $producto = new product(null, $code, $description, $buy, $sell, $stock);
    $productController->insert($producto);
    $conexion = null;
}
// INSERT UPDATE
else if (isset($_POST['id']) && isset($_POST['code']) && isset($_POST['description']) && isset($_POST['buy_price']) && isset($_POST['sell_price']) && isset($_POST['stock'])) {

    //  Realizar una conexion a base de datos mediante usando PDO
    $conexion = new PDO("mysql:host=localhost;dbname=fruteria", "root", ""); //los campos vacios son usuario y contraseña respectivamente
    $id = $_POST['id'];
    $code = $_POST['code'];
    $description = $_POST['description'];
    $buy = $_POST['buy_price'];
    $sell = $_POST['sell_price'];
    $stock = $_POST['stock'];

    $producto = new product(null, $code, $description, $buy, $sell, $stock);
    $productController->update($id, $producto);
    $conexion = null;
}


// Si me llega por $_GET un paramatro llamado product-id-to-delete significa que tengo que eliminar el producto con ese id

if (isset($_GET['product-id-to-delete'])) {
    $id = $_GET['product-id-to-delete'];
    $productController->borrar($id);
    $conexion = null;
}





// Aqui vamos a reliazar las acciones de añadir 1 al stock (entrada) o quitar un 1 de stock (SALIDA.)

if (isset($_GET['product-id-to-enter'])) {
    $id = $_GET['product-id-to-enter'];
    $productController->entrada($id);
    $conexion = null;
}
if (isset($_GET['product-id-to-exit'])) {
    $id = $_GET['product-id-to-exit'];
    $productController->salida($id);
    $conexion = null;
}
$regPorPag = 3;
$numRegistros = $productController->getNumRegistros();
$paginacion = $numRegistros / $regPorPag;
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 0;

?>

<body>
    <!-- <form action="index.php" method="post"> -->

    <div class="text-center">
        <h1>Gestisimal</h1>
    </div>
    <div class="container">
        <table class="table">
            <tr>
                <td>Código</td>
                <td>Descripción</td>
                <td>Precio de compra</td>
                <td>Precio de venta</td>
                <td>Margen</td>
                <td>Stock</td>
                <td>acciones</td>
            </tr>
            <?php

            // Llamar al controlador para que nos devuelva un array de productos
            $arrayProductos = $productController->getAll($pagina, $regPorPag);


            foreach ($arrayProductos as $product) {
            ?>
                <tr>
                    <td><?= $product->getCode() ?></td>
                    <td><?= $product->getDescription() ?></td>
                    <td><?= $product->getSellPrice() ?></td>
                    <td><?= $product->getBuyPrice() ?></td>
                    <td><?= $product->getMargin() ?></td>
                    <td><?= $product->getStock() ?></td>

                    <?php
                    $urlEliminarProducto =  "indexModificado.php?product-id-to-delete=" . $product->getId();
                    $urlEditarProducto =  "indexModificado.php?pagina=" . $pagina . "&product-id-to-update=" . $product->getId();
                    $urlEntrada =  "indexModificado.php?pagina=" . $pagina . "&product-id-to-enter=" . $product->getId();
                    $urlSalida =  "indexModificado.php?pagina=" . $pagina . "&product-id-to-exit=" . $product->getId();
                    ?>
                    <td><button class="btn-danger"><a href="<?= $urlEliminarProducto ?>">Eliminar</a> </button></td>
                    <td><button class="btn-warning"><a href="<?= $urlEditarProducto ?>">Editar</a></button></td>

                    <td><button class="btn-info"><a href="<?= $urlEntrada ?>">Entrada</a></button></td>
                    <td><button class="btn-info"><a href="<?= $urlSalida ?>">Salida</a></button></td>
                </tr>

            <?php   } ?>
        </table>
        <hr>

        <?php



        echo '<nav aria-label="...">';
        echo '<ul class="pagination">';
        for ($i = 0; $i < $paginacion; $i++) {
            $paginado = $i + 1;
            $URLpagina = "indexModificado.php?pagina=" . $i;
            echo '<li class="page-item"><a class="page-link" href="' . $URLpagina . '">' . $paginado . '</a></li>';
        }
        ?>
        </ul>
        </nav>
        <hr>
        <h5><?= isset($_GET['product-id-to-update']) ? 'Editar' : 'Crear' ?> Producto</h1>
            <?php isset($_GET['product-id-to-update']) ? $id = $_GET['product-id-to-update'] : null ?>
            <form action="indexModificado.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id ?>">




                <input type="text" required name="code" id="code" placeholder="code" value="<?= $product ? $product->getCode() : null ?>">
                <input type="text" required name="description" id="description" placeholder="description" value="<?= $product ? $product->getDescription() : null ?>">
                <input type="number" required name="buy_price" id="buy_price" placeholder="buy_price" value="<?= $product ? $product->getBuyPrice() : null ?>">
                <input type="number" required name="sell_price" id="sell_price" placeholder="sell_price" value="<?= $product ? $product->getSellPrice() : null ?>">
                <input type="text" required name="stock" id="stock" placeholder="stock" value="<?= $product ? $product->getStock() : null ?>">
                <button class="btn btn-success" type="submit" name="nuevo"><?= isset($_GET['product-id-to-update']) ? 'Editar' : 'Nuevo ' ?></button>

            </form>
            <button class="btn btn-danger"><a href="indexModificado.php">Cancelar</a></button>
            <a href="../Vistas/ejemploSelect.php">ir a ejemplo de selector</a>


    </div>


</body>

</html>