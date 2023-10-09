<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1> ejemplo de select</h1>

<?php

// termianr ejemplo select usan mvc.

include('../Controllers/ProductController.php');
$productController = new ProductController();
$arrayProductos = $productController->getAll();



echo '<select name="selectProduct" id="selectProduct">';
foreach ($arrayProductos as $product) {
   
echo '<option value="' .$product->getCode(). '">' .$product->getCode(). '</option>';
echo '<option value="'. $product->getDescription().'">'. $product->getDescription().'</option>';
echo '<option value="'. $product->getSellPrice() .'">'. $product->getSellPrice() .'</option>';
echo '<option value="'. $product->getBuyPrice() .'">'. $product->getBuyPrice() .'</option>';
echo '<option value="'. $product->getStock() .'">'. $product->getStock() .'</option>';

}
echo '</select>';

 ?>
</body>

</html>