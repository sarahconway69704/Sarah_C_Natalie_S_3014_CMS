<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/database.php';
include_once '../objects/product.php';


$db       = Database::getInstance()->getConnection();

$product = new Product($db);


if (isset($_GET['id'])) {
    $stmt = $product->getProductByID($_GET['id']);
} else if(isset($_GET['category'])){
    $stmt = $product->getProductByCategory($_GET['category']);
}else {
    $stmt = $product->getProducts();
}

$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // movies array
    $results = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $single_product = $row;
        $results[]    = $single_product;
    }

    //TODO:chat about JSON_PRETTY_PRINT vs not
    echo json_encode($results, JSON_PRETTY_PRINT);
} else {
    echo json_encode(
        array(
            "message" => "No products found.",
        )
    );
}
