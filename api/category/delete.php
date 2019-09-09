<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Method, Authorization, X-Requested-With");
    
    // include database and object file
    include_once '../../config/Database.php';
    include_once '../../objects/Category.php';
    
    // instantiate database and connect
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare category object
    $category = new Category($db);
    
    // get category id
    $data = json_decode(file_get_contents("php://input"));
    
    // set category id to be deleted
    $category->id = $data->id;
    
    // delete the category
    if ($category->delete()) {
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(
            array(
                "status" => true,
                "message" => "Category Deleted."
            )
        );
    } else { // if unable to delete the category
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(
            array(
                "status" => false,
                "message" => "Category Not Deleted."
            )
        );
    }
?>