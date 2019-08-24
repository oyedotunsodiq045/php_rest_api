<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Method, Authorization, X-Requested-With");
    
    // include database and object files
    include_once '../../config/Database.php';
    include_once '../../objects/Category.php';
    
    // instantiate database and connect
    $database  =  new Database();
    $db        =  $database->getConnection();
    
    // instantiate category object
    $category = new Category($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // make sure data is not empty
    if (! empty($data->name) 
        && ! empty($data->description) 
    ) { // set category property values
        $category->name = $data->name;
        $category->description = $data->description;
        $category->created = date('Y-m-d H:i:s');
    
        // create the category
        if ($category->create()) {
    
            // set response code - 201 created
            http_response_code(201);
    
            // tell the user
            echo json_encode(
                array("message" => "Category created.")
            );
        } else { // if unable to create the category, tell the user
    
            // set response code - 503 service unavailable
            http_response_code(503);
    
            // tell the user
            echo json_encode(
                array("message" => "Category Not Created.")
            );
        }
    } else { // tell the user data is incomplete
    
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
        echo json_encode(
            array("message" => "Category Not Created. Incomplete Data.")
        );
    }
?>