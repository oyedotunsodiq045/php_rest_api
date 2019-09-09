<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Method, Authorization, X-Requested-With");
    
    // include database and object file
    include_once '../../config/Database.php';
    include_once '../../objects/Product.php';
    
    // instantiate database and connect
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare product object
    $product = new Product($db);
    
    // get product id
    $data = json_decode(file_get_contents("php://input"));
    
    // set product id to be deleted
    $product->id = $data->id;
    
    // delete the product
    if ($product->delete()) {
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(
            array(
                "status" => true,
                "message" => "Product Deleted."
            )
        );
    } else { // if unable to delete the product
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(
            array(
                "status" => false,
                "message" => "Product Not Deleted."
            )
        );
    }
?>