<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Method, Authorization, X-Requested-With");
    
    // include database and object files
    include_once '../../config/Database.php';
    include_once '../../objects/Product.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare product object
    $product = new Product($db);
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of product to be edited
    $product->id = $data->id;
    
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    
    // update the product
    if ($product->update()) {
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(
            array("message" => "Product Updated.")
        );
    } else { // if unable to update the product, tell the user
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(
            array("message" => "Product Not Updated.")
        );
    }
?>