<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    // include database and object files
    include_once '../../config/Database.php';
    include_once '../../objects/Product.php';
    
    // instantiate database and connect
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize object
    $product = new Product($db);
    
    // query products
    $stmt = $product->read();
    // Get row count
    $num = $stmt->rowCount();
    
    // check if more than 0 record found
    if ($num > 0) {
    
        // products array
        $products_arr = array();
        $products_arr["records"] = array();
    
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);
    
            $product_item = array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
                "category_id" => $category_id,
                "category_name" => $category_name
            );
    
            array_push($products_arr["records"], $product_item);
        }
    
        // set response code - 200 OK
        http_response_code(200);
    
        // show products data in json format
        echo json_encode(
            array(
                "status" => true,
                "status" => "Products found",
                // "status" => $products_arr['records']
                "status" => $products_arr
            )
        );
    } else {
    
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array(
                "status" => false,
                "message" => "No product found."
            )
        );
    }  